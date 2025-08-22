<?php

namespace Modules\Admin\DataView\Settings\Country;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class Country extends DataGrid
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
        return DB::table('countries')
            ->select(
                'id',
                'code',
                'name',
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
            'label' => 'Country ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => 'Country Code',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);
        
        $this->addColumn([
            'index' => 'name',
            'label' => 'Country Name',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
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
        if (bouncer()->hasPermission('admin.settings.countries.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'is_popup'  => true,
                'url' => function ($row) {
                    return route('admin.settings.countries.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.countries.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.countries.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.settings.countries.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Add Country',
                'method' => 'GET',
                'is_popup'  => true,
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.countries.create',
            ]);
        }
        
    }
}