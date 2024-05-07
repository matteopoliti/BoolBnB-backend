<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Apartment; // Assicurati di avere questo model o simile per gli appartamenti
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MoreImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = Apartment::all(); // Assicurati che gli appartamenti siano disponibili

        $categories = [
            'soggiorno',
            'cucina',
            'bagno',
            'camera da letto',
            'garage',
            'giardino',
            'varie'
        ];

        $categoriesQuery = [
            "living+room",
            "kitchen",
            "bathroom",
            "bedroom",
            "garage",
            "garden",
            "interior+design",
        ];

        $apiKey = env('PIXABAY_API_KEY');
        $imagesPerCategory = [];

        // Fetching images for each category from API
        foreach ($categories as $index => $category) {
            $apiQuery = $categoriesQuery[$index];
            $apiPage = 1;

            $json = file_get_contents("https://pixabay.com/api/?key=" . $apiKey . "&q=" . $apiQuery . "&per_page=200&page=" . $apiPage . "&safesearch=true");
            $obj = json_decode($json);

            $imagesPerCategory[$category] = [];

            if (!empty($obj->hits)) {
                foreach ($obj->hits as $hit) {
                    $imagesPerCategory[$category][] = $hit->webformatURL;
                }
            }
        }

        // Associating random images with each apartment
        foreach ($apartments as $apartment) {
            $numImages = rand(5, 10); // Random number of images between 5 and 10

            for ($i = 0; $i < $numImages; $i++) {
                $randomCategory = $categories[array_rand($categories)]; // Random category
                $randomImage = $imagesPerCategory[$randomCategory][array_rand($imagesPerCategory[$randomCategory])];

                // Create image record
                Image::create([
                    'apartment_id' => $apartment->id,
                    'path' => $randomImage,
                    'category' => $randomCategory
                ]);
            }
        }
    }
}
