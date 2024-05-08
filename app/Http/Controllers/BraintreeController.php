<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;


class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->middleware('auth')->only(['payment']); // Ensure only authenticated users can access the payment route

        $this->gateway = new BraintreeGateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);
    }

    public function token(Request $request)
    {
        $amount = $request->amount;  // Recupera l'importo dal form
        $sponsorship_id = $request->sponsorship_id;  // Recupera l'importo dal form
        $apartment_id = $request->apartment_id;  // Recupera l'importo dal form

        $apartment = Apartment::find($apartment_id);
        $sponsorship = Sponsorship::find($sponsorship_id);

        Session::put('payment_amount', $amount);  // Salva l'importo nella sessione
        Session::put('sponsorship_id', $sponsorship_id);  // Salva l'importo nella sessione
        Session::put('apartment_id', $apartment_id);  // Salva l'importo nella sessione

        $token = $this->gateway->clientToken()->generate();
        return view('pages.braintree.token', ['token' => $token, 'apartment' => $apartment,  'sponsorship' => $sponsorship]);
    }

    public function payment(Request $request)
    {
        $nonce = $request->payment_method_nonce;

        $amount = Session::get('payment_amount');  // Recupera l'importo dalla sessione

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => ['submitForSettlement' => true]
        ]);

        if ($result->success) {
            $sponsorship = Sponsorship::find(Session::get('sponsorship_id'));
            $apartmentId = Session::get('apartment_id');

            // Prendi l'ultima sponsorizzazione di questo appartamento che non è ancora scaduta
            $lastSponsorship = ApartmentSponsorship::where('apartment_id', $apartmentId)
                ->where('expiration_date', '>', Carbon::now())
                ->orderBy('expiration_date', 'desc')
                ->first();

            // Se esiste una sponsorizzazione attiva, imposta la `created_at` della nuova sponsorizzazione alla sua `expiration_date`
            $startDate = $lastSponsorship ? Carbon::parse($lastSponsorship->expiration_date) : Carbon::now();
            $currentTime = Carbon::now();

            // Calcola la nuova `expiration_date`
            $expirationDate = (clone $startDate)->addHours($sponsorship->duration);

            // Crea la nuova sponsorizzazione
            $apartmentSponsorship = ApartmentSponsorship::create([
                'apartment_id' => $apartmentId,
                'sponsorship_id' => $sponsorship->id,
                'created_at' => $currentTime,
                'start_date' => $startDate,
                'expiration_date' => $expirationDate
            ]);

            return redirect()->route('payment.success')->with('apartmentSponsorshipId', $apartmentSponsorship->id);
        } else {
            return back()->withErrors('An error occurred with the payment.');
        }
    }

    public function showAllSponsorships()
    {
        $userId = Auth::id(); // ID dell'utente autenticato

        $totalSponsorships = ApartmentSponsorship::with(['apartment' => function ($query) {
            $query->withTrashed(); // Carica relazioni anche con gli appartamenti soft-deleted
        }, 'sponsorship'])
            ->where(function ($query) use ($userId) {
                $query->whereHas('apartment', function ($subQuery) use ($userId) {
                    $subQuery->withTrashed() // Include appartamenti eliminati
                        ->where('user_id', $userId);
                })
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereNull('apartment_id'); // Include record dove apartment_id è null
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();



        // Return the view with apartments and their messages
        return view('pages.dashboard.sponsors', compact('totalSponsorships'));
    }
}
