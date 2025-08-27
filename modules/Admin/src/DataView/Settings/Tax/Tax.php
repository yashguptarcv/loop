<?php

namespace Modules\Admin\DataView\Settings\Tax;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class Tax extends DataGrid
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
        return DB::table('tax_rates')
            ->select(
                'id',
                'rate_value',
                'type',
                'country_id',
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
        ]);

        $this->addColumn([
            'index' => 'rate_value',
            'label' => 'Rate Value',
            'type' => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => 'Type',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
           
        ]);

        $this->addColumn([
            'index' => 'country_id',
            'label' => 'Country id',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
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
        if (bouncer()->hasPermission('admin.settings.taxes.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.taxes.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.taxes.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.taxes.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.settings.taxes.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Tax',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.taxes.create',
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.taxes.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.settings.taxes.bulk-delete',
            ]);
        }
        
    }
}