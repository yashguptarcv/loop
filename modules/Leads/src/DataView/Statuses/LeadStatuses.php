<?php

namespace Modules\Leads\DataView\Statuses;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class LeadStatuses extends DataGrid
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
        return DB::table('lead_statuses')
            ->select(
                'id',
                'name',
                'color',
                'sort',
                'is_default',
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
            'index' => 'color',
            'label' => 'Color Name',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
           
        ]);

        $this->addColumn([
            'index' => 'sort',
            'label' => 'Sort Order',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'is_default',
            'label' => 'Default',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => function ($row) {
                if ($row->is_default) {
                    return 'Default';
                }
                return '----';
            },
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
        if (bouncer()->hasPermission('admin.statuses.leads.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'is_popup' => true,
                'url' => function ($row) {
                    return route('admin.statuses.leads.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.statuses.leads.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.statuses.leads.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.statuses.leads.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Status',
                'method' => 'GET',
                'is_popup' => true,
                'action' => 'text-amber-100 bg-primary-100',
                'url' => 'admin.statuses.leads.create',
            ]);
        }

        if (bouncer()->hasPermission('admin.statuses.tags.index')) {
            $this->addMassAction([
                'icon' => 'tag',
                'title' => 'Tags',
                'method' => 'GET',
                'is_popup'  => true,
                'action' => 'text-amber-100 bg-primary-100',
                'url' => 'admin.statuses.tags.index',
            ]);
        }

        if (bouncer()->hasPermission('admin.statuses.source.index')) {
            $this->addMassAction([
                'icon' => 'source',
                'title' => 'Source',
                'method' => 'GET',
                'is_popup'  => true,
                'action' => 'text-amber-100 bg-primary-100',
                'url' => 'admin.statuses.source.index',
            ]);
        }
        
    }
}