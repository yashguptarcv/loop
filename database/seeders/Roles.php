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
        $roles = [
            'Administrator',
            'Manager',
            'E-Mail Markiting',
            'Staff',
            'Developer',
            'Sales'
        ];
        foreach ($roles as $key => $value) {
            DB::table('roles')->insert([                
                'name' => $value,
                'description' => "$value access",
                'permission_type' => 'all',
                'permissions' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);            
        }

        // DB::table('settings')->insert([
        //     'general.settings.default_lead_status'   => '1',
        //     'general.settings.lead_assigned_user'   => '1',
        //     'general.settings.default_currency'   => 'USD',
        //     'general.settings.whatsapp.access_token'   => 'EAANFZAOdPIK0BO6fZBOT7qD5tVx4GGDvKInFmeUaZAIP2GwRh4QgxJGDpPmkZCZAjGsUckBtJP0ehWmUDZCH976jso3TQYkp1ZCq5PUGoABwZBMrzdVuEI6dcP9lvf7BdSd1P8mBTyQAkbAMD6udjMpJMfsodZCWnDcfqWeAygzYpftdwdbzRmBGi1VA6tm22ZCmBmq1Q8MSoZD',
        //     'general.settings.whatsapp.phone_number'   => '620724541133590',
        //     'general.settings.whatsapp.business_account_id'   => '3587803424690704',
        // ]);
    }
}
