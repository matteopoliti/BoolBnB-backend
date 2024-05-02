<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;
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
        Session::put('payment_amount', $amount);  // Salva l'importo nella sessione

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
            return redirect()->route('payment.success')->with('success', 'Transaction successful!');
        } else {
            return back()->withErrors('An error occurred with the payment.');
        }
    }
}
