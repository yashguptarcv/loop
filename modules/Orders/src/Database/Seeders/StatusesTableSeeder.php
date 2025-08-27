<?php

namespace Modules\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            // Order Statuses
            ['type_code' => 'O', 'status_code' => 'O',  'name' => 'New'],
            ['type_code' => 'O', 'status_code' => 'P',  'name' => 'Pending'],
            ['type_code' => 'O', 'status_code' => 'A', 'name' => 'Processing'],
            ['type_code' => 'O', 'status_code' => 'J',  'name' => 'Completed'],
            ['type_code' => 'O', 'status_code' => 'N', 'name' => 'Cancelled'],
            ['type_code' => 'O', 'status_code' => 'R',  'name' => 'Returned'],

            // Shipping Statuses
            ['type_code' => 'S', 'status_code' => 'P',  'name' => 'Picked'],
            ['type_code' => 'S', 'status_code' => 'K', 'name' => 'Packed'],
            ['type_code' => 'S', 'status_code' => 'S', 'name' => 'Shipped'],
            ['type_code' => 'S', 'status_code' => 'D', 'name' => 'Delivered'],
            ['type_code' => 'S', 'status_code' => 'R', 'name' => 'Returned to Sender'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
