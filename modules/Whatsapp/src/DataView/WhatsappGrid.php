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
                'icon' => 'eye',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.whatsapp.templates.show', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.whatsapp.templates.destroy')) {
            $this->addAction([
                'icon' => 'icon-delete',
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
        if (bouncer()->hasPermission('admin.whatsapp.templates.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'trash',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-white bg-red-600',
                'url' => 'admin.whatsapp.templates.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.whatsapp.templates.sync')) {
            $this->addMassAction([
                'icon' => 'icon-cached',
                'title' => 'Sync',
                'method' => 'GET',
                'action' => 'text-white bg-gray-500',
                'url' => 'admin.whatsapp.templates.sync',
            ]);
        }
        
        if (bouncer()->hasPermission('admin.whatsapp.index')) {
            $this->addMassAction([
                'icon' => 'icon-plane',
                'title' => 'Send Message',
                'method' => 'GET',
                'action' => 'text-white bg-gray-500',
                'url' => 'admin.whatsapp.index',
            ]);
        }

        if (bouncer()->hasPermission('admin.whatsapp.templates.create')) {
            $this->addMassAction([
                'icon' => 'plus',
                'title' => 'Create Template',
                'method' => 'GET',
                'action' => 'text-white bg-blue-500',
                'url' => 'admin.whatsapp.templates.create',
            ]);
        }
    }
}