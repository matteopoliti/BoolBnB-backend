@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <img src="{{ Str::startsWith($apartment->cover_image, 'https') ? $apartment->cover_image : asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}" class="card-img-top">

                <div class="card-body">
                    <h1 class="card-title">{{ $apartment->title }}</h1>
                    <p class="card-text">{{ $apartment->description }}</p>
                    <p class="text-capitalize text-muted">Categoria: <strong>{{ $apartment->category }}</strong></p>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Prezzo/Notte: <strong>{{ $apartment->price }}$</strong></li>
                    <li class="list-group-item">Stanze: <strong>{{ $apartment->num_rooms }}</strong></li>
                    <li class="list-group-item">Letti: <strong>{{ $apartment->num_beds }}</strong></li>
                    <li class="list-group-item">Bagni: <strong>{{ $apartment->num_bathrooms }}</strong></li>
                    <li class="list-group-item">Metri quadri: <strong>{{ $apartment->square_meters }} m²</strong></li>
                    <li class="list-group-item">Indirizzo completo: <strong>{{ $apartment->full_address }}</strong></li>
                    <li class="list-group-item">Disponibilità: <strong>{!! $apartment->is_available ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-xmark text-danger"></i>' !!}</strong></li>
                </ul>

                <div class="card-body">
                    <h5 class="card-title">Services</h5>
                    <div>
                        @foreach ($apartment->services as $item)
                        <span class="badge gradient-custom-2 px-3 py-2" style="color: white;">
                            <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->name }}" style="width: 20px; vertical-align: middle; margin-right: 5px; filter: brightness(0) invert(1);">
                            {{ $item->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
