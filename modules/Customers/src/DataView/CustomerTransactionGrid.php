<?php

namespace Modules\Customers\DataView;

use Illuminate\Support\Facades\DB;
use Modules\DataView\DataGrid;

class CustomerTransactionGrid extends DataGrid
{
    protected $primaryColumn = 'id';

    protected $itemsPerPage = 15;

    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $query = DB::table('transactions')
            ->leftJoin('orders', 'transactions.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'transactions.id',
                'transactions.transaction_number',
                'transactions.type',
                'transactions.status',
                'transactions.amount',
                'transactions.currency',
                'transactions.payment_id',
                'transactions.processed_at',
                'transactions.created_at',
                'orders.id as order_id',
                'orders.order_number'
            );

        // Filter by customer ID from request parameter
        if (request()->route('customer')) {
            $customerId = request()->route('customer')->id ?? request()->route('customer');
            $query->where('orders.user_id', $customerId);
        }

        return $query;
    }

    /**
     * Prepare columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => 'Transaction ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'transaction_number',
            'label' => 'Transaction #',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'order_number',
            'label' => 'Order #',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => false,
            'closure' => function ($row) {
                if ($row->order_id) {
                    return '<a href="' . route('admin.orders.show', $row->order_id) . '" class="text-indigo-600 hover:text-indigo-900">#' . $row->order_number . '</a>';
                }
                return 'N/A';
            },
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => 'Type',
            'type' => 'string',
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Payment', 'value' => 'payment'],
                ['label' => 'Refund', 'value' => 'refund'],
                ['label' => 'Adjustment', 'value' => 'adjustment'],
            ],
            'closure' => function ($row) {
                $labels = [
                    'payment' => 'bg-blue-500',
                    'refund' => 'bg-yellow-500',
                    'adjustment' => 'bg-gray-500',
                ];
                $class = $labels[$row->type] ?? 'bg-gray-400';

                return '<span class="px-2 py-1 text-xs rounded-full text-white ' . $class . '">' .
                    ucfirst($row->type) . '</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => 'Amount',
            'type' => 'decimal',
            'filterable' => false,
            'searchable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'currency',
            'label' => 'Currency',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Pending', 'value' => 'pending'],
                ['label' => 'Success', 'value' => 'success'],
                ['label' => 'Failed', 'value' => 'failed'],
                ['label' => 'Reversed', 'value' => 'reversed'],
            ],
            'closure' => function ($row) {
                $statusColors = [
                    'pending' => 'bg-yellow-400',
                    'success' => 'bg-green-500',
                    'failed' => 'bg-red-500',
                    'reversed' => 'bg-gray-400',
                ];

                $class = $statusColors[$row->status] ?? 'bg-gray-300';

                return '<span class="px-2 py-1 text-xs rounded-full text-white ' . $class . '">' .
                    ucfirst($row->status) . '</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'payment_id',
            'label' => 'Payment Method',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Date',
            'type' => 'date',
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('admin.transactions.show')) {
            $this->addAction([
                'icon' => 'visibility',
                'title' => 'View',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.transactions.show', $row->id);
                },
            ]);
        }    
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        // No mass actions for customer-specific transactions view
    }
}
