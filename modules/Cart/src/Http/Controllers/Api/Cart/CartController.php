<?php

namespace Modules\Cart\Http\Controllers\Api\Cart;

use Exception;
use Illuminate\Http\Request;
use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Orders\Models\OrderItem;
use Modules\Orders\Services\OrderService;
use Modules\Discounts\Services\DiscountService;

class CartController extends Controller
{
    protected OrderService $orderService;
    protected DiscountService $discountService;


    public function __construct(OrderService $orderService, DiscountService $discountService)
    {
        $this->orderService = $orderService;
        $this->discountService = $discountService;
    }

    public function viewDiscountForm(Request $request, $order_id)
    {

        $order = Order::where('id', $order_id)->first();
        return view('cart::cart.discount.form', compact('order'));
    }

    public function addDiscount(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'coupon_code' => 'required|string',
            ]);

            $order = Order::find($request->order_id);

            if ($this->discountService->validateCoupon($request->coupon_code, null, $order)) {

                $updatedOrder = $this->orderService->updateDiscount($order, $request->coupon_code);

                return response()->json([
                    'success' => true,
                    'message' => 'Discount Modified Successfully',
                    'order' => $updatedOrder
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => 'Invalidate Coupon Code'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function removeDiscount(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        try {
            $Order = Order::findOrFail($request->order_id);

            $Order->coupon_code  = '';
            $Order->discount     = 0;
            $Order->save();

            return response()->json([
                'success' => true,
                'message' => 'Coupon removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating quantity: ' . $e->getMessage()
            ]);
        }
    }

    // product
    public function updateItemQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:order_items,id',
            'quantity' => 'required|integer|min:1',
            'order_id' => 'required|exists:orders,id'
        ]);

        try {
            $item = OrderItem::findOrFail($request->item_id);

            // Verify the item belongs to the specified order
            if ($item->order_id != $request->order_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item does not belong to this order'
                ]);
            }

            $item->quantity = $request->quantity;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating quantity: ' . $e->getMessage()
            ]);
        }
    }

    public function viewItems(Request $request, $order_id)
    {

        $items = OrderItem::where('order_id', $order_id)->get();
        return view('cart::cart.items.form', compact('items', 'order_id'));
    }

    public function addItems(Request $request, $order_id)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|exists:products,id', // Validate each item as product ID
        ]);

        try {
            DB::beginTransaction();

            // Check if order exists
            if (!$order_id || $order_id === 'new') {
                // Create new order
                $order = $this->createNewOrder();
                $order_id = $order->id;
            } else {
                // Get existing order
                $order = Order::findOrFail($order_id);
            }

            $addedItems = [];
            $errors = [];

            foreach ($request->items as $productId) {
                try {
                    $product = Product::findOrFail($productId);

                    // Check if product already exists in order
                    $existingItem = OrderItem::where('order_id', $order_id)
                        ->where('product_id', $productId)
                        ->first();

                    if ($existingItem) {
                        // Update quantity if item already exists
                        $existingItem->quantity += 1; // Increment by 1
                        $existingItem->save();
                        $addedItems[] = $existingItem;
                    } else {
                        // Create new order item
                        $item = new OrderItem([
                            'order_id'      => $order_id,
                            'product_id'    => $productId,
                            'quantity'      => 1, // Default quantity
                            'price'         => $product->price,
                            'name'          => $product->name,
                            'sku'           => $product->sku,
                        ]);

                        $item->save();
                        $addedItems[] = $item;
                    }
                } catch (\Exception $e) {
                    $errors[] = [
                        'product_id' => $productId,
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order_id,
                'added_items' => count($addedItems),
                'errors' => $errors,
                'message' => count($addedItems) . ' items added successfully' . (count($errors) ? ' with ' . count($errors) . ' errors' : '')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error adding items: ' . $e->getMessage()
            ]);
        }
    }

    private function createNewOrder()
    {
        // Get the next order number
        $orderNumber = $this->generateOrderNumber();

        // Create a new order with default values
        $order = new Order([
            'order_number'  => $orderNumber,
            'user_id'       => '',
            'status'        => fn_get_setting('general.order.create'),
            'subtotal'      => 0,
            'tax_amount'    => 0,
            'discount'      => 0,
            'shipping'      => 0,
            'total'         => 0,
            'currency'      => fn_get_setting('general.currency'),
            'payment_status' => 'pending',
            'payment_method' => 'unpaid',
        ]);

        $order->save();

        return $order;
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'item_id'    => 'required|exists:order_items,id',
            'product_id' => 'required|exists:products,id',
            'order_id'   => 'required|exists:orders,id',
        ]);

        try {
            $item = OrderItem::findOrFail($request->item_id);

            // Verify item belongs to the specified order and product
            if ($item->order_id != $request->order_id || $item->product_id != $request->product_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid item request',
                ]);
            }

            $orderId = $item->order_id;

            // Delete the item
            $item->delete();

            // Check if order has any items left
            $remainingItems = OrderItem::where('order_id', $orderId)->count();

            if ($remainingItems === 0) {
                Order::where('id', $orderId)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed. Order deleted since no items remain.',
                    'redirect_url' => route('admin.orders.create'),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully',
                'order_deleted' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item: ' . $e->getMessage(),
            ], 500);
        }
    }
}
