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
                session('orderData', []),
                ['mode' => 'create', 'payments'  => $payments]
            ))->render();

            return response()->json([
                'success' => true,
                'order_datas' => $html
            ]);
        }        
        
        return view('orders::orders.form', array_merge(
            session('orderData', []),
            ['mode' => 'create', 'payments'  => $payments]
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        Session::forget('orderData');
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
        if (!session()->get('orderData', [])) {
            $order = $this->orderService->getOrder($id);
            session(['orderData' => $order]);
        }

        $payments  = PaymentConfiguration::where('is_active', true)->get(); 

        if ($request->input('tab')) {
            $html = view('orders::orders.components.order_detail', array_merge(
                session('orderData', []),
                ['mode' => 'edit', 'payments'  => $payments]
            ))->render();

            return response()->json([
                'success' => true,
                'order_datas' => $html
            ]);
        }        
        
        return view('orders::orders.form', array_merge(
            session('orderData', []),
            ['mode' => 'edit', 'payments'  => $payments]
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $updatedOrder = $this->orderService->updateOrder(
                $order,
                $request->validated(),
                true // Update items
            );

            return redirect()
                ->route('admin.orders.show', $updatedOrder->id)
                ->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $this->orderService->cancelOrder($order, 'Order cancelled by admin');

            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Order cancelled successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string',
            'reason' => 'nullable|string'
        ]);

        try {
            $order = Order::findOrFail($id);
            $updatedOrder = $this->orderService->updateOrderStatus(
                $order,
                $request->input('status')
            );

            return back()
                ->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    /**
     * Search products for order
     */
    public function searchProducts(Request $request)
    {
        $search = $request->input('search');

        $products = Product::active()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'sku', 'price']);

        return response()->json($products);
    }
}
