<?php

namespace Modules\Catalog\DataView;

use Illuminate\Http\Request;
use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;

class ProductGrid extends DataGrid
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
        return DB::table('products')
            ->leftJoin('category_product', 'products.id', '=', 'category_product.product_id')
            ->leftJoin('categories', 'category_product.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                'products.price',
                'products.sale_price',
                'products.track_stock',
                'products.stock_quantity',
                'products.stock_status',
                'products.status',
                'products.is_featured',
                'products.created_at',
                DB::raw('GROUP_CONCAT(categories.name SEPARATOR ", ") as category_names')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.sku',
                'products.price',
                'products.sale_price',
                'products.track_stock',
                'products.stock_quantity',
                'products.stock_status',
                'products.status',
                'products.is_featured',
                'products.created_at'
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
            'index' => 'sku',
            'label' => 'SKU',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'price',
            'label' => 'Price',
            'type' => 'decimal',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return number_format($row->price, 2);
            },
        ]);

        $this->addColumn([
            'index' => 'sale_price',
            'label' => 'Sale Price',
            'type' => 'decimal',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return $row->sale_price ? number_format($row->sale_price, 2) : '-';
            },
        ]);

        $this->addColumn([
            'index' => 'stock_quantity',
            'label' => 'Stock',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
            'closure' => function ($row) {
                $statusClasses = [
                    'draft' => 'bg-gray-500',
                    'hidden' => 'bg-yellow-500',
                    'active' => 'bg-green-500'
                ];
                return '<span class="px-2 py-1 text-xs rounded-full ' . $statusClasses[$row->status] . ' text-white">' .
                    ucfirst($row->status) .
                    '</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'is_featured',
            'label' => 'Featured',
            'type' => 'boolean',
            'searchable' => false,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return $row->is_featured
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-blue-500 text-white">Yes</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-gray-300 text-gray-700">No</span>';
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
        if (bouncer()->hasPermission('admin.catalog.products.edit')) {
            $this->addAction([
                'icon' => 'edit',
                'title' => 'Edit',
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.catalog.products.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.products.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.catalog.products.destroy', $row->id);
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
        if (bouncer()->hasPermission('admin.catalog.products.bulk-delete')) {
            $this->addMassAction([
                'icon' => 'delete',
                'title' => 'Bulk Delete',
                'method' => 'POST',
                'action' => 'text-red-600 bg-red-100',
                'url' => 'admin.catalog.products.bulk-delete',
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.products.create')) {
            $this->addMassAction([
                'icon' => 'add',
                'title' => 'Create Product',
                'method' => 'GET',
                'action' => 'text-blue-600 bg-blue-100',
                'url' => 'admin.catalog.products.create',
            ]);
        }

        if (bouncer()->hasPermission('admin.catalog.products.toggle-status')) {
            $this->addMassAction([
                'icon' => '',
                'title' => 'Status',
                'method' => 'POST',
                'url' => 'admin.catalog.products.toggle-status',
                'action' => 'bg-gray-500',
                'options' => [
                    ['label' => 'Draft', 'value' => 'draft'],
                    ['label' => 'Hidden', 'value' => 'hidden'],
                    ['label' => 'Active', 'value' => 'active'],
                ],
            ]);
        }
    }
}
