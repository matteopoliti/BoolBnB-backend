<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index($slug, $id)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        $sponsorships = Sponsorship::all();

        $apartment_id = Apartment::findOrFail($id)->id;

        return view('pages.dashboard.sponsorships', compact('sponsorships', 'apartment', 'apartment_id'));
    }

    public function store(Request $request, $apartmentId)
    {
        // Validazione del form input
        $request->validate([
            'sponsorship_id' => 'required|exists:sponsorships,id',
        ]);

        // Trova l'appartamento basato sull'ID fornito
        $apartment = Apartment::findOrFail($apartmentId);

        // Trova la sponsorizzazione selezionata
        $sponsorship = Sponsorship::findOrFail($request->sponsorship_id);

        // Calcola la data di fine basata sulla durata della sponsorizzazione
        $startDate = now();
        $endDate = now()->addHours($sponsorship->duration);

        // Associa l'appartamento alla sponsorizzazione con dettagli aggiuntivi
        $apartment->sponsorships()->attach($sponsorship->id, [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        // Reindirizza l'utente con un messaggio di successo
        return redirect()->route('dashboard')->with('success', 'Sponsorizzazione applicata con successo!');
    }
}
