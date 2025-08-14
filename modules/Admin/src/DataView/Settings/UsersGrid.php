<?php

namespace Modules\Admin\DataView\Settings;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class UsersGrid extends DataGrid
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
        return DB::table('admins')
            ->select(
                'id',
                'name',
                'email',
                'status',
                'role_id',
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
            'index' => 'email',
            'label' => "Email",
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'allow_multiple_values' => false,
            'filterable_options' => [
                [
                    'label' => 'Active',
                    'value' => 1,
                ],
                [
                    'label' => 'Disabled',
                    'value' => 0,
                ],
            ],
            'sortable' => true,
            'closure' => function ($row) {
                if ($row->status) {
                    return 'Active';
                }
                return 'Disabled';
            },
        ]);

        $roles = DB::table('roles')->pluck('name', 'id');
        $this->addColumn([
            'index' => 'role_id',
            'label' => 'Role name',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
            'closure' => function ($row) use ($roles) {
                return $roles[$row->role_id] ?? 'Unknown';
            },
            'filterable_type' => 'dropdown',
            'filterable_options' => collect($roles)->map(function ($name, $id) {
                return [
                    'label' => $name,
                    'value' => $id
                ];
            })->values()->toArray(),
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
        if (bouncer()->hasPermission('admin.settings.users.show')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.users.show', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.users.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.users.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.settings.users.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.settings.users.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.users.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create User',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.users.create',
            ]);
        }


        if (bouncer()->hasPermission('admin.settings.users.toggle-status')) {
            $this->addMassAction([
                'icon' => 'settings',
                'title' => 'Status',
                'method' => 'POST',
                'url' => 'admin.settings.users.toggle-status',
                'action' => 'bg-gray-500',
                'options' => [
                    [
                        'label' => 'Active',
                        'value' => 1,
                    ],
                    [
                        'label' => 'Disabled',
                        'value' => 0,
                    ],
                ],
            ]);
        }
    }
}