<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;

class BraintreeController extends Controller
{
    public function token(Request $request)
    {

        $gateway = new BraintreeGateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env("BRAINTREE_MERCHANT_ID"),
            'publicKey' => env("BRAINTREE_PUBLIC_KEY"),
            'privateKey' => env("BRAINTREE_PRIVATE_KEY")
        ]);

        if ($request->input('nonce') != null) {
            $nonceFromTheClient = $request->input('nonce');

            $gateway->transaction()->sale([
                'amount' => '10.00',
                'paymentMethodNonce' => $nonceFromTheClient,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            return view('pages.dashboard.index');
        } else {
            $clientToken = $gateway->clientToken()->generate();
            return view('pages.dashboard.braintree', ['token' => $clientToken]);
        }
    }
}
