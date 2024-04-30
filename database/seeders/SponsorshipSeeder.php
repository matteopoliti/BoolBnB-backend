<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Sponsorship;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sponsorship::create([
            'amount' => 2.99,
            'name' => 'Silver Package',
            'duration' => 24 
        ]);

        Sponsorship::create([
            'amount' => 5.99,
            'name' => 'Gold Package',
            'duration' => 72
        ]);

        Sponsorship::create([
            'amount' => 9.99,
            'name' => 'Platinum Package',
            'duration' => 144 
        ]);
    }
}
