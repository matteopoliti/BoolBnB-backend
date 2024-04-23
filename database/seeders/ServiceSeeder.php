<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = config('services');

        foreach ($services as $element) {

            $iconPath = public_path('icons_services/' . $element['icon']);


            $storageIconName = 'icons/' . uniqid() . '.' . $element['icon'];

            Storage::put($storageIconName, file_get_contents($iconPath));


            Service::create([
                'name' => $element['name'],
                'icon' => $storageIconName,
            ]);
        }
    }
}
