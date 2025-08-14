<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Leads\Models\TagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactorySeeder extends Seeder
{
    public function run()
    {
        
        // TagsModel::factory()->create([
        //     'name' => $this->faker->word,
        //     'slug' => $this->faker->unique()->slug,
        //     'color' => $this->faker->hexColor
        // ]);
    }
}