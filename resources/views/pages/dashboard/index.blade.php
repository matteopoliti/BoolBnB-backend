@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mx-3 fw-bold">Appartamenti &#40;{{ count($apartments) }}&#41;</h1>

    <div class="mx-3 mt-3">
        <a href="{{ route('dashboard.apartments.create') }}" class="btn btn-success">
            Aggiungi
        </a>

        <table class="table table-bordered table-striped table-hover mt-3 text-center">
            <thead>
                <tr>
                    <th class="px-3">Immagine</th>
                    <th class="px-3">Titolo</th>
                    <th class="px-3">Categoria</th>
                    <th class="px-3">Indirizzo</th>
                    <th class="px-3">Disponibilità</th>
                    <th class="px-3">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                <tr>
                    <td class="h-100 align-middle">
                        @if (Str::startsWith($apartment->cover_image, 'https'))
                        <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @else
                        <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @endif
                    </td>
                    <td class="h-100 align-middle">{{ $apartment->title }}</td>
                    <td class="text-capitalize h-100 align-middle">{{ $apartment->category }}</td>
                    <td class="h-100 align-middle">{{ $apartment->full_address }}</td>
                    <td class="h-100 align-middle">
                        @if ($apartment->is_available)
                            <i class="fa-solid fa-check"></i>
                        @else
                            <i class="fa-solid fa-xmark"></i>
                        @endif
                    </td>
                    <td class="h-100">
                        <div class="d-flex flex-wrap">
                            <div class="col-6 p-1">
                                <a href="{{ route('dashboard.apartments.show', $apartment->slug) }}" class="btn btn-info btn-sm w-100">
                                    <i class="fa-solid fa-circle-info"></i> Info
                                </a>
                            </div>
                            <div class="col-6 p-1">
                                <a href="{{ route('dashboard.apartments.edit', $apartment->slug) }}" class="btn btn-warning btn-sm w-100">
                                    <i class="fa-solid fa-pen"></i> Modifica
                                </a>
                            </div>
                            <div class="col-6 p-1">
                                <a href="{{ route('apartments.sponsorships', $apartment->slug) }}" class="btn btn-success btn-sm w-100">
                                    <i class="fa-solid fa-dollar"></i> Promuovi
                                </a>
                            </div>
                            <div class="col-6 p-1">
                                <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $apartment->id }}">
                                    <i class="fa-solid fa-trash"></i> Elimina
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal for Deleting Apartment -->
                <div class="modal fade" id="deleteModal{{ $apartment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $apartment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $apartment->id }}">Conferma eliminazione</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <strong>Questa operazione è irreversibile.</strong><br>
                                Sei sicuro di voler eliminare l'appartamento: "{{ $apartment->title }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <form action="{{ route('dashboard.apartments.destroy', $apartment->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Confermo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
