@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mx-3 fw-bold">Appartamenti eliminati &#40;{{ count($trashedApartments) }}&#41;</h1>

    <div class="mx-3 mt-3">
        <table class="table table-bordered table-striped table-hover mt-3 text-center">
            <thead>
                <tr>
                    <th class="px-3">Immagine</th>
                    <th class="px-3">Titolo</th>
                    <th class="px-3">Categoria</th>
                    <th class="px-3">Indirizzo</th>
                    <th class="px-3">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trashedApartments as $apartment)
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
                    <td class="h-100">
                        <div class="d-flex flex-wrap">
                            <div class="col-6 p-1">
                                <form action="{{ route('dashboard.apartments.restore', $apartment->slug) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm w-100"><i class="fa-solid fa-wrench"></i> Ripristina</button>
                                </form>
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
                                Sei sicuro di voler eliminare l'appartamento:<br> "<strong>{{ $apartment->title }}</strong>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <form action="{{ route('dashboard.apartments.forceDelete', $apartment->slug) }}" method="POST">
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
