<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

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
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'identification_number' => $faker->numberBetween(1000000, 99999999),
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
