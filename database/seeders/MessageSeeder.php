<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Apartment;
use Faker\Factory as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('it_IT');

        // Ottieni tutti gli appartamenti
        $apartments = Apartment::all();

        // Genera messaggi casuali per ogni appartamento
        foreach ($apartments as $apartment) {
            // Genera un numero casuale di messaggi per questo appartamento (da 0 a 10)
            $numMessages = rand(0, 10);

            for ($i = 0; $i < $numMessages; $i++) {
                // Genera dati casuali per il messaggio
                $name = $faker->firstName . ' ' . $faker->lastName;
                $email = $faker->email;
                $message = $faker->realText();
                $createdAt = $faker->dateTimeBetween('-1 year', 'now');

                // Crea un nuovo messaggio
                Message::create([
                    'apartment_id' => $apartment->id,
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'created_at' => $createdAt,
                ]);
            }
        }
    }
}
