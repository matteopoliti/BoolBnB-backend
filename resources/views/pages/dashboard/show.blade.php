@extends('layouts.app')

@section('content')
    <div class="mx-3 mt-3">

        <div class="container">
            <h1 class="mt-2 fw-bold">{{ $apartment->title }}</h1>

            <p class="mt-3">{{ $apartment->description }}</p>

            <span>Categoria: <strong>{{ $apartment->category }}</strong></span>

            <figure class="my-3">
                @if (Str::startsWith($apartment->cover_image, 'https'))
                    <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}">
                @else
                    <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}">
                @endif
            </figure>

            <ul class="list-unstyled">
                <li><strong>Prezzo/Notte:</strong> {{ $apartment->price }}$</li>
                <li><strong>Stanze:</strong> {{ $apartment->num_rooms }}</li>
                <li><strong>Letti:</strong> {{ $apartment->num_beds }}</li>
                <li><strong>Bagni:</strong> {{ $apartment->num_bathrooms }}</li>
                <li><strong>Indirizzo completo:</strong> {{ $apartment->full_address }}</li>
                <li><strong>Metri quadri:</strong> {{ $apartment->square_meters }} m<sup>2</sup></li>
                <li><strong>Disponibile: </strong>
                    @if ($apartment->is_available)
                        <i class="fa-solid fa-check"></i>
                    @else
                        <i class="fa-solid fa-xmark"></i>
                    @endif
                </li>
            </ul>

            <span><strong>Services:</strong></span>
            @foreach ($apartment->services as $item)
                <span class="badge rounded-pill text-bg-primary">
                    <img src="{{ asset('/storage/' . $item->icon) }}" alt="{{ $item->name }}" style="width: 15px">
                    {{ $item->name }}
                </span>
            @endforeach

        </div>
    </div>
@endsection
