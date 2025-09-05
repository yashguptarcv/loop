<?php

namespace Modules\Customers\DataView;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Enums\OrderStatus;

class CustomerOrderGrid extends DataGrid
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
        $query = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id',
                'orders.order_number',
                'orders.status',
                'orders.subtotal',
                'orders.tax',
                'orders.shipping',
                'orders.total',
                'orders.payment_method',
                'orders.payment_status',
                'orders.created_at',
                'orders.currency',
                'users.name'
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
            'label' => 'Order ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'order_number',
            'label' => 'Order Number',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'total',
            'label' => 'Total',
            'type' => 'decimal',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return fn_convert_currency_rate($row->total ?? 0, $row->currency);
            }
        ]);

        $this->addColumn([
            'index' => 'currency',
            'label' => 'Currency',
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);

        $orderStatuses = fn_get_order_statuses();
        $this->addColumn([
            'index' => 'status',
            'label' => 'Order Status',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => collect($orderStatuses)->map(function ($name, $id) {
                return [
                    'label' => $name->name,
                    'value' => $name->id
                ];
            })->values()->toArray(),
            'closure' => function ($row) {
                // Get the status from the row
                $statusValue = $row->status;
                
                try {
                    // Convert the status value to the enum
                    $status = fn_get_order_status($statusValue);
                    return "<span class='bg-{$status->color}-100 text-{$status->color}-500 rounded-lg px-1 py-1'>{$status->name}</span>";
                } catch (\ValueError $e) {                    
                    // Handle unexpected status values
                    return 'Unknown';
                }
            },
        ]);

        $this->addColumn([
            'index' => 'payment_status',
            'label' => 'Payment',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'payment_method',
            'label' => 'Payment Method',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Order Date',
            'type' => 'date',
            'searchable' => false,
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
        if (bouncer()->hasPermission('admin.orders.show')) {
            $this->addAction([
                'icon' => 'open_in_new',
                'title' => 'View Detail',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.orders.show', $row->id);
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
       
    }
}
