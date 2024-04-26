<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('services')->paginate(10);

        return response()->json([
            'success' => true,
            'apartments' => $apartments
        ]);
    }

    public function filter(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        // Calcola la distanza massima in metri dalla latitudine e longitudine specificate
        // Il raggio in metri è il radius convertito da km a metri
        $earthRadius = 6371000; // Raggio approssimativo della Terra in metri
        $maxDistance = $radius * 1000; // Converti il raggio da km a metri

        $apartments = Apartment::with('services')
            ->selectRaw("
                *,
                ( $earthRadius * acos(
                    cos( radians( $latitude ) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians( $longitude ) )
                    + sin( radians( $latitude ) )
                    * sin( radians( latitude ) )
                ) ) AS distance
            ")
            ->having('distance', '<=', $maxDistance)
            ->orderBy('distance')
            ->paginate(10);

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
