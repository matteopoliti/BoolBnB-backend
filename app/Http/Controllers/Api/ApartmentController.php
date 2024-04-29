<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');

        $apartments = Apartment::with('services')->where('is_available', 1)
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })->paginate(12);

        $services = Service::all();

        return response()->json([
            'success' => true,
            'apartments' => $apartments,
            'services' => $services
        ]);
    }

    public function filter(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        $beds = $request->input('num_beds');
        $rooms = $request->input('num_rooms');
        $services = $request->input('services', []); // Default to an empty array if not provided
        $category = $request->input('category');

        $earthRadius = 6371000;
        $maxDistance = $radius * 1000;

        $query = Apartment::with('services')->where('is_available', 1);

        if ($category) {
            $query->where('category', $category);
        }
        if ($beds) {
            $query->where('num_beds', '>=', $beds);
        }
        if ($rooms) {
            $query->where('num_rooms', '>=', $rooms);
        }
        if (count($services) > 0) {
            $query->when(!empty($services), function ($query) use ($services) {
                foreach ($services as $service) {
                    $query->whereHas('services', function ($q) use ($service) {
                        $q->where('services.id', $service);
                    });
                }
            });
        }

        if ($latitude && $longitude && $radius) {
            $query->selectRaw("
                *,
                ($earthRadius * acos(
                    cos(radians($latitude))
                    * cos(radians(latitude))
                    * cos(radians(longitude) - radians($longitude))
                    + sin(radians($latitude))
                    * sin(radians(latitude))
                )) AS distance
            ")
                ->having('distance', '<=', $maxDistance)
                ->orderBy('distance');
        }

        $apartments = $query->paginate(12);

        return response()->json([
            'success' => true,
            'apartments' => $apartments
        ]);
    }

    public function show($slug)
    {
        $apartment = Apartment::with('services')->where('slug', $slug)->first();


        if ($apartment) {
            return response()->json([
                'success' => true,
                'apartment' => $apartment,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => "L'appartamento selezionato non esiste"
            ]);
        }
    }
}
