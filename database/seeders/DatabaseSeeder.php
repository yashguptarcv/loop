<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Leads\Database\Seeders\TagFactorySeeder;

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
      TagFactorySeeder::class,
    ]);

  }
}
