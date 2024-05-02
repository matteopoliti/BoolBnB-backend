@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Checkout</div>
                <div class="card-body">
                    <div id="dropin-container"></div>
                    <button id="submit-button" class="btn btn-primary">Conferma pagamento</button>
                    <!-- Form già presente nella pagina, nascosto -->
                    <form id="payment-form" style="display: none;" method="post" action="{{ route('payment.process') }}">
                        @csrf
                        <input type="hidden" name="payment_method_nonce" id="payment-method-nonce">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection
