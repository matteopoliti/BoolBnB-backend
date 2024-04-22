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

        foreach ($apartments as $element) {

            $randomUserId = array_rand($userIds);

            Apartment::create([
                'user_id' => $randomUserId,
                'title' => $element['title'],
                'slug' => Str::slug($element['title'], '-'),
                'category' => $element['category'],
                'price' => $element['price'],
                'description' => $element['description'],
                'num_rooms' => $element['num_of_rooms'],
                'num_beds' => $element['num_of_beds'],
                'num_bathrooms' => $element['num_bathrooms'],
                'square_meters' => $element['square_meters'],
                'full_address' => $element['full_address'],
                'latitude' => $element['lat'],
                'longitude' => $element['long'],
                'cover_image' => $element['img'],
                'is_available' => true,
            ]);
        }
    }
}
