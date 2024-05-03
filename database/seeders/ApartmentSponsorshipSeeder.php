<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Faker\Factory as Faker;
use Carbon\Carbon; // Aggiungi questo per usare Carbon

class ApartmentSponsorshipSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ottieni tutte le sponsorizzazioni
        $sponsorships = Sponsorship::all();

        // Itera 250 volte
        for ($j = 0; $j < 250; $j++) {
            // Ottieni un appartamento casuale
            $apartment = Apartment::inRandomOrder()->first();

            // Genera un numero casuale di sponsorizzazioni per questo appartamento (da 1 a 3)
            $numSponsorships = rand(1, 3);

            for ($i = 0; $i < $numSponsorships; $i++) {
                // Seleziona casualmente una sponsorship
                $sponsorship = $sponsorships->random();

                $current_time = Carbon::instance($faker->dateTimeBetween('-1 year', 'now'));
                $expirationDate = (clone $current_time)->addHours($sponsorship->duration);

                // Crea una nuova riga nella tabella pivot
                $apartment->sponsorships()->attach($sponsorship->id, [
                    'created_at' => $current_time,
                    'expiration_date' => $expirationDate,
                    'created_at' => $current_time,
                    'expiration_date' => $expirationDate
                ]);
            }
        }
    }
}
