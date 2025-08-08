<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Administrator',
            'description' => 'Full access to all system features',
            'permission_type' => 'all',
            'permissions' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
