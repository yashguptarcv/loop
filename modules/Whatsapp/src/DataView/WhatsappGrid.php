<?php

namespace Modules\Whatsapp\DataView;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class WhatsappGrid extends DataGrid
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
        return DB::table('whatsapp_templates')
            ->select(
                'id',
                'name',
                'category',
                'language',
                'status',
                'rejection_reason',
                'template_id',
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
            'index' => 'category',
            'label' => "Category",
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'language',
            'label' => 'Language',
            'type' => 'string',
            'searchable' => false,
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
            'closure' => function($row) {
                if($row->status == 'rejected') {
                    return  '<span class="bg-red-100 text-red-600 px-2 py-2 rounded-lg text-xs" data-toggle="tooltip" tooltip="'.$row->rejection_reason.'">'.$row->status.'</span>';
                } elseif($row->status == 'approved') {
                    return  '<span class="bg-green-100 text-green-600 px-2 py-2 rounded-lg text-xs" data-toggle="tooltip" tooltip="'.$row->rejection_reason.'">'.$row->status.'</span>';
                } elseif($row->status == 'pending') {
                    return  '<span class="bg-yellow-100 text-yellow-600 px-2 py-2 rounded-lg text-xs" data-toggle="tooltip" tooltip="'.$row->rejection_reason.'">'.$row->status.'</span>';
                }
            }
        ]);

        $this->addColumn([
            'index' => 'template_id',
            'label' => 'Whatsapp Template',
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
        if (bouncer()->hasPermission('admin.whatsapp.templates.show')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.whatsapp.templates.show', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.whatsapp.templates.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.whatsapp.templates.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.whatsapp.templates.sync')) {
            $this->addMassAction([
                'icon' => 'rotate_left',
                'title' => 'Sync',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.whatsapp.templates.sync',
            ]);
        }

        if (bouncer()->hasPermission('admin.whatsapp.templates.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Template',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.whatsapp.templates.create',
            ]);
        }
    }
}