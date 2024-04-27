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

        for ($i = 1; $i <= 1200; $i++) {

            $randomApartmentId = $apartmentIds[array_rand($apartmentIds)];

            $randomServiceId = $serviceIds[array_rand($serviceIds)];

            DB::table('apartment_service')->insert([
                'apartment_id' => $randomApartmentId,
                'service_id' => $randomServiceId,
            ]);
        }
    }
}
