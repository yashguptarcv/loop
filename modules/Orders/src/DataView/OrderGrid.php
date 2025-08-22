<?php

namespace Modules\Orders\DataView;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Enums\OrderStatus;

class OrderGrid extends DataGrid
{
    protected $primaryColumn = 'id';

    protected $itemsPerPage = 10;

    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('orders')
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
                'users.name'
            );
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
            'index' => 'name',
            'label' => 'Customer',
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'total',
            'label' => 'Total',
            'type' => 'decimal',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return '$' . number_format($row->total, 2);
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Order Status',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Pending', 'value' => 'P'],
                ['label' => 'Processing', 'value' => 'H'],
                ['label' => 'Completed', 'value' => 'Z'],
                ['label' => 'Cancelled', 'value' => 'C'],
                ['label' => 'New', 'value' => 'O'],
                ['label' => 'Incomplete', 'value' => 'N'],
                ['label' => 'Failed', 'value' => 'F'],
                ['label' => 'Refunded', 'value' => 'R'],
            ],
            'closure' => function ($row) {
                // Get the status from the row
                $statusValue = $row->status;
                
                try {
                    // Convert the status value to the enum
                    $status = OrderStatus::from($statusValue);
                    return $status->label();
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

        if (bouncer()->hasPermission('admin.orders.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.orders.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.orders.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Order',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.orders.create',
            ]);
        }

        if (bouncer()->hasPermission('admin.orders.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.orders.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.orders.toggle-status')) {
            $this->addMassAction([
                'icon' => '',
                'title' => 'Update Status',
                'method' => 'POST',
                'action' => 'bg-gray-500',
                'url' => 'admin.orders.toggle-status',
                'options' => [
                    ['label' => 'Pending', 'value' => 'pending'],
                    ['label' => 'Processing', 'value' => 'processing'],
                    ['label' => 'Completed', 'value' => 'completed'],
                    ['label' => 'Cancelled', 'value' => 'cancelled'],
                ],
            ]);
        }
    }
}
