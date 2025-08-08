<?php

namespace Modules\Leads\Database\Seeders;

use Modules\Leads\Models\TagsModel;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactorySeeder extends Factory
{
    public function definition()
    {
        
        TagsModel::factory()->create([
             'name' => $this->faker->word,
             'slug' => $this->faker->unique()->slug,
             'color' => $this->faker->hexColor
        ]);
    }
}