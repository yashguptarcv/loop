<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::info("comes");
        DB::table('countries')->delete();
       
        $countries = json_decode(file_get_contents(__DIR__.'/../../modules/Core/src/Data/countries.json'), true);

        DB::table('countries')->insert($countries);
    }
} 