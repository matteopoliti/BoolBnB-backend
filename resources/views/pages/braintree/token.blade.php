@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card gradient-custom-2 p-3">
                    <div class="card-body">
                        <div id="dropin-container"></div>

                        <!-- Form già presente nella pagina, nascosto -->
                        <form id="payment-form" style="display: none;" method="post" action="{{ route('payment.process') }}">
                            @csrf
                            <input type="hidden" name="payment_method_nonce" id="payment-method-nonce">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4 order-md-last mt-4 mt-lg-0 ">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-dark">Carrello</span>
                    <span class="badge gradient-custom-2 rounded-pill">1</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $sponsorship->name }}</h6>
                            <small class="text-body-secondary">Durata: {{ $sponsorship->duration }} ore</small>
                        </div>
                        <span class="text-body-secondary">{{ $sponsorship->amount }} €</span>
                    </li>

                </ul>
                <button id="submit-button" class="btn gradient-custom-2 text-light border-0 float-end">Conferma
                    pagamento</button>
            </div>
        </div>
    </div>

    <script>
        var button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: '{{ $token }}',
            container: '#dropin-container',
            translations: {
                // Traduzioni italiane
                cardNumberLabel: 'Numero della carta',
                expirationDateLabel: 'Data di scadenza',
                cvvLabel: 'Codice di sicurezza',
                payWithCard: 'Paga con la carta',
            }
        }, function(createErr, instance) {
            var noticeOfCollection = document.querySelector('.braintree-form__notice-of-collection');
            if (noticeOfCollection) {
                noticeOfCollection.innerHTML =
                    '<a href="https://www.paypal.com/us/legalhub/home" target="_blank" rel="noopener noreferrer">Pagando con la mia carta, accetto l\'Informativa sulla privacy di PayPal.</a>';
            }
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
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
