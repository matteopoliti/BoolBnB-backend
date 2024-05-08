@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card  mb-3" style="border: 1px solid hsla(174, 77%, 44%, 1)">
                <div class="card-header gradient-custom-2 text-white">Conferma Transazione</div>
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

                     {{-- SPONSOR DETAILS --}}
                     <h5 class="text-dark">Dettagli della Sponsorizzazione:</h5>
                    <div class="row">
                        <div class="col-lg-6">

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong class="text-success">Pacchetto:</strong> {{ $apartmentSponsorship->sponsorship->name }}</li>
                                <li class="list-group-item"><strong class="text-success">Durata:</strong> {{ $apartmentSponsorship->sponsorship->duration }} ore</li>
                                <li class="list-group-item border-bottom-0"><strong class="text-success">Costo: </strong>{{ $apartmentSponsorship->sponsorship->amount }} €</li>
                            </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush" >
                                    <li class="list-group-item"><strong class="text-success">Data Transazione:</strong> <span class="datetime">{{ $apartmentSponsorship->created_at->toIso8601String() }}</span></li>
                                    <li class="list-group-item"><strong class="text-success">Inizio Sponsor:</strong> <span class="datetime">{{ $apartmentSponsorship->start_date->toIso8601String() }}</span></li>
                                    <li class="list-group-item"><strong class="text-success">Fine Sponsor:</strong> <span class="datetime">{{ $apartmentSponsorship->expiration_date->toIso8601String() }}</span></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <hr>
                    {{-- APARTMENT DETAILS  --}}
                    <div class="row">

                            
                                {{-- APARTEMNT IMG --}}
                                <div class="col-lg-3 col-sm-12 px-2 pb-2">
                                    <div class="ps-3" >
                                        @if (Str::startsWith($apartmentSponsorship->apartment->cover_image, 'https'))
                                        <img  style="max-height: 300px" src="{{ $apartmentSponsorship->apartment->cover_image }}" alt="{{ $apartmentSponsorship->apartment->slug }}" class="img-fluid pe-3">
                                        @else
                                        <img  style="max-height: 300px" src="{{ asset('storage/' . $apartmentSponsorship->apartment->cover_image) }}" alt="{{ $apartmentSponsorship->apartment->slug }}" class="img-fluid pe-3">
                                        @endif
                                    </div>
                                </div>
                            {{-- APARTEMENT DESCRIPTION --}}
                              <div class="col-lg-9 px-2">
                                <div class="px-3">
                                    <h5 class="mt-3 mb-2">Dettagli dell'Appartamento:</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong class="text-success">Titolo:</strong> {{ $apartmentSponsorship->apartment->title }}</li>
                                        <li class="list-group-item"><strong class="text-success">Prezzo: </strong>{{ $apartmentSponsorship->apartment->price }} €</li>
                                        <li class="list-group-item"><strong class="text-success">Indirizzo:</strong> {{ $apartmentSponsorship->apartment->full_address }}</li>
                                        {{-- <li class="list-group-item"><strong class="text-success">Descrizione:</strong> {{ $apartmentSponsorship->apartment->description }}</li> --}}
                                    </ul>
                                </div>
                                   
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
