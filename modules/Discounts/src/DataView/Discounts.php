<?php

namespace Modules\Discounts\DataView;

use Illuminate\Http\Request;
use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class Discounts extends DataGrid
{
    protected $primaryColumn = "id";

    protected $itemsPerPage = 10;
    
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder with additional useful information
     */
    public function prepareQueryBuilder()
    {
        return DB::table('discounts')
            ->select(
                'discounts.id',
                'discounts.name',
                'discounts.type',
                'discounts.amount',
                'discounts.apply_to',
                'discounts.is_active',
                'discounts.starts_at',
                'discounts.expires_at',
                'discounts.created_at',
                // 'users.name as admin_name',
                DB::raw('(SELECT COUNT(*) FROM coupons WHERE coupons.discount_id = discounts.id) as coupons_count'),
                DB::raw('(SELECT COUNT(*) FROM discount_rules WHERE discount_rules.discount_id = discounts.id) as rules_count'),
                DB::raw('(SELECT SUM(times_used) FROM coupons WHERE coupons.discount_id = discounts.id) as total_usage')
            );
            // ->leftJoin('users', 'discounts.admin_id', '=', 'users.id');
    }

    /**
     * Add optimized columns for better overview
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => 'ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Discount Name',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => 'Type',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Fixed', 'value' => 'F'],
                ['label' => 'Percentage', 'value' => 'P']
            ],
            'sortable' => true,
            'closure' => function($value) {
                return ($value->type == 'P') ? 'Percentage' : 'Fixed';
            }
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => 'Value',
            'type' => 'decimal',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function($row) {
                return $row->type === 'P' ? $row->amount.'%' : fn_get_currency($row->amount, "INR");
            }
        ]);

        $this->addColumn([
            'index' => 'apply_to',
            'label' => 'Applies To',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Subtotal', 'value' => 'subtotal'],
                ['label' => 'Total', 'value' => 'total'],
                ['label' => 'Shipping', 'value' => 'shipping'],
            ],
            'sortable' => true,
            
        ]);

        $this->addColumn([
            'index' => 'coupons_count',
            'label' => 'Coupons',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function($value) {
                return $value->coupons_count > 0 ? '<span class="bg-blue-100 text-blue-600 px-2 py-2 rounded">'.$value->coupons_count.'</span>' : '-';
            }
        ]);

        $this->addColumn([
            'index' => 'rules_count',
            'label' => 'Rules',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function($value) {
                return $value->rules_count > 0 ? '<span class="bg-blue-100 text-blue-600 px-2 py-2 rounded">'.$value->rules_count.'</span>' : '-';
            }
        ]);

        $this->addColumn([
            'index' => 'total_usage',
            'label' => 'Usage',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function($value) {
                return $value->total_usage > 0 ? '<span class="bg-blue-100 text-blue-600 px-2 py-2 rounded">'.$value->total_usage.'</span>' : '-';
            }
        ]);

        $this->addColumn([
            'index' => 'is_active',
            'label' => 'Status',
            'type' => 'boolean',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Active', 'value' => '1'],
                ['label' => 'Inactive', 'value' => '0'],
            ],
            'sortable' => true,
            'closure' => function($value) {
                return $value->is_active 
                    ? '<span class="bg-blue-100 text-blue-600 px-2 py-2 rounded">Active</span>'
                    : '<span class="bg-red-100 text-red-600 px-2 py-2 rounded">Inactive</span>';
            }
        ]);

        $this->addColumn([
            'index' => 'starts_at',
            'label' => 'Start Date',
            'type' => 'date',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true
        ]);

        $this->addColumn([
            'index' => 'expires_at',
            'label' => 'End Date',
            'type' => 'date',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true
        ]);
    }

    /**
     * Prepare actions with additional options
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('admin.discount.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.discount.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.discount.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.discount.destroy', $row->id);
                },
            ]);
        }
    }

    /**
     * Prepare mass actions with additional options
     */
    public function prepareMassActions()
    {
        if (bouncer()->hasPermission('admin.discount.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Discount',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.discount.create',
            ]);
        }

        // $this->addMassAction([
        //     'icon' => 'toggle_on',
        //     'title' => 'Activate Selected',
        //     'method' => 'POST',
        //     'url' => route('admin.discount.mass-activate'),
        //     'permission' => 'admin.discount.activate',
        //     'class' => 'bg-green-500 hover:bg-green-600 text-white'
        // ]);

        // $this->addMassAction([
        //     'icon' => 'toggle_off',
        //     'title' => 'Deactivate Selected',
        //     'method' => 'POST',
        //     'url' => route('admin.discount.mass-deactivate'),
        //     'permission' => 'admin.discount.deactivate',
        //     'class' => 'bg-gray-500 hover:bg-gray-600 text-white'
        // ]);

        // $this->addMassAction([
        //     'icon' => 'delete',
        //     'title' => 'Delete Selected',
        //     'method' => 'POST',
        //     'url' => route('admin.discount.mass-destroy'),
        //     'permission' => 'admin.discount.destroy',
        //     'class' => 'bg-red-500 hover:bg-red-600 text-white',
        //     'confirm' => 'Are you sure you want to delete selected discounts?'
        // ]);
    }
}