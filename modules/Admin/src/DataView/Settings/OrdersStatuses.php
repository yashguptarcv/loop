<?php

namespace Modules\Admin\DataView\Settings;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class OrdersStatuses extends DataGrid
{
    protected $primaryColumn = "id";
    protected $itemsPerPage = 10;
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *v c 
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('statuses')
            ->select(
                'id',
                'name',
                'type_code',
                'status_code',
                'created_at'
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
            'label' => 'ID',
            'type' => 'integer',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
            'closure' => function ($row) {
                if(in_array($row->status_code, array_column(config('admin.statuses'), 'status_code'))) {
                    return false; 
                }
            },
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Name',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status_code',
            'label' => 'Status Code',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
           
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Created At',
            'type' => 'date',
            'searchable' => true,
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
        // if (bouncer()->hasPermission('admin.settings.orders.edit')) {
        //     $this->addAction([
        //         'icon' => 'edit',
        //         'title' => 'Edit',
        //         'method' => 'GET',
        //         'modal' => true,
        //         'url' => function ($row) {
        //             if(!in_array($row->status_code, array_column(config('admin.statuses'), 'status_code'))) {
        //                 return route('admin.settings.orders.edit', $row->id);
        //             }
        //         },
        //     ]);
        // }

        // if (bouncer()->hasPermission('admin.settings.orders.destroy')) {
        //     $this->addAction([
        //         'icon' => 'delete',
        //         'title' => 'Delete',
        //         'method' => 'DELETE',
        //         'url' => function ($row) {
        //             if(!in_array($row->status_code, array_column(config('admin.statuses'), 'status_code'))) {
        //                 return route('admin.settings.orders.destroy', $row->id);
        //             }
        //         },
        //     ]);
        // }
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {

        if (bouncer()->hasPermission('admin.settings.orders.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Status',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.orders.create',
            ]);
        }
        
    }
}