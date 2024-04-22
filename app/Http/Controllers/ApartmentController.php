<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $apartments = Apartment::where('user_id', $userId)->get();

        $table_headers_values = [
            'ID',
            'Title',
            'Slug',
            'Description',
            'Image',
            'Created At',
            'Updated At'
        ];

        $categories = [
            'villa',
            'apartment',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'mobile house'
        ];
        return view('pages.dashboard.index', compact('apartments', 'table_headers_values', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'villa',
            'apartment',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'mobile house'
        ];
        return view('pages.dashboard.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validated_data = $request->validated();

        $slug = Str::slug($request->title, '-');
        $validated_data['slug'] = $slug;

        $userId = Auth::id();
        $validated_data['user_id'] = $userId;
        dd($validated_data);

        $apiKey = env('TOMTOM_API_KEY');
        $response = Http::get('https://api.tomtom.com/search/2/geocode/' . urlencode($request->input('full_address')) . '.json?key=' . $apiKey);

        if ($response->successful()) {
            $data = $response;
            // Ottieni i dati come array JSON
        } else {
            // Gestisci eventuali errori
            $statusCode = $response->status();
            $errorMessage = $response->body();
        }
        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('apartments_images', $request->cover_image);

            $validated_data['cover_image'] = $path;
        }

        $new_apartment = new Apartment();
        $new_apartment = Apartment::create($validated_data);

        return redirect()->route('dashboard.apartments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
