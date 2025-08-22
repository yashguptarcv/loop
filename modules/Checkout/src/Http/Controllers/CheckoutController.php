<?php

namespace Modules\Checkout\Http\Controllers;
use Illuminate\Http\Request;

use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Modules\Customers\Models\User;
use Modules\Checkout\Http\Controllers;
use Modules\Orders\Services\OrderService;
use Modules\Checkout\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Initial checkout page
    public function index(Request $request)
    {
        
        // You might want to pass any necessary data here
        return view('checkout::checkout.index');
    }

    // Process checkout form
    public function process(CheckoutRequest $request)
    {
        // Store checkout data in session
        $request->session()->put('checkout_data', $request->validated());
        
        return redirect()->route('checkout.payment');
    }

    // Payment selection page
    public function payment(Request $request)
    {
        $checkoutData = $request->session()->get('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout.index');
        }

        return view('checkout.payment', [
            'checkoutData' => $checkoutData
        ]);
    }

    // Complete the order
    public function complete(Request $request)
    {
        $checkoutData = $request->session()->get('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout.index');
        }

        // Prepare order data for OrderService
        $orderData = [
            'user_id' => auth('user')->id(),
            'status' => 'pending',
            'billing_address' => $checkoutData['billing_address'],
            'items' => $checkoutData['items'],
            'payment_method' => $request->input('payment_method'),
            'requires_payment' => true,
            'notes' => $checkoutData['notes'] ?? null,
        ];

        // Create the order
        $order = $this->orderService->createOrder($orderData);

        // Clear checkout session
        $request->session()->forget('checkout_data');

        return redirect()->route('checkout.confirmation', $order);
    }

    // Order confirmation page
    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth('user')->id()) {
            abort(403);
        }

        return view('checkout.confirmation', [
            'order' => $order
        ]);
    }
}