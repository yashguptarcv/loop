<?php

namespace Modules\Catalog\DataView;

use Illuminate\Http\Request;
use Modules\DataView\ColumnTypes\Integer;
use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryGrid extends DataGrid
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
        return DB::table('categories as child')
            ->leftJoin('categories as parent', 'child.parent_id', '=', 'parent.id')
            ->select(
                'child.id',
                'child.parent_id',
                'child.name',
                'child.status',
                'child.position',
                'parent.name as parent_name',
                'child.created_at'
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
            'closure' => function ($row) {
                $name = $row->name;
                if ($row->parent_id && isset($row->parent_name)) {
                    $name = $row->parent_name . ' > ' . $name;
                }
                return $name;
            },
        ]);

        $this->addColumn([
            'index' => 'position',
            'label' => 'Position',
            'type' => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return ($row->status === 'A') ? 'Active' : 'Inactive';
            },
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                [
                    'label' => 'Active',
                    'value' => 'A'
                ],

                [
                    'label' => 'Inactive',
                    'value' => 'D'
                ]
            ],
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
        if (bouncer()->hasPermission('admin.catalog.categories.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.catalog.categories.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.categories.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.catalog.categories.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.catalog.categories.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.catalog.categories.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.categories.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Category',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.catalog.categories.create',
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.categories.toggle-status')) {
            $this->addMassAction([
                'icon' => '',
                'title' => 'Status',
                'method' => 'POST',
                'url' => 'admin.catalog.categories.toggle-status',
                'action' => 'bg-gray-500',
                'options' => [
                    ['label' => 'Active', 'value' => 'A'],
                    ['label' => 'Disabled', 'value' => 'D'],
                ],
            ]);
        }


        if (bouncer()->hasPermission('admin.catalog.categories.import_form')) {
            $this->addMassAction([
                'icon' => 'file_upload',
                'title' => 'Import',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url'   => 'admin.catalog.categories.import_form',
            ]);
        }
    }
}
