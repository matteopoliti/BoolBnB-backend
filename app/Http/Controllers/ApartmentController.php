<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
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
            'Titolo',
            'Descrizione',
            'Aggiunta',
            'Ultima modifica'
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

        $services = Service::all();

        return view('pages.dashboard.create', compact('categories', 'services'));
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

        $apiKey = env('TOMTOM_API_KEY');
        $addressQuery = str_replace(' ', '+', $validated_data['full_address']);

        $coordinate = "https://api.tomtom.com/search/2/geocode/%7B$addressQuery%7D.json?key={$apiKey}";

        $json = file_get_contents($coordinate);
        $obj = json_decode($json);
        $lat = $obj->results[0]->position->lat;
        $lon = $obj->results[0]->position->lon;

        $validated_data['latitude'] = $lat;
        $validated_data['longitude'] = $lon;

        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('apartment_images', $request->cover_image);

            $validated_data['cover_image'] = $path;
        }

        $new_apartment = Apartment::create($validated_data);

        if ($request->has('services')) {
            $new_apartment->services()->attach($request->services);
        };

        return redirect()->route('dashboard.apartments.show', ['apartment' => $new_apartment->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('pages.dashboard.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
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

        $services = Service::all();

        return view('pages.dashboard.edit', compact('categories', 'apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validated_data = $request->validated();

        $slug = Str::slug($request->title, '-');
        $validated_data['slug'] = $slug;

        if ($apartment->full_address !== $validated_data['full_address']) {
            $apiKey = env('TOMTOM_API_KEY');
            $addressQuery = str_replace(' ', '+', $validated_data['full_address']);

            $coordinate = "https://api.tomtom.com/search/2/geocode/%7B$addressQuery%7D.json?key={$apiKey}";

            $json = file_get_contents($coordinate);
            $obj = json_decode($json);
            $lat = $obj->results[0]->position->lat;
            $lon = $obj->results[0]->position->lon;

            $validated_data['latitude'] = $lat;
            $validated_data['longitude'] = $lon;
        }

        if ($request->hasFile('cover_image')) {
            if ($apartment->cover_image) {
                Storage::delete($apartment->cover_image);
            }

            $path = Storage::disk('public')->put('apartment_images', $request->cover_image);

            $validated_data['cover_image'] = $path;
        }

        $apartment->update($validated_data);

        if ($request->has('services')) {
            $apartment->services()->sync($request->services);
        };

        return redirect()->route('dashboard.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->services()->sync([]);

        if ($apartment->cover_image) {

            Storage::delete($apartment->cover_image);
        }

        $apartment->delete();

        return redirect()->route('dashboard.apartments.index');
    }
}
