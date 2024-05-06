@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">Conferma Transazione</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="mb-3">Grazie per il tuo acquisto!</h5>
                    <p>Ecco i dettagli del tuo ordine:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                @if (Str::startsWith($apartmentSponsorship->apartment->cover_image, 'https'))
                                <img src="{{ $apartmentSponsorship->apartment->cover_image }}" alt="{{ $apartmentSponsorship->apartment->slug }}" class="img-fluid rounded">
                                @else
                                <img src="{{ asset('storage/' . $apartmentSponsorship->apartment->cover_image) }}" alt="{{ $apartmentSponsorship->apartment->slug }}" class="img-fluid rounded">
                                @endif
                            </div>
                            <h6>Dettagli dell'Appartamento:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong class="text-success">Titolo:</strong> {{ $apartmentSponsorship->apartment->title }}</li>
                                <li class="list-group-item"><strong class="text-success">Prezzo: </strong>{{ $apartmentSponsorship->apartment->price }} €</li>
                                <li class="list-group-item"><strong class="text-success">Indirizzo:</strong> {{ $apartmentSponsorship->apartment->full_address }}</li>
                                <li class="list-group-item"><strong class="text-success">Descrizione:</strong> {{ $apartmentSponsorship->apartment->description }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">Dettagli della Sponsorizzazione:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong class="text-success">Pacchetto:</strong> {{ $apartmentSponsorship->sponsorship->name }}</li>
                                <li class="list-group-item"><strong class="text-success">Durata:</strong> {{ $apartmentSponsorship->sponsorship->duration }} ore</li>
                                <li class="list-group-item"><strong class="text-success">Costo: </strong>{{ $apartmentSponsorship->sponsorship->amount }} €</li>
                                <hr>
                                <li class="list-group-item"><strong class="text-success">Data Transazione:</strong> <span class="datetime">{{ $apartmentSponsorship->created_at->toIso8601String() }}</span></li>
                                <li class="list-group-item"><strong class="text-success">Inizio Sponsor:</strong> <span class="datetime">{{ $apartmentSponsorship->start_date->toIso8601String() }}</span></li>
                                <li class="list-group-item"><strong class="text-success">Fine Sponsor:</strong> <span class="datetime">{{ $apartmentSponsorship->expiration_date->toIso8601String() }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <p>Per domande o assistenza, non esitare a contattare il nostro supporto clienti.</p>
            </div>
        </div>
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
    });
</script>
@endsection
