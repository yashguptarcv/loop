<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\DataView\TransactionGrid;
use Modules\Orders\Models\Transaction as ModelsTransaction;

class Transaction extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = fn_datagrid(TransactionGrid::class)->process();
        return view('orders::transaction.index', compact('lists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelsTransaction $transaction)
    {        
        return view('orders::transaction.show', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = ModelsTransaction::findOrFail($id);
            if (!empty($order)) {
                ModelsTransaction::destroy($id);
            }

            return redirect()
                ->route('admin.transactions.index')
                ->with('success', 'Transaction deleted successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:transactions,id',
        ]);

        try {
            $deletedCount = ModelsTransaction::whereIn('id', $request->ids)->delete();
            return redirect()->route('admin.transactions.index')->with('success', "Deleted {$deletedCount} orders successfully");
        } catch (\Throwable $e) {
            return redirect()->route('admin.transactions.index')->with('error', 'Something went wrong. Please try again.');
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
                return back()->with('error', 'No transaction selected.');
            }

            foreach ($orderIds as $orderId) {
                // Find order by ID
                $transactions = ModelsTransaction::findOrFail($orderId);

                // Update the status using the service
                $transactions->update(['status' => 'completed', 'processed_by' => auth('admin')->id()]);
            }

            return back()
                ->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
}
