<?php

namespace Modules\Admin\DataView\Website\Coupons;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class Coupons extends DataGrid
{
    protected $primaryColumn = "id";
    protected $itemsPerPage = 10;
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('coupons')
            ->select(
                'id',
                'admin_id',
                'name',
                'coupon_code',
                'start_date',
                'end_date',
                'coupon_per_user',
                'coupon_used_count',
                'coupon_type',
                'coupon_value',
                'coupon_status',
                'coupon_message',
            );
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => 'Coupon ID',
            'type' => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Coupon Name',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'coupon_code',
            'label' => 'Coupon Code',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'start_date',
            'label' => 'Start Date',
            'type' => 'date',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'end_date',
            'label' => 'End Date',
            'type' => 'date',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);
        
        $this->addColumn([
            'index' => 'coupon_value',
            'label' => 'Coupon Value',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => function ($row) {
                return ($row->coupon_type == "F") ? $row->coupon_value : $row->coupon_value. '%';
            },
        ]);

        $this->addColumn([
            'index' => 'coupon_type',
            'label' => 'Coupon Type',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
            'visibility'    => false,
            'closure' => function ($row) {
                return ($row->coupon_type == "F") ? 'Fixed' : 'Percentage';
            },
            'allow_multiple_values' => false,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                [
                    'label' => 'Fixed',
                    'value' => 'F'
                ],

                [
                    'label' => 'Percentage',
                    'value' => 'P'
                ]
            ],
        ]);
        
        $this->addColumn([
            'index' => 'coupon_status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
            'allow_multiple_values' => false,
            'closure' => function ($row) {
                return ($row->coupon_status == 1) ? 'Active' : 'Inactive';
            },
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                [
                    'label' => 'Active',
                    'value' => 1
                ],

                [
                    'label' => 'Inactive',
                    'value' => 0
                ]
            ],
        ]);

        
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('admin.coupons.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.coupons.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.coupons.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.coupons.destroy', $row->id);
                },
            ]);
        }
    }

    /**
     * Prepare mass actions.
     *
     * @return void text-white bg-blue-500
     */
    public function prepareMassActions()
    {

        if (bouncer()->hasPermission('admin.settings.users.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'icon-delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-white bg-red-600',
                'url' => 'admin.settings.users.bulk-delete',
            ]);
        }


        if (bouncer()->hasPermission('admin.coupons.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Add coupon',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.coupons.create',
            ]);
        }
    }
}
