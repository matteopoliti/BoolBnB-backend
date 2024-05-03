<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Sponsorship;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ApartmentSponsorshipSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ottieni tutte le sponsorizzazioni
        $sponsorships = Sponsorship::all();

        // Inizializza la data di creazione al 1 gennaio 2024
        $createdTime = Carbon::create(2018, 1, 1);

        // Itera 250 volte
        for ($j = 0; $j < 250; $j++) {
            // Ottieni un appartamento casuale
            $apartment = Apartment::where('is_available', 1)->inRandomOrder()->first();

            // Genera un numero casuale di sponsorizzazioni per questo appartamento (da 1 a 3)
            $numSponsorships = rand(1, 3);

            for ($i = 0; $i < $numSponsorships; $i++) {
                // Seleziona casualmente una sponsorship
                $sponsorship = $sponsorships->random();

                $apartmentId = $apartment->id;

                // Incrementa la data di creazione di un numero casuale di giorni (da 1 a 6)
                $createdTime->addDays(rand(1, 6));

                $createdTime->addHours(rand(0, 23));

                $createdTime->addMinutes(rand(0, 59));

                $lastSponsorship = ApartmentSponsorship::where('apartment_id', $apartmentId)
                    ->where('expiration_date', '>', $createdTime)
                    ->orderBy('expiration_date', 'desc')
                    ->first();

                $startDate = $lastSponsorship ? Carbon::parse($lastSponsorship->expiration_date) : $createdTime;

                $expirationDate = (clone $startDate)->addHours($sponsorship->duration);

                // Crea una nuova riga nella tabella pivot
                $apartment->sponsorships()->attach($sponsorship->id, [
                    'apartment_id' => $apartmentId,
                    'sponsorship_id' => $sponsorship->id,
                    'created_at' => $createdTime,
                    'start_date' => $startDate,
                    'expiration_date' => $expirationDate
                ]);
            }
        }
    }
}
