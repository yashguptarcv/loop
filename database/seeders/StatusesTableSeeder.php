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
             ['type_code' => 'O', 'status_code' => 'O', 'name' => 'New'],
            // INCOMPLETE 
             ['type_code' => 'O', 'status_code' => 'N', 'name' => 'Incomplete'],
            // PENDING    
             ['type_code' => 'O', 'status_code' => 'P', 'name' => 'Pending'],
            // PROCESSING 
             ['type_code' => 'O', 'status_code' => 'H', 'name' => 'Processing'],
            // COMPLETED  
             ['type_code' => 'O', 'status_code' => 'Z', 'name' => 'Completed'],
            // FAILED     
             ['type_code' => 'O', 'status_code' => 'F', 'name' => 'Failed'],
            // REFUNDED   
             ['type_code' => 'O', 'status_code' => 'R', 'name' => 'Refunded'],
            // CANCELLED  
             ['type_code' => 'O', 'status_code' => 'C', 'name' => 'Cancelled'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
