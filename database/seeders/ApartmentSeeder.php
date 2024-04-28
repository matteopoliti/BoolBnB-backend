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

        $userIds = User::pluck('id')->all();

        $categories = [
            'villa',
            'appartamento',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'roulotte'
        ];

        $categoriesQuery = [
            "villa+house",
            "apartment+building",
            "farmhouse+building",
            "cabin+in+woods",
            "castle+building",
            "skyline+apartment",
            "roulotte+camper",
        ];

        $apiKey = env('PIXABAY_API_KEY');

        foreach ($categories as $index => $category) {

            $apartments = config('apartments');

            $filtered_array = array_filter($apartments, function ($element) use ($category) {
                return $element['category'] === $category;
            });

            $apiQuery = $categoriesQuery[$index];
            $apiPage = 1;

            $index_image = 0;  // Initialize image index outside the loop

            $json = file_get_contents("https://pixabay.com/api/?key=" . $apiKey . "&q=" . $apiQuery . "&per_page=200&page=" . $apiPage);
            $obj = json_decode($json);

            foreach ($filtered_array as $index => $filtered_apartment) {
                if (count($obj->hits) == 200 && $index == 199) {
                    $apiPage++;  // Increment page number to fetch next set of images
                    $json = file_get_contents("https://pixabay.com/api/?key=" . $apiKey . "&q=" . $apiQuery . "&per_page=200&page=" . $apiPage);
                    $obj = json_decode($json);
                    $index_image = 0;  // Reset the image index for the new batch of images

                } elseif ($index_image >= count($obj->hits)) {
                    // Use fallback query
                    $apiQuery = "italian+houses";
                    $apiPage = 1;
                    $json = file_get_contents("https://pixabay.com/api/?key=" . $apiKey . "&q=" . $apiQuery . "&per_page=200&page=" . $apiPage);
                    $obj = json_decode($json);
                    $index_image = 0;
                }

                $apiImg = $obj->hits[$index_image]->webformatURL;
                $index_image++;

                $randomUserId = $userIds[array_rand($userIds)];

                Apartment::create([
                    'user_id' => $randomUserId,
                    'title' => $filtered_apartment['title'],
                    'slug' => Str::slug($filtered_apartment['title'], '-'),
                    'category' => $filtered_apartment['category'],
                    'price' => $filtered_apartment['price'],
                    'description' => $filtered_apartment['description'],
                    'num_rooms' => $filtered_apartment['num_of_rooms'],
                    'num_beds' => $filtered_apartment['num_of_beds'],
                    'num_bathrooms' => $filtered_apartment['num_bathrooms'],
                    'square_meters' => $filtered_apartment['square_meters'],
                    'full_address' => $filtered_apartment['full_address'],
                    'latitude' => $filtered_apartment['lat'],
                    'longitude' => $filtered_apartment['long'],
                    'cover_image' => $apiImg,
                    'is_available' => true,
                ]);
            }
        }
    }
}
