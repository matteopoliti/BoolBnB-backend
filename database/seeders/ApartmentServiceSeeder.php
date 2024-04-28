<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartmentIds = Apartment::pluck('id')->all();
        $serviceIds = Service::pluck('id')->all();

        $existingPairs = [];  // Array to keep track of already inserted pairs
        $servicesPerApartment = array_fill_keys($apartmentIds, 0);

        do {
            do {
                $randomApartmentId = $apartmentIds[array_rand($apartmentIds)];
                $randomServiceId = $serviceIds[array_rand($serviceIds)];
                $pair = $randomApartmentId . '-' . $randomServiceId;
            } while (isset($existingPairs[$pair]));  // Check if the pair has been already used

            $existingPairs[$pair] = true;  // Mark this pair as used
            $servicesPerApartment[$randomApartmentId]++;

            DB::table('apartment_service')->insert([
                'apartment_id' => $randomApartmentId,
                'service_id' => $randomServiceId,
            ]);

            $allCovered = true;
            foreach ($servicesPerApartment as $servicesCount) {
                if ($servicesCount == 0) {
                    $allCovered = false;
                    break;
                }
            }
        } while (!$allCovered);
    }
}
