<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = config('apartments');

        $userIds = User::pluck('id')->all();

        $categories = [
            'villa',
            'apartment',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'mobile house'
        ];

        $i = 0;

        foreach ($apartments as $element) {

            $randomUserId = $userIds[array_rand($userIds)];

            $randomCategory = $categories[array_rand($categories)];

            $apiKey = env('UNSPLASH_API_KEY');

            $apiRequest = "https://api.unsplash.com//search/photos/?client_id=" . $apiKey . "&query=house&per_page=" . count($apartments);

            $json = file_get_contents($apiRequest);
            $obj = json_decode($json);

            $apiImg = $obj->results[$i]->urls->regular;

            $i++;

            Apartment::create([
                'user_id' => $randomUserId,
                'title' => $element['title'],
                'slug' => Str::slug($element['title'], '-'),
                'category' => $randomCategory,
                'price' => $element['price'],
                'description' => $element['description'],
                'num_rooms' => $element['num_of_rooms'],
                'num_beds' => $element['num_of_beds'],
                'num_bathrooms' => $element['num_bathrooms'],
                'square_meters' => $element['square_meters'],
                'full_address' => $element['full_address'],
                'latitude' => $element['lat'],
                'longitude' => $element['long'],
                'cover_image' => $apiImg,
                'is_available' => true,
            ]);
        }
    }
}
