<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Faker\Factory as Faker;

class ApartmentSponsorshipSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ottieni tutti gli appartamenti e le sponsorizzazioni
        $apartments = Apartment::all();
        $sponsorships = Sponsorship::all();

        // Genera sponsorship casuali per ogni appartamento
        foreach ($apartments as $apartment) {
            // Genera un numero casuale di sponsorizzazioni per questo appartamento (da 1 a 5)
            $numSponsorships = rand(1, 3);

            for ($i = 0; $i < $numSponsorships; $i++) {
                // Seleziona casualmente una sponsorship
                $sponsorship = $sponsorships->random();

                // Crea una nuova riga nella tabella pivot
                $apartment->sponsorships()->attach($sponsorship->id, [
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now')
                ]);
            }
        }
    }
}
