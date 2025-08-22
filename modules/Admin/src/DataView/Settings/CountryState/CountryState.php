<?php

namespace Modules\Admin\DataView\Settings\CountryState;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class CountryState extends DataGrid
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
        return DB::table('country_states')
            ->select(
                'id',
                'country_id',
                'code',
                'default_name',
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





        $country = DB::table('countries')->pluck('name', 'id');
        $this->addColumn([
            'index' => 'name',
            'label' => 'Country name',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
            'closure' => function ($row) use ($country) {
                return $country[$row->country_id] ?? 'Unknown';
            },
            'filterable_type' => 'dropdown',
            'filterable_options' => collect($country)->map(function ($name, $id) {
                return [
                    'label' => $name,
                    'value' => $id
                ];
            })->values()->toArray(),
        ]);

        $this->addFilter('name', 'country_id');

        $this->addColumn([
            'index' => 'code',
            'label' => 'Code',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'default_name',
            'label' => 'State Name',
            'type' => 'string',
            'searchable' => false,
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
        if (bouncer()->hasPermission('admin.settings.states.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'is_popup'  => true,
                'url' => function ($row) {
                    return route('admin.settings.states.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.states.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.states.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.settings.states.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Add State',
                'method' => 'GET',
                'is_popup'  => true,
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.states.create',
            ]);
        }
    }
}
