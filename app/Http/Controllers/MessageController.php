<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of all messages for the user's apartments.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllMessages()
    {
        $userId = Auth::id();  // Ottieni l'ID dell'utente attualmente autenticato
        $apartments = Apartment::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereNull('deleted_at')
            ->where('user_id', $userId)
            ->get();

        // Ordina gli appartamenti in base alla data del messaggio più recente
        $apartments = $apartments->sortByDesc(function ($apartment) {
            return $apartment->messages->first()->created_at ?? null;
        });

        $totalMessages = $apartments->reduce(function ($carry, $apartment) {
            return $carry + $apartment->messages->count();
        }, 0);

        // Restituisci la vista con gli appartamenti e i loro messaggi
        return view('pages.dashboard.messages', compact('apartments', 'totalMessages'));
    }
}
