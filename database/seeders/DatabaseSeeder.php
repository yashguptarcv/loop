<?php

namespace Database\Seeders;

use Database\Seeders\TaxSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      CountrySeeder::class,
      CurrencySeeder::class,
      CountryStatesSeeder::class,
      Roles::class,
      StatusesTableSeeder::class,
      SettingSeeder::class,
      CategorySeeder::class,
      WidgetSeeder::class,
      TaxSeeder::class,
      TagFactorySeeder::class,
    ]);

  }
}
