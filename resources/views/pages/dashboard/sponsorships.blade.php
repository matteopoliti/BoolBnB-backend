@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Card dell'appartamento -->
            <div class="col-lg-8">
                <div class="card">
                    @if (Str::startsWith($apartment->cover_image, 'https'))
                        <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}" class="card-img-top">
                    @else
                        <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}"
                            class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title fw-bolder">{{ $apartment->title }}</h4>
                        <p class="card-text">{{ $apartment->description }}</p>
                        <h5 class="fw-bold mb-0">{{ $apartment->price }} &euro;/notte</h5>
                    </div>
                </div>
            </div>

            <!-- Checkout -->
            <div class="col-lg-4 d-flex flex-column justify-content-around">

                <div class="text-center mb-3 fs-6">
                    Fare click sulla card per selezionare il piano di sponsorizzazione desiderato
                </div>

                <!-- Card -->
                <div>
                    @foreach ($sponsorships as $sponsorship)
                        <div class="mb-3">
                            <div class="card text-center sponsorship-card" data-id="{{ $sponsorship->id }}"> <!-- Aggiunto attributo data-id per memorizzare l'ID del tier -->
                                <div class="card-header m-0 p-2">
                                    <h5 class="m-0 fw-bolder">{{ $sponsorship->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $sponsorship->duration }} ore di visibilità</p>
                                    <h5 class="card-title fw-semibold">{{ $sponsorship->amount }} €</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('braintree.token') }}" method="POST" id="sponsorship-form"
                        class="text-center">
                        @csrf
                        <input type="hidden" name="sponsorship_id" id="selected-sponsorship">
                        <input type="hidden" name="amount" id="selected-sponsorship-amount"> <!-- Aggiunto campo nascosto per l'importo -->
                        <input type="hidden" name="apartment_id" id="current-apartment-id" value="{{ $apartment_id }}"> <!-- Aggiunto campo nascosto per l'importo -->
                        <button type="submit" class="btn btn-success mt-3">Procedi al pagamento</button> <!-- Cambiato da 'a' a 'button' -->
                    </form>
                    <!-- Div per il messaggio di errore -->
                    <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
                </div>

            </div>

        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.sponsorship-card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                cards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selected-sponsorship').value = this.dataset.id;
                console.log(this.dataset.id);
                document.getElementById('selected-sponsorship-amount').value = this.querySelector('.card-title').innerText.replace('€', ''); // Aggiorna l'importo
            });
        });

        // Gestisci il caso in cui nessuna sponsorizzazione è stata selezionata prima dell'invio del form
        document.getElementById('sponsorship-form').addEventListener('submit', function(event) {
            const selectedSponsorshipId = document.getElementById('selected-sponsorship').value;
            if (!selectedSponsorshipId) {
                event.preventDefault(); // Impedisce l'invio del form se nessuna sponsorizzazione è stata selezionata
                // Mostra il messaggio di errore
                document.getElementById('error-message').innerText = 'Seleziona un piano di sponsorizzazione prima di procedere al pagamento.';
                document.getElementById('error-message').style.display = 'block';
            }
        });
    });
</script>

<style>
    .selected .card-header {
        background-color: rgb(24, 196, 180, 0.8);
        color: #0B262F;
    }

    .selected .card-body {
        background-color: rgb(24, 196, 180, 0.2);
        color: #0B262F;
    }

    /* Stile per il messaggio di errore */
    #error-message {
        display: none;
    }
</style>
