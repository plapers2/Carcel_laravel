<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VisitorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++) {
            DB::table('visitors')->insert([
                'name' => $faker->sentence(2),
                'identification_number' => $faker->numberBetween(1000000, 99999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
