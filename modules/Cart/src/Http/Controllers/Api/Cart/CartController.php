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
use Modules\Cart\Services\CartService;
use function PHPUnit\Framework\callback;
use Modules\Orders\Services\OrderService;
use Modules\Payments\Models\PaymentMethod;

use Modules\Payments\Services\PaymentsService;
use Modules\Discounts\Services\DiscountService;
use Modules\Customers\Http\Requests\AddressRequest;
use Modules\Customers\Http\Requests\StoreOrUpdateCustomerRequest;

class CartController extends Controller
{
    protected OrderService $orderService;
    protected DiscountService $discountService;
    protected CartService $cartService;
    protected PaymentsService $paymentService;

    public function __construct(
        OrderService $orderService,
        DiscountService $discountService,
        CartService $cartService,
        PaymentsService $paymentService
    ) {
        $this->orderService = $orderService;
        $this->discountService = $discountService;
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }

    public function viewDiscountForm(Request $request, $order_id)
    {
        $order = session('cart', []);
        return view('cart::cart.discount.form', compact('order'));
    }

    public function viewItems(Request $request, $order_id)
    {

        $order = session('cart', []);
        $items = $order['order_items'] ?? [];
        return view('cart::cart.items.form', compact('items', 'order_id'));
    }

    public function viewCustomerForm(Request $request, $order_id)
    {
        $order = session('cart', []);
        return view('cart::cart.customer.form', compact('order'));
    }

    public function profileUpdateForm(Request $request, $customer_id = null)
    {
        try {
            $customer = User::findorfail($customer_id);
            return view('cart::cart.profile.form', compact('customer'));
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function paymentForm(Request $request)
    {
        try {
            $method = PaymentMethod::findorfail($request->payment_method_id);
            if (!empty($method)) {

                $orderData = session()->get('cart', []);

                $orderData['payment_method'] = $request->payment_id;
                $orderData = $this->orderService->recalculateSessionOrder($orderData);

                session(['cart' => $orderData]);

                $view = $method->processor;

                $html = view($view)->render();

                return response()->json([
                    'success' => true,
                    'payment-detail-action' => $html,
                ]);

                return view($view)->render();
            }
            // return view('cart::cart.profile.form', compact('customer'));
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function update_status(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|string|exists:statuses,status_code',
        ]);

        try {
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->updateStatus($orderData, $request->status);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
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

    public function addCustomerOrUpdate(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
        ]);

        try {
            $customer = User::findOrFail($request->customer_id);
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->setCustomer($customer, $orderData);

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

    public function updateAddress(AddressRequest $request, $customer_id)
    {
        try {
            $request->validated();
            $orderData = $this->cartService->getOrderData();
            $this->cartService->updateAddress(User::find($customer_id), $request, $orderData);
            return response()->json([
                'success' => true,
                'message' => 'Billing address updated successfully',
                'order'   => $orderData,
                'callback' => 'loadOrder()'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to update address: ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to update address: ' . $e->getMessage(),
            ]);
        }
    }

    public function addDiscount(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        try {
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->applyDiscount($request->coupon_code, $orderData);

            return response()->json([
                'success' => true,
                'message' => 'Discount applied successfully',
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

    public function removeDiscount(Request $request)
    {
        $orderData = $this->cartService->getOrderData();
        $orderData = $this->cartService->removeDiscount($orderData);

        return response()->json([
            'success' => true,
            'message' => 'Discount removed successfully',
            'order'   => $orderData,
            'callback' => 'loadOrder()'
        ]);
    }

    public function updateItemQuantity(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->updateItemQuantity($request->item_id, $request->quantity, $orderData);

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully',
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

    public function addItems(Request $request)
    {
        $request->validate([
            'items'   => 'required|array',
            'items.*' => 'required|exists:products,id',
        ]);

        try {
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->addItems($request->items, $orderData);

            return response()->json([
                'success' => true,
                'message' => 'Items added successfully',
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

    public function removeItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
        ]);

        try {
            $orderData = $this->cartService->getOrderData();
            $orderData = $this->cartService->removeItem($request->item_id, $orderData);

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully',
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

    public function updateCustomer(StoreOrUpdateCustomerRequest $request, $customer_id)
    {
        try {
            $customer = User::findOrFail($customer_id);
            $orderData = $this->cartService->getOrderData();

            $orderData = $this->cartService->updateCustomer($customer, $request, $orderData);

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'callback' => 'loadOrder()',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors'  => 'Something went wrong. Please try again. ' . $e->getMessage(),
            ]);
        }
    }

    public function paymentProcess(Request $request)
    {
        try {
            $orderData = $this->cartService->getOrderData();

            $this->paymentService->charge(
                (int)$request['payment'],
                $orderData,
                $request
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Payment Failed: ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Payment Failed: ' . $e->getMessage(),
            ]);
        }
    }
}
