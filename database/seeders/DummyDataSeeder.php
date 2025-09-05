<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $statusIds = [1, 2, 3, 4, 5, 6, 7]; 
        $sourceIds = [1, 2, 3, 4, 5];       
        $adminIds  = [1];                   
        $activityTypes = ['general', 'call', 'email', 'meeting'];
        $outcomes = ['positive', 'neutral', 'negative'];

        $cutoff = Carbon::create(2025, 8, 31, 23, 59, 59);

        for ($i = 0; $i < 365; $i++) {
            $createdAt = $faker->dateTimeBetween(
                $cutoff->copy()->subYear(),
                $cutoff
            );

            // Insert Lead
            $leadId = DB::table('leads')->insertGetId([
                'name'         => $faker->name,
                'email'        => $faker->unique()->safeEmail,
                'phone'        => $faker->phoneNumber,
                'company'      => $faker->company,
                'description'  => $faker->sentence,
                'value'        => $faker->numberBetween(1000, 100000),
                'industries'   => (string) $faker->numberBetween(1, 5),
                'website'      => $faker->url,
                'address'      => $faker->streetAddress,
                'address_2'    => $faker->secondaryAddress,
                'country'      => $faker->country,
                'state'        => $faker->state,
                'city'         => $faker->city,
                'postal_code'  => $faker->postcode,
                'custom_fields' => json_encode(['note' => $faker->sentence]),
                'status_id'    => $faker->randomElement($statusIds),
                'source_id'    => $faker->randomElement($sourceIds),
                'assigned_to'  => null,
                'created_by'   => 1,
                'source'       => null,
                'deleted_at'   => null,
                'created_at'   => $createdAt,
                'updated_at'   => $createdAt,
            ]);

            // Insert 100–150 lead activities for each lead
            $activitiesCount = rand(100, 150);
            for ($j = 0; $j < $activitiesCount; $j++) {
                $activityDate = $faker->dateTimeBetween($createdAt, 'now');
                DB::table('lead_activities')->insert([
                    'lead_id'          => $leadId,
                    'admin_id'         => $faker->randomElement($adminIds),
                    'type'             => $faker->randomElement($activityTypes),
                    'description'      => '<p>' . $faker->realText(rand(50, 200)) . '</p>',
                    'activity_date'    => $activityDate,
                    'duration_minutes' => $faker->numberBetween(1, 60),
                    'outcome'          => $faker->randomElement($outcomes),
                    'schedule_meeting' => $faker->boolean(20) ? $faker->dateTimeBetween('now', '+6 months') : null,
                    'created_at'       => $activityDate,
                    'updated_at'       => $activityDate,
                ]);
            }
        }
    }
}
