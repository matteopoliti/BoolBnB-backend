@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <img src="{{ Str::startsWith($apartment->cover_image, 'https') ? $apartment->cover_image : asset('storage/' . $apartment->cover_image) }}"
                    alt="{{ $apartment->slug }}" class="card-img-top">

                <div class="card-body">
                    <h1 class="card-title">{{ $apartment->title }}</h1>
                    <p class="card-text">{{ $apartment->description }}</p>
                    <p class="text-capitalize text-muted">Categoria: <strong>{{ $apartment->category }}</strong></p>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Prezzo/Notte: <strong>{{ $apartment->price }} €</strong></li>
                    <li class="list-group-item">Stanze: <strong>{{ $apartment->num_rooms }}</strong></li>
                    <li class="list-group-item">Letti: <strong>{{ $apartment->num_beds }}</strong></li>
                    <li class="list-group-item">Bagni: <strong>{{ $apartment->num_bathrooms }}</strong></li>
                    <li class="list-group-item">Metri quadri: <strong>{{ $apartment->square_meters }} m²</strong></li>
                    <li class="list-group-item">Indirizzo completo: <strong>{{ $apartment->full_address }}</strong></li>
                    <li class="list-group-item">Disponibilità: <strong>{!! $apartment->is_available
                        ? '<i class="fa-solid fa-check text-success"></i>'
                        : '<i class="fa-solid fa-xmark text-danger"></i>' !!}</strong></li>
                </ul>

                <div class="card-body">
                    <h5 class="card-title">Servizi</h5>
                    <div>
                        @foreach ($apartment->services as $item)
                            <span class="badge gradient-custom-2 px-3 py-2" style="color: white;">
                                <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->name }}"
                                    style="width: 20px; vertical-align: middle; margin-right: 5px; filter: brightness(0) invert(1);">
                                {{ $item->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                @if ($apartment->images->count() !== 0)
                <div class="card-body">
                    <h5 class="card-title">Immagini dell'appartamento</h5>
                    @php
                        $categories = $apartment->images->groupBy('category');
                    @endphp
                    @foreach ($categories as $category => $images)
                        <h6>{{ ucfirst($category) }}</h6>
                        <div id="carousel{{ $loop->index }}" class="carousel slide" data-bs-ride="carousel" style="position: relative;">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ Str::startsWith($image->path, 'https') ? $image->path : asset('storage/' . $image->path) }}" class="d-block w-100" alt="image_{{ $image->id }}" style="height: 300px; object-fit: cover;">
                                        
                                        <!-- Pulsante di eliminazione per ogni immagine -->
                                        <form action="{{ route('images.delete', ['id' => $image->id]) }}" method="POST" style="position: absolute; top: 10px; left: 10px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controlli della carosello -->
                            @if ($images->count() > 1)
                                <button class="carousel-control-prev position-absolute top-50 start-0 translate-middle-y" type="button" data-bs-target="#carousel{{ $loop->index }}" data-bs-slide="prev" style="height: 100px; width: 50px">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next position-absolute top-50 end-0 translate-middle-y" type="button" data-bs-target="#carousel{{ $loop->index }}" data-bs-slide="next" style="height: 100px; width: 50px">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                            <!-- Display image count -->
                            <div class="position-absolute top-0 end-0 bg-dark text-white p-2 rounded" style="background-color: rgba(0, 0, 0, 0.75); box-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                {{ $images->count() }} Immagin{{ $images->count() > 1 ? 'i' : 'e' }}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

<style>
    .carousel.slide:hover form{
        display: block

    }

    .carousel.slide form{
        display: none

    }
</style>
@endsection
