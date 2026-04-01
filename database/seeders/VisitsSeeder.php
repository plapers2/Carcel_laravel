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

        for ($i = 0; $i < 200; $i++) {
            // Genera un domingo aleatorio entre hace 6 meses y 3 meses en el futuro
            $sunday = \Carbon\Carbon::now()
                ->subMonths(6)
                ->addDays(rand(0, 270))
                ->next(\Carbon\Carbon::SUNDAY);

            // Hora aleatoria entre 14:00 y 16:30 (para que end_date no pase de 17:00)
            $hour = rand(14, 16);
            $minute = [0, 10, 20, 30, 40, 50][rand(0, 5)];
            // Si es 16, limitar minutos a máximo :30
            if ($hour === 16) {
                $minute = [0, 10, 20, 30][rand(0, 3)];
            }

            $startDate = $sunday->copy()->setTime($hour, $minute, 0);
            $endDate = $startDate->copy()->addMinutes(30);

            // Determina verification según las fechas
            if ($startDate->isFuture()) {
                $verification = 'Pending';
            } elseif ($startDate->isPast() && $endDate->isFuture()) {
                $verification = 'In progress';
            } else {
                $verification = $faker->randomElement(['Finished', 'Rejected']);
            }

            DB::table('visits')->insert([
                'visitor_relationship' => $faker->word(),
                'start_date'           => $startDate,
                'end_date'             => $endDate,
                'verification'         => $verification,
                'prisoners_id'         => $faker->numberBetween(1, 20),
                'visitors_id'          => $faker->numberBetween(1, 20),
                'users_id'             => $faker->numberBetween(1, 20),
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }
    }
}
