<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = config('services');

        foreach ($services as $element) {
            Service::create([
                'name' => $element['name'],
            ]);
        }
    }
}
