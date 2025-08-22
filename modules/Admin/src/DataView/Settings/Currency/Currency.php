<?php

namespace Modules\Admin\DataView\Settings\Currency;

use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class Currency extends DataGrid
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
        return DB::table('currencies')
            ->select(
                'id',
                'code',
                'name',
                'symbol',
                'decimal'
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
            'index' => 'code',
            'label' => 'Code',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Currency Name',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);


        $rates = DB::table('currency_exchange_rates')->pluck('rate', 'target_currency');

        $this->addColumn([
            'index' => 'rate',
            'label' => 'Currency Exchange Rate',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'closure' => function ($row) use ($rates) {
                
                return $rates[$row->id] ?? 'Unknown';
            },
        ]);
     

        $this->addColumn([
            'index' => 'symbol',
            'label' => 'Symbol',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,

        ]);

        $this->addColumn([
            'index' => 'decimal',
            'label' => 'Decimal',
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
        if (bouncer()->hasPermission('admin.settings.currencies.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Currency Edit',
                'method' => 'GET',
                'is_popup'  => true,
                'url' => function ($row) {
                    return route('admin.settings.currencies.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.settings.currencies.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.currencies.destroy', $row->id);
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

        if (bouncer()->hasPermission('admin.settings.currencies.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Currency',
                'method' => 'GET',
                'is_popup'  => true,
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.settings.currencies.create',
            ]);
        }
        if (bouncer()->hasPermission('admin.settings.currencies.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.settings.currencies.bulk-delete',
            ]);
        }
    }
}
