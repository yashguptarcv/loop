<?php

namespace Modules\Admin\DataView\Settings;

use Illuminate\Http\Request;
use Modules\DataView\ColumnTypes\Integer;
use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RolesGrid extends DataGrid
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
        return DB::table('roles')
            ->select(
                'id',
                'name',
                'permission_type',
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
            'filterable' => true,
            'sortable' => true,
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
            'index' => 'permission_type',
            'label' => 'Permission Type',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'allow_multiple_values' => false,
            'filterable_options' => [
                [
                    'label' => 'All',
                    'value' => 'all',
                ],
                [
                    'label' => 'Custom',
                    'value' => 'custom',
                ],
            ],
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
        if (bouncer()->hasPermission('admin.settings.roles.edit')) {
            $this->addAction([
                'icon' => 'icon-edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.roles.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.roles.destroy')) {
            $this->addAction([
                'icon' => 'icon-delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.roles.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.settings.roles.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'icon-delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-white bg-red-600',
                'url' => 'admin.settings.roles.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.roles.create')) {
            $this->addMassAction([
                'icon' => 'icon-add',
                'title' => 'Create Role',
                'method' => 'GET',
                'action' => 'text-white bg-blue-500',
                'url' => 'admin.settings.roles.create',
            ]);
        }
    }
}