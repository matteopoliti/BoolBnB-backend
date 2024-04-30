@extends('layouts.app')

@section('content')
    {{-- @dd($apartments) --}}
    <div class="container-fluid mt-3">
        <h1 class="mx-3">Appartamenti - {{ count($apartments) }}</h1>

        <div class="mx-3 mt-3">
            <a href="{{ route('dashboard.apartments.create') }}" class="btn btn-success ">
                Aggiungi
            </a>

            @foreach ($apartments as $apartment)
                <div class="card my-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if (Str::startsWith($apartment->cover_image, 'https'))
                                <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}"
                                    class="img-fluid rounded-start">
                            @else
                                <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}"
                                    class="img-fluid rounded-start">
                            @endif
                        </div>
                        <div class="col-md-8 d-flex">
                            <div class="card-body">
                                <h5 class="card-title fs-2 ">{{ $apartment->title }}</h5>
                                <p class="card-text mt-5 fs-5 text-capitalize ">{{ $apartment->category }}</p>
                                <p class="card-text my-5 fs-5">{{ $apartment->full_address }}</p>
                                <p class="card-text fs-5"><small class="text-body-secondary">Ultimo aggiornamento:
                                        {{ $apartment->updated_at }}</small></p>
                            </div>

                            <div class=" d-flex flex-column justify-content-center align-items-center  gap-5 p-3">
                                
                                {{-- Apartment show --}}
                                <div class="">
                                    <a class="btn btn-info"
                                        href="{{ route('dashboard.apartments.show', $apartment->slug) }}">
                                        <i class="fa-solid fa-circle-info"></i> Info
                                    </a>
                                </div>

                                {{-- Edit button --}}
                                <div class="">
                                    <a class="btn btn-warning"
                                        href="{{ route('dashboard.apartments.edit', $apartment->slug) }}">
                                        <i class="fa-solid fa-pen"></i> Modifica
                                    </a>
                                </div>

                                {{-- Sponsor button --}}
                                <div class="">
                                    <a class="btn btn-success"
                                        href="{{ route('apartments.sponsorships', $apartment->slug) }}">
                                        <i class="fa-solid fa-dollar"></i> Promuovi
                                    </a>
                                </div>

                                {{-- Delete button --}}
                                <div class="">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $apartment->id }}">
                                        <i class="fa-solid fa-trash"></i> Elimina
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $apartment->id }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">
                                                    Conferma eliminazione</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Questa operazione è irreversibile.</strong><br>Sei sicuro di
                                                voler eliminare l'appartamento: "{{ $apartment->title }}"
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annulla</button>
                                                <form
                                                    action="{{ route('dashboard.apartments.destroy', $apartment->slug) }}"
                                                    method="POST">

                                                    @csrf

                                                    @method('DELETE')

                                                    <input class="btn btn-danger" type="submit" value="Confermo">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
