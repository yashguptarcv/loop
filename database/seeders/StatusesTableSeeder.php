<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            // NEW        
             ['type_code' => 'O', 'status_code' => 'O', 'name' => 'New', 'color'    => 'blue'],
            // INCOMPLETE 
             ['type_code' => 'O', 'status_code' => 'N', 'name' => 'Incomplete', 'color' => 'yellow'],
            // PENDING    
             ['type_code' => 'O', 'status_code' => 'P', 'name' => 'Pending', 'color'    => 'red'],
            // PROCESSING 
             ['type_code' => 'O', 'status_code' => 'H', 'name' => 'Processing', 'color' => 'yellow'],
            // COMPLETED  
             ['type_code' => 'O', 'status_code' => 'Z', 'name' => 'Completed', 'color'  => 'green'],
            // FAILED     
             ['type_code' => 'O', 'status_code' => 'F', 'name' => 'Failed', 'color' => 'red'],
            // REFUNDED   
             ['type_code' => 'O', 'status_code' => 'R', 'name' => 'Refunded', 'color'   => 'purple'],
            // CANCELLED  
             ['type_code' => 'O', 'status_code' => 'C', 'name' => 'Cancelled', 'color'  => 'red'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
