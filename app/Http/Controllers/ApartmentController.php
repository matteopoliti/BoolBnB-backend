<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Image;
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

        $apartments = Apartment::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->get();

        $categories = [
            'villa',
            'appartamento',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'roulotte'
        ];

        return view('pages.dashboard.index', compact('apartments', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories_apartment = [
            'villa',
            'appartamento',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'roulotte'
        ];

        $categories_images = [
            'soggiorno',
            'cucina',
            'bagno',
            'camera da letto',
            'garage',
            'giardino',
            'varie'
        ];


        $apiKey = env('TOMTOM_API_KEY');

        $services = Service::all();

        return view('pages.dashboard.create', compact('categories_apartment', 'categories_images', 'services', 'apiKey'));
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
            $path = Storage::disk('public')->put("apartment_images/$slug", $request->cover_image);

            $validated_data['cover_image'] = $path;
        }

        $new_apartment = Apartment::create($validated_data);

        if ($request->has('services')) {
            $new_apartment->services()->attach($request->services);
        };

        if ($request->has('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image->isValid()) {
                    $path = Storage::disk('public')->put("apartment_images/$slug/more_images", $image);

                    $validated_data['images'][$index] = $path;

                    // Creazione del record di immagine nel database
                    Image::create([
                        'apartment_id' => $new_apartment->id,
                        'path' => $path,
                        'category' => $validated_data['categories'][$index],
                    ]);
                }
            }
        }


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
        $categories_apartment = [
            'villa',
            'appartamento',
            'agriturismo',
            'baita',
            'castello',
            'loft',
            'roulotte'
        ];

        $categories_images = [
            'soggiorno',
            'cucina',
            'bagno',
            'camera da letto',
            'garage',
            'giardino',
            'varie'
        ];

        $apiKey = env('TOMTOM_API_KEY');

        $services = Service::all();

        $more_images = Image::where('apartment_id', $apartment->id)
            ->get();

        return view('pages.dashboard.edit', compact('categories_apartment', 'categories_images', 'apartment', 'more_images', 'services', 'apiKey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validated_data = $request->validated();

        $slug = Str::slug($request->title, '-');
        $validated_data['slug'] = $slug;

        if (!$request->has('is_available')) {
            $validated_data['is_available'] = 0;
        }

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

        if ($request->has('images') || $request->has('categories')) {

            foreach ($request->input('status') as $index => $status) {

                if ($status == "new") {

                    if ($validated_data['images'][$index]->isValid()) {
                        $path = Storage::disk('public')->put("apartment_images/$slug/more_images", $validated_data['images'][$index]);

                        $validated_data['images'][$index] = $path;
                        $category = $validated_data['categories'][$index];

                        Image::create([
                            'apartment_id' => $apartment->id,
                            'path' => $path,
                            'category' => $category,
                        ]);
                    };
                } elseif ($status == "both" || $status == "image" || $status == "select") {

                    if ($status == "both") {

                        if ($validated_data['images'][$index]->isValid()) {
                            $path = Storage::disk('public')->put("apartment_images/$slug/more_images", $validated_data['images'][$index]);

                            $validated_data['images'][$index] = $path;
                            $category = $validated_data['categories'][$index];
                            $image_id = $validated_data['image_id'][$index];

                            $image = Image::find($image_id);

                            $image->path = $path;
                            $image->category = $category;

                            $image->save();
                        };
                    } elseif ($status == "image") {

                        if ($validated_data['images'][$index]->isValid()) {
                            $path = Storage::disk('public')->put("apartment_images/$slug/more_images", $validated_data['images'][$index]);

                            $validated_data['images'][$index] = $path;
                            $category = $validated_data['categories'][$index];
                            $image_id = $validated_data['image_id'][$index];

                            $image = Image::find($image_id);

                            $image->path = $path;

                            $image->save();
                        };
                    } elseif ($status == "select") {

                        $category = $validated_data['categories'][$index];
                        $image_id = $validated_data['image_id'][$index];

                        $image = Image::find($image_id);

                        $image->category = $category;

                        $image->save();
                    };
                } else {
                };
            };
        };

        return redirect()->route('dashboard.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softDelete($slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        $apartment->delete();

        return redirect()->route('dashboard.apartments.index');
    }

    public function trashed()
    {
        $trashedApartments = Apartment::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('pages.dashboard.trashed', compact('trashedApartments'));
    }

    public function restore($slug)
    {
        $apartment = Apartment::onlyTrashed()
            ->where('slug', $slug)
            ->firstOrFail();

        $apartment->restore();

        return redirect()->route('dashboard.apartments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete($slug)
    {
        $apartment = Apartment::onlyTrashed()
            ->where('slug', $slug)
            ->firstOrFail();

        foreach ($apartment->messages as $message) {
            $message->delete();
        }

        $apartment->services()->detach();

        if ($apartment->cover_image) {

            Storage::delete($apartment->cover_image);
        }

        if ($apartment->images) {

            foreach ($apartment->images as $image) {

                Storage::delete($image->path);

                $image->delete();
            }
        }

        Storage::deleteDirectory("apartment_images/$slug");

        $apartment->forceDelete();

        return redirect()->route('dashboard.apartments.index');
    }
}
