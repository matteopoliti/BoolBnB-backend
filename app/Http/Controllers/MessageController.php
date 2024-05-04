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
        $userId = Auth::id();  // Get the ID of the currently authenticated user
        $apartments = Apartment::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->where('is_available', 1)
            ->whereNull('deleted_at')
            ->where('user_id', $userId)->get();  // Eager load messages related to the user's apartments

        $totalMessages = $apartments->reduce(function ($carry, $apartment) {
            return $carry + $apartment->messages->count();
        }, 0);

        // Return the view with apartments and their messages
        return view('pages.dashboard.messages', compact('apartments', 'totalMessages'));
    }
}
