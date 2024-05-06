{{-- resources/views/pages/dashboard/sponsors.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1 class="mb-4 fw-bold">Lista Sponsorizzazioni</h1>
        <div class="accordion" id="sponsorshipAccordion">
            @foreach ($totalSponsorships as $index => $sponsorship)
                <div class="card mb-2 sponsorship-card">
                    <div class="card-header sponsorship-card-header" id="heading{{ $sponsorship->id }}">
                        <h5 class="mb-0">
                            <button class="btn w-100 text-start" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $sponsorship->id }}"
                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $sponsorship->id }}">
                                Sponsorizzazione {{ $sponsorship->apartment ? $sponsorship->apartment->title : '' }}
                                del <span class="datetime">{{ $sponsorship->created_at->toIso8601String() }}</span>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $sponsorship->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $sponsorship->id }}" data-bs-parent="#sponsorshipAccordion">
                        <div class="card-body sponsorship-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($sponsorship->apartment)
                                        @if (Str::startsWith($sponsorship->apartment->cover_image, 'https'))
                                            <img src="{{ $sponsorship->apartment->cover_image }}"
                                                alt="{{ $sponsorship->apartment->slug }}" class="img-fluid rounded mb-3">
                                        @else
                                            <img src="{{ asset('storage/' . $sponsorship->apartment->cover_image) }}"
                                                alt="{{ $sponsorship->apartment->slug }}" class="img-fluid rounded mb-3">
                                        @endif
                                        <h5 class="fw-bolder">Dettagli Appartamento:</h5>
                                        <p><strong>Titolo:</strong> <a
                                                href="{{ route('dashboard.apartments.show', $sponsorship->apartment->slug) }}">{{ $sponsorship->apartment->title }}</a>
                                        </p>
                                    @else
                                        <div class="img-fluid rounded mb-3 position-relative"
                                            style="height: 412.98px; background-color: rgba(0, 0, 0, 0.05);">
                                            <img src="{{ Vite::asset('resources/assets/img/404-Icon.png') }}"
                                                class="position-absolute top-50 start-50 translate-middle"
                                                style="max-height: 60px; width: 60px;"></img>
                                        </div>
                                        <h5 class="fw-bolder pb-3 border-bottom">Dettagli Appartamento:</h5>
                                        <p><em>Appartamento non più disponibile.</em></p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bolder pb-3 border-bottom">Dettagli Sponsorizzazione</h5>
                                    <p class="pt-2"><strong>Tipologia:</strong> {{ $sponsorship->sponsorship->name }}</p>
                                    <p><strong>Durata:</strong> {{ $sponsorship->sponsorship->duration }} ore</p>
                                    <p><strong>Costo:</strong> {{ $sponsorship->sponsorship->amount }} €</p>
                                    <p><strong>Codice Sponsor:</strong>
                                        <span> #{{ $sponsorship->id }}</span>
                                    </p>
                                    <hr>
                                    <p><strong>Data Transazione:</strong> <span
                                            class="datetime">{{ $sponsorship->created_at->toIso8601String() }}</span></p>
                                    <p><strong>Inizio Sponsor:</strong> <span
                                            class="datetime">{{ $sponsorship->start_date->toIso8601String() }}</span></p>
                                    <p><strong>Fine Sponsor:</strong> <span
                                            class="datetime">{{ $sponsorship->expiration_date->toIso8601String() }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dates = document.querySelectorAll('.datetime');
            dates.forEach(function(dateElement) {
                const utcDate = new Date(dateElement.textContent);
                dateElement.textContent = utcDate.toLocaleString('it-IT', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            });

            const accordion = document.getElementById('sponsorshipAccordion');
    
            // Event listeners per gli eventi di show e hide del collapse di Bootstrap
            accordion.addEventListener('show.bs.collapse', function(event) {
                // Trova il card-header associato al collapse aperto
                const cardHeader = event.target.previousElementSibling;
                cardHeader.classList.add('active');
            });
            
            accordion.addEventListener('hide.bs.collapse', function(event) {
                // Trova il card-header associato al collapse che si sta chiudendo
                const cardHeader = event.target.previousElementSibling;
                cardHeader.classList.remove('active');
            });
             // Controlla se qualche collapse è già aperto al caricamento e aggiungi la classe active
            document.querySelectorAll('.collapse.show').forEach(function(collapseElement) {
                const cardHeader = collapseElement.previousElementSibling;
                cardHeader.classList.add('active');
            });
        });
    </script>

    <style>

    </style>
@endsection
