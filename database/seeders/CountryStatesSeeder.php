<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($parameters = [])
    {
        DB::table('country_states')->delete();

        $states = json_decode(file_get_contents(__DIR__.'/../../modules/Core/src/Data/states.json'), true);

        DB::table('country_states')->insert($states);
    }
} 