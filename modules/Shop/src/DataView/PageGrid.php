<?php

namespace Modules\Shop\DataView;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class PageGrid extends DataGrid
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
        return DB::table('pages')
            ->select(
                'id',
                'slug',
                'title',
                'meta_description',
                'meta_keywords',
                'meta_og_image',
                'status',
                'created_at',
                'updated_at'
            )
            ->orderBy('title', 'asc');
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
            'label' => 'Page ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'slug',
            'label' => 'Slug',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => 'Page Title',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        
        $this->addColumn([
            'index' => 'meta_description',
            'label' => 'Meta Description',
            'type' => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable' => true,
        ]);
        $this->addColumn([
            'index' => 'meta_keywords',
            'label' => 'Meta Keywords',
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
            'closure' => function ($row) {
                $statusClass = $row->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Created',
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
        if (bouncer()->hasPermission('admin.pages.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.pages.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.pages.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.pages.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.pages.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Add Page',
                'method' => 'GET',
                // 'is_popup'  => true,
                'action' => 'text-amber-100 bg-primary-100',
                'url' => 'admin.pages.create',
            ]);
        }
    }
}
