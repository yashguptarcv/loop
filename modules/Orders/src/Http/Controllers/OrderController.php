<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Orders\Models\Order;
use Modules\Admin\Models\Country;
use Illuminate\Routing\Controller;
use Modules\Customers\Models\User;
use Modules\Catalog\Models\Product;
use Modules\Orders\DataView\OrderGrid;
use Illuminate\Support\Facades\Session;
use Modules\Orders\Services\OrderService;
use Modules\Orders\Http\Requests\OrderRequest;
use Modules\Payments\Models\PaymentConfiguration;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::forget('cart');
        $lists = fn_datagrid(OrderGrid::class)->process();
        return view('orders::orders.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $payments  = PaymentConfiguration::where('is_active', true)->get();

        if ($request->input('tab')) {
            $html = view('orders::orders.components.order_detail', array_merge(
                session('cart', []),
                ['mode' => 'create', 'payments'  => $payments]
            ))->render();

            return response()->json([
                'success' => true,
                'order_datas' => $html
            ]);
        }

        return view('orders::orders.form', array_merge(
            session('cart', []),
            ['mode' => 'create', 'payments'  => $payments]
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        Session::forget('cart');
        $orderData = $this->orderService->getOrder($id);

        return view('orders::orders.form', array_merge($orderData, [
            'mode' => 'view'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        if (!session()->get('cart', [])) {
            $order = $this->orderService->getOrder($id);
            session(['cart' => $order]);
        }

        $payments  = PaymentConfiguration::where('is_active', true)->get();

        if ($request->input('tab')) {
            $html = view('orders::orders.components.order_detail', array_merge(
                session('cart', []),
                ['mode' => 'edit', 'payments'  => $payments]
            ))->render();

            return response()->json([
                'success' => true,
                'order_datas' => $html
            ]);
        }

        return view('orders::orders.form', array_merge(
            session('cart', []),
            ['mode' => 'edit', 'payments'  => $payments]
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sessionOrder = session('cart', []);

        if (empty($sessionOrder)) {
            return redirect()->back()->with('success', 'No session order data found');
        }

        $sessionOrder = $this->orderService->recalculateSessionOrder($sessionOrder);
        $createData = [
            'user_id'         => $sessionOrder['customer_details']['id'] ?? null,
            'items'           => $sessionOrder['order_items'] ?? [],
            'currency'        => $sessionOrder['currency'] ?? 'USD',
            'status'          => $sessionOrder['status'] ?? fn_get_setting('general.order.create'),
            'coupon_code'     => $sessionOrder['coupon_code'] ?? null,
            'billing_address' => $sessionOrder['billing_address'] ?? [],
            'shipping_address' => $sessionOrder['shipping_address'] ?? [],
            'notes'           => $sessionOrder['order_note'] ?? null,
            'payment_method'  => $sessionOrder['payment_method'] ?? null,
            'subtotal'        => $sessionOrder['subtotal'],
            'total'           => $sessionOrder['total'],
            'requires_payment' => false, // or false if you're only storing order
        ];

        try {
            $this->orderService->createOrder($createData);
            return redirect()->back()->with('success', 'Order created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('success', 'Failed to create order' . $e->getMessage());
        } catch (\Throwable $e) {

            return redirect()->back()->with('success', 'Failed to create order' . $e->getMessage());
        } catch (\InvalidArgumentException $e) {

            return redirect()->back()->with('success', 'Failed to create order' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Failed to create order' . $e->getMessage());
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        try {
            $sessionData = session('cart', []); // or however you store it

            if (empty($sessionData['order_id'])) {
                return redirect()->route('admin.orders.index')->with('error', 'Missing order ID');
            }

            $order = Order::findOrFail($sessionData['order_id']);

            $updateData = [
                'order_id'          => $sessionData['order_id'],
                'status'            => $sessionData['status'],
                'total'             => $sessionData['total'],
                'subtotal'          => $sessionData['subtotal'],
                'billing_address'   => $sessionData['billing_address'],
                'shipping_address'  => $sessionData['shipping_address'],
                'notes'             => $sessionData['order_note'],
                'items'             => $sessionData['order_items'],
                'coupon_code'       => $sessionData['coupon_code'],
                'payment_method'    => $sessionData['payment_method'],
                'user_id'           => $sessionData['customer_details']['id']
            ];

            $this->orderService->updateOrder($order, $updateData, true);
            return redirect()->route('admin.orders.show', $sessionData['order_id'])->with('success', 'Order updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.orders.show', $sessionData['order_id'])->with('success', 'Unable to update order: ' . $e->getMessage());
        } catch (\Throwable $e) {

            return redirect()->route('admin.orders.show', $sessionData['order_id'])->with('success', 'Unable to update order: ' . $e->getMessage());
        } catch (\InvalidArgumentException $e) {

            return redirect()->route('admin.orders.show', $sessionData['order_id'])->with('success', 'Unable to update order: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.show', $sessionData['order_id'])->with('success', 'Unable to update order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            if (!empty($order)) {
                Order::destroy($id);
            }

            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Order cancelled successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:orders,id',
        ]);

        try {
            $deletedCount = Order::whereIn('id', $request->ids)->delete();
            return redirect()->route('admin.orders.index')->with('success', "Deleted {$deletedCount} orders successfully");
        } catch (\Throwable $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'action' => 'required|string|exists:statuses,id',
            'ids' => 'required|array|min:1',
            'ids.*'    => 'nullable|string|exists:orders,id'
        ]);

        try {
            $statusCode = fn_get_order_status_code($request->input('action'));
            // Process multiple orders if ids are passed
            $orderIds = $request->input('ids', []);  // Default to empty array if no ids passed

            // If no order IDs are provided, we can choose to handle this differently
            if (empty($orderIds)) {
                return back()->with('error', 'No orders selected.');
            }

            foreach ($orderIds as $orderId) {
                // Find order by ID
                $order = Order::findOrFail($orderId);

                // Update the status using the service
                $this->orderService->updateOrderStatus($order, $statusCode['status_code']);
            }

            return back()
                ->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
}
