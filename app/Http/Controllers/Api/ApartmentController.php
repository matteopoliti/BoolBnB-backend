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
