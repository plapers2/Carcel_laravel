<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PrisonersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES'); // Español

        $offenses = [
            'Robbery',
            'Drug trafficking',
            'Fraud',
            'Assault',
            'Homicide',
            'Kidnapping',
        ];

        for ($i = 0; $i < 50; $i++) {

            $birthDate = $faker->dateTimeBetween('-60 years', '-18 years');
            $admissionDate = $faker->dateTimeBetween($birthDate->format('Y-m-d'), 'now');

            DB::table('prisoners')->insert([
                'name' => $faker->name(), // nombre real
                'birth_date' => $birthDate,
                'admission_date' => $admissionDate,
                'offense' => $faker->randomElement($offenses), // delito realista
                'assigned_cell' => 'Cell-' . $faker->numberBetween(1, 200), // formato lógico
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
