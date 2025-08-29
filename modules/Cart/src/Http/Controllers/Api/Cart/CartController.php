<?php

namespace Modules\Cart\Http\Controllers\Api\Cart;

use Exception;
use Illuminate\Http\Request;
use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Catalog\Models\Product;
use Illuminate\Support\Facades\Hash;
use Modules\Orders\Models\OrderItem;
use Modules\Customers\Models\Address;
use function PHPUnit\Framework\callback;
use Modules\Orders\Services\OrderService;
use Modules\Discounts\Services\DiscountService;

use Modules\Customers\Http\Requests\StoreOrUpdateCustomerRequest;

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

    public function viewItems(Request $request, $order_id)
    {

        $items = OrderItem::where('order_id', $order_id)->get();
        return view('cart::cart.items.form', compact('items', 'order_id'));
    }

    public function viewCustomerForm(Request $request, $order_id)
    {
        $order = Order::with('user')->where('id', $order_id)->first();
        return view('cart::cart.customer.form', compact('order'));
    }

    public function profileUpdateForm(Request $request, $customer_id)
    {
        $customer = User::findOrFail($customer_id);

        return view('cart::cart.profile.form', compact('customer'));
    }

    public function updateCustomer(StoreOrUpdateCustomerRequest $request, $customer_id)
    {
        try {
            $customer = User::find($customer_id);
            DB::transaction(function () use ($request, $customer) {

                $this->saveCustomer($customer, $request);
                $this->saveAddresses($customer, $request);
            });
            $orderData = session()->get('orderData', []);

            $getCustomer = User::find($customer_id);
            $orderData['customer_details'] = [
                'id'        => $getCustomer->id,
                "name"      => $getCustomer->name,
                "email"     => $getCustomer->email,
                "phone"     => $getCustomer->phone
            ];


            $customer->load(['defaultBillingAddress', 'defaultShippingAddress']);

            $address = [
                'name'      => $customer->defaultBillingAddress->name ?? $customer->name,
                "email"     => $customer->defaultBillingAddress->email ?? $customer->email,
                "phone"     => $customer->defaultBillingAddress->phone ?? $customer->phone,
                "company"   => $customer->defaultBillingAddress->company ?? '',
                "city"      => $customer->defaultBillingAddress->city ?? '',
                "state"     => $customer->defaultBillingAddress->state ?? '',
                "country"   => $customer->defaultBillingAddress->country ?? '',
                "postcode"  => $customer->defaultBillingAddress->postcode ?? '',
                "address_1" => $customer->defaultBillingAddress->address_1 ?? '',
                "address_2" => $customer->defaultBillingAddress->address_2 ?? '',
            ];

            // dd($customer->defaultShippingAddress);
            $orderData['billing_address'] = $address;
            $orderData['shipping_address'] = $address;

            $orderData = $this->orderService->recalculateSessionOrder($orderData);

            session(['orderData' => $orderData]);

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'callback'  => 'loadOrder()'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors'  => 'Something went wrong. Please try again. ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save or update customer.
     */
    protected function saveCustomer(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        $customer->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            // Only update password if provided
            'password' => $request->filled('password')
                ? bcrypt($request->password)
                : $customer->password,
        ]);
    }

    /**
     * Save billing & shipping addresses.
     */
    protected function saveAddresses(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        // Billing
        Address::updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'billing'],
            [
                'address_1'  => $request->billing_address_1,
                'city'       => $request->billing_city,
                'state'      => $request->billing_state,
                'postcode'   => $request->billing_zip,
                'country'    => $request->billing_country,
                'phone'      => $customer->phone,
                'email'      => $customer->email,
                'is_default' => true,
            ]
        );

        // Shipping
        $shippingData = $request->boolean('sameAsBilling')
            ? [
                'address_1' => $request->billing_address_1,
                'city'      => $request->billing_city,
                'state'     => $request->billing_state,
                'postcode'  => $request->billing_zip,
                'country'   => $request->billing_country,
            ]
            : [
                'address_1' => $request->shipping_address_1,
                'city'      => $request->shipping_city,
                'state'     => $request->shipping_state,
                'postcode'  => $request->shipping_zip,
                'country'   => $request->shipping_country,
            ];

        Address::updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'shipping'],
            array_merge($shippingData, [
                'phone'      => $customer->phone,
                'name'       => $customer->name,
                'email'      => $customer->email,
                'is_default' => !$request->boolean('sameAsBilling'),
            ])
        );
    }


    public function addCustomerOrUpdate(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|string|exists:users,id',
        ]);

        try {
            $orderData = session()->get('orderData', []);

            $getCustomer = User::find($request->customer_id);

            $orderData['customer_details'] = [
                'id'        => $getCustomer->id,
                "name"      => $getCustomer->name,
                "email"     => $getCustomer->email,
                "phone"     => $getCustomer->phone
            ];

            $address = [
                'name'      => $getCustomer->defaultBillingAddress()->name ?? $getCustomer->name,
                "email"     => $getCustomer->defaultBillingAddress()->email ?? $getCustomer->email,
                "phone"     => $getCustomer->defaultBillingAddress()->phone ?? $getCustomer->phone,
                "company"   => $getCustomer->defaultBillingAddress()->company ?? '',
                "city"      => $getCustomer->defaultBillingAddress()->city ?? '',
                "state"     => $getCustomer->defaultBillingAddress()->state ?? '',
                "country"   => $getCustomer->defaultBillingAddress()->country ?? '',
                "postcode"  => $getCustomer->defaultBillingAddress()->postcode ?? '',
                "address_1" => $getCustomer->defaultBillingAddress()->address_1 ?? '',
                "address_2" => $getCustomer->defaultBillingAddress()->address_2 ?? '',
            ];

            $orderData['billing_address'] = $address;
            $orderData['shipping_address'] = $address;

            $orderData = $this->orderService->recalculateSessionOrder($orderData);

            session(['orderData' => $orderData]);

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'order'   => $orderData,
                'callback' => 'loadOrder()'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->getMessage(),
            ]);
        }
    }

    /**
     * Add a discount (stored in session only).
     */
    public function addDiscount(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        try {
            $orderData = session()->get('orderData', []);

            if ($this->discountService->validateCoupon($request->coupon_code, null, $orderData)) {
                $orderData['coupon_code'] = $request->coupon_code;
                $orderData = $this->orderService->recalculateSessionOrder($orderData);

                session(['orderData' => $orderData]);

                return response()->json([
                    'success' => true,
                    'message' => 'Discount applied successfully',
                    'order'   => $orderData,
                    'callback'  => 'loadOrder()'
                ]);
            }

            return response()->json([
                'success' => false,
                'errors'  => 'Invalid Coupon Code',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove discount (from session only).
     */
    public function removeDiscount(Request $request)
    {
        $orderData = session()->get('orderData', []);
        $orderData['coupon_code'] = null;
        $orderData['discount'] = 0;

        $orderData = $this->orderService->recalculateSessionOrder($orderData);

        session(['orderData' => $orderData]);

        return response()->json([
            'success' => true,
            'message' => 'Discount removed successfully',
            'order'   => $orderData,
            'callback' => 'loadOrder()'
        ]);
    }

    /**
     * Update item quantity (session only).
     */
    public function updateItemQuantity(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderData = session()->get('orderData', []);

        if (! empty($orderData['order_items'])) {
            foreach ($orderData['order_items'] as &$item) {
                if ($item['id'] == $request->item_id) {
                    $item['quantity'] = $request->quantity;
                    $item['line_total'] = $item['price'] * $item['quantity'];
                }
            }
        }


        $orderData = $this->orderService->recalculateSessionOrder($orderData);
        session(['orderData' => $orderData]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully',
            'order'   => $orderData,
            'callback' => 'loadOrder()'
        ]);
    }

    /**
     * Add new items (session only).
     */
    public function addItems(Request $request)
    {
        // dd($request->input());
        $request->validate([
            'items'   => 'required|array',
            'items.*' => 'required|exists:products,id',
        ]);

        $orderData = session()->get('orderData', []);
        $orderData['order_items'] = $orderData['order_items'] ?? [];

        foreach ($request->items as $productId) {
            $product = Product::findOrFail($productId);

            // check if already exists in order_items
            $existingIndex = null;
            foreach ($orderData['order_items'] as $index => $item) {
                if ($item['product_id'] == $productId) {
                    $existingIndex = $index;
                    break;
                }
            }

            if ($existingIndex !== null) {
                $orderData['order_items'][$existingIndex]['quantity'] += 1;
                $orderData['order_items'][$existingIndex]['line_total'] =
                    $orderData['order_items'][$existingIndex]['price'] *
                    $orderData['order_items'][$existingIndex]['quantity'];
            } else {
                $orderData['order_items'][] = [
                    'id'          => $productId, // temporary ID for session
                    'product_id'  => $productId,
                    'product_name' => $product->name,
                    'sku'         => $product->sku,
                    'price'       => $product->price,
                    'quantity'    => 1,
                    'line_total'  => $product->price,
                    'tax'         => 0,
                ];
            }
        }

        $orderData = $this->orderService->recalculateSessionOrder($orderData);
        session(['orderData' => $orderData]);

        return response()->json([
            'success' => true,
            'message' => 'Items added successfully',
            'order'   => $orderData,
            'callback' => 'loadOrder()'
        ]);
    }

    /**
     * Remove item (session only).
     */
    public function removeItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
        ]);

        $orderData = session()->get('orderData', []);
        $orderData['order_items'] = array_filter(
            $orderData['order_items'] ?? [],
            fn($item) => $item['id'] != $request->item_id
        );

        $orderData = $this->orderService->recalculateSessionOrder($orderData);
        session(['orderData' => $orderData]);

        return response()->json([
            'success' => true,
            'message' => 'Item removed successfully',
            'order'   => $orderData,
            'callback' => 'loadOrder()'
        ]);
    }
}
