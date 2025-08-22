<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TaxSeeder;
use Modules\Leads\Database\Seeders\TagFactorySeeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      // CountrySeeder::class,
      // CurrencySeeder::class,
      // CountryStatesSeeder::class,
      // Roles::class,
      // StatusesTableSeeder::class,
      SettingSeeder::class
      // TaxSeeder::class,
      // TagFactorySeeder::class,
    ]);

  }
}
