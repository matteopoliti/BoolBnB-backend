@extends('layouts.app')

@section('content')
<div class="container">
    <div id="dropin-container"></div>
    <button id="submit-button">Submit Payment</button>

    <!-- Form già presente nella pagina, nascosto -->
    <form id="payment-form" style="display: none;" method="post" action="{{ route('payment.process') }}">
        @csrf
        <input type="hidden" name="payment_method_nonce" id="payment-method-nonce">
    </form>

    <script>
        var button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: '{{ $token }}',
            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    // Imposta il valore del nonce nel campo nascosto del form
                    document.getElementById('payment-method-nonce').value = payload.nonce;
                    // Invia il form
                    document.getElementById('payment-form').submit();
                });
            });
        });
    </script>
</div>
@endsection
