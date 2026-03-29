<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->sentence(2),
                'email' => $faker->email(),
                'identification_number' => $faker->numberBetween(1000000, 99999999),
                'email_verified_at' => now(),
                'password' => $faker->password(5, 15),
                'remember_token' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
