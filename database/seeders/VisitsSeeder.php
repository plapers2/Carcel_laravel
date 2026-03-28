<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VisitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('visits')->insert([
                'visitor_relationship' => $faker->word(),
                'start_date' => $faker->dateTime(),
                'end_date' => $faker->dateTime(),
                'verification' => $faker->randomElement(['En curso', 'Desaprobada', 'Terminada']),
                'prisoners_id' => $faker->numberBetween(1,20),
                'visitors_id' => $faker->numberBetween(1, 20),
                'users_id' => $faker->numberBetween(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
