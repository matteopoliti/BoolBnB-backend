@extends('layouts.app')

@section('content')
    <div class="mx-3 mt-3">

        <div class="container">
            <h1 class="mt-2 fw-bold">{{ $apartment->title }}</h1>

            <p class="mt-3">{{ $apartment->description }}</p>

            <span>Category: <strong>{{ $apartment->category }}</strong></span>
            <br>


            <figure class="my-3">
                @if (Str::startsWith($apartment->cover_image, 'https://images.unsplash.com'))
                    <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}">
                @else
                    <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}">
                @endif
            </figure>

            <ul class=" list-unstyled  ">
                <li><strong>Price/night:</strong> {{ $apartment->price }}$</li>
                <li><strong>Rooms:</strong> {{ $apartment->num_rooms }}</li>
                <li><strong>Beds:</strong> {{ $apartment->num_beds }}</li>
                <li><strong>Bathrooms:</strong> {{ $apartment->num_bathrooms }}</li>
                <li><strong>Full address:</strong> {{ $apartment->full_address }}</li>
                <li><strong>Square meters:</strong> {{ $apartment->square_meters }} m2</li>
                <li><strong>Square meters:</strong> {{ $apartment->is_available }}</li>
            </ul>



            <a href="{{ route('dashboard.apartments.index') }}" class="btn btn-primary w-100">
                Torna a tutti gli appartamenti
            </a>
        </div>
    </div>
@endsection
