<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index($slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
    
        $sponsorships = $apartment->sponsorships;
    
        return view('pages.dashboard.sponsorships', compact('sponsorships', 'apartment'));
    }
    

}
