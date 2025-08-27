<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WidgetsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('widgets')->insert([
            [
                'title' => 'Total Orders (This Week)',
                'table_name' => 'orders',
                'operation' => 'count',
                'is_currency' => 'N',
                'date_column' => 'orders.created_at',
                'date_filter' => 'week',
                'widget_type' => 'stat',
                'sort_order' => 2,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'Revenue This Week',
                'table_name' => 'orders',
                'column_name' => 'orders.total',
                'operation' => 'sum',
                'is_currency' => 'Y',
                'date_column' => 'orders.created_at',
                'date_filter' => 'week',
                'widget_type' => 'stat',
                'group_by' => 'orders.created_at',
                'sort_order' => 3,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'Orders: Current vs Last Month',
                'table_name' => 'orders',
                'column_name' => 'orders.id',
                'operation' => 'count',
                'is_currency' => 'N',
                'date_column' => 'orders.created_at',
                'date_filter' => 'year',
                'widget_type' => 'bar',
                'group_by' => "DATE_FORMAT(orders.created_at, '%M')",
                'sort_order' => 7,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'Daily Sales Trend (This Month)',
                'table_name' => 'orders',
                'column_name' => 'orders.total',
                'operation' => 'sum',
                'is_currency' => 'Y',
                'date_column' => 'orders.created_at',
                'date_filter' => 'year',
                'widget_type' => 'line',
                'group_by' => "DATE_FORMAT(orders.created_at, '%M')",
                'sort_order' => 6,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:36',
            ],
            [
                'title' => 'Leads ( Monthly )',
                'table_name' => 'leads',
                'column_name' => 'leads.id',
                'operation' => 'month_compare',
                'is_currency' => 'N',
                'date_column' => 'leads.created_at',
                'date_filter' => 'week',
                'widget_type' => 'stat',
                'group_by' => '',
                'sort_order' => 5,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'Compare',
                'table_name' => 'orders',
                'column_name' => 'orders.total',
                'operation' => 'month_compare',
                'is_currency' => 'Y',
                'date_column' => 'orders.created_at',
                'date_filter' => 'week',
                'widget_type' => 'stat',
                'group_by' => '',
                'sort_order' => 1,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'World Map',
                'table_name' => 'orders',
                'column_name' => 'orders.total',
                'operation' => 'sum',
                'is_currency' => 'Y',
                'date_column' => '',
                'date_filter' => 'none',
                'widget_type' => 'worldmap',
                'group_by' => 'orders.shipping_address->country',
                'sort_order' => 8,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
            [
                'title' => 'Application ( Week )',
                'table_name' => 'applications',
                'column_name' => '',
                'operation' => 'month_compare',
                'is_currency' => 'N',
                'date_column' => 'applications.created_at',
                'date_filter' => 'week',
                'widget_type' => 'stat',
                'group_by' => '',
                'sort_order' => 4,
                'created_at' => '2025-08-26 23:05:15',
                'updated_at' => '2025-08-27 06:37:15',
            ],
        ]);
    }
}
