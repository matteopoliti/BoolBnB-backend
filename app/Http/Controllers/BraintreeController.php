<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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

        // Session::flush();

        Session::put('payment_amount', $amount);  // Salva l'importo nella sessione
        Session::put('sponsorship_id', $sponsorship_id);  // Salva l'importo nella sessione
        Session::put('apartment_id', $apartment_id);  // Salva l'importo nella sessione

        $token = $this->gateway->clientToken()->generate();
        return view('pages.braintree.token', ['token' => $token]);
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

            $apartmentSponsorship = ApartmentSponsorship::create([
                'apartment_id' => Session::get('apartment_id'),
                'sponsorship_id' => Session::get('sponsorship_id'),
            ]);

            return redirect()->route('payment.success')->with('apartmentSponsorshipId', $apartmentSponsorship->id);
        } else {
            return back()->withErrors('An error occurred with the payment.');
        }
    }

    public function showAllSponsorships()
    {
        $userId = Auth::id(); // ID dell'utente autenticato

        $totalSponsorhips = ApartmentSponsorship::with(['apartment', 'sponsorship'])
            ->whereHas('apartment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();


        // Return the view with apartments and their messages
        return view('pages.dashboard.sponsors', compact('totalSponsorhips'));
    }
}
