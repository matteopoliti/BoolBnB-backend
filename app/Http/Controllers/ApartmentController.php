<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Auth;

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
        //
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
