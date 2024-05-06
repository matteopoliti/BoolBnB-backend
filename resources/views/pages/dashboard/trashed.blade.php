@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mx-3 fw-bold">Appartamenti eliminati &#40;{{ count($trashedApartments) }}&#41;</h1>
    <p class="text-muted mx-3">
        Tutti gli appartamenti elencati qui verranno eliminati definitivamente <strong>30 giorni</strong> dopo la loro data di inserimento nel cestino.
    </p>

    <div class="mx-3 mt-3">
        <table class="table table-striped table-hover mt-3 text-center">
            <thead>
                <tr >
                    <th class="px-3 d-none d-md-table-cell">Immagine</th>
                    <th class="px-3">Titolo</th>
                    <th class="px-3 d-none d-xl-table-cell">Categoria</th>
                    <th class="px-3 d-none d-xxl-table-cell">Indirizzo</th>
                    <th class="px-3 d-none d-lg-table-cell">Data eliminazione</th>
                    <th class="px-3 ">Data scadenza</th>
                    <th class="px-3">Azioni</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($trashedApartments as $apartment)
                <tr>
                    <td class="h-100 align-middle d-none d-md-table-cell">
                        @if (Str::startsWith($apartment->cover_image, 'https'))
                        <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @else
                        <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @endif
                    </td>
                    <td class="h-100 align-middle">{{ $apartment->title }}</td>
                    <td class="text-capitalize h-100 align-middle d-none d-xl-table-cell">{{ $apartment->category }}</td>
                    <td class="h-100 align-middle d-none d-xxl-table-cell">{{ $apartment->full_address }}</td>
                    <td class="h-100 align-middle datetime d-none d-lg-table-cell">{{ $apartment->deleted_at->toIso8601String() }}</td>
                    <td class="h-100 align-middle expiration-date ">{{ $apartment->deleted_at->toIso8601String() }}</td>
                    <td class="h-100">
                        <div class="d-md-block" style="height: 100%">
                            <div class="col p-1" >
                                <form action="{{ route('dashboard.apartments.restore', $apartment->slug) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-warning btn-sm text-center rounded" style="height: 50px; width:100%;">
                                        <i class="fa-solid fa-wrench"></i> 
                                        <br>
                                        <span class="d-none d-lg-inline ">
                                        Ripristina
                                        </span>
                                    </button>
                                </form>
                            </div>
                            <div class="col p-1">
                                <button type="button" class="btn btn-outline-danger btn-sm text-center rounded" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $apartment->id }}" style="height: 50px; width:100%;">
                                    <i class="fa-solid fa-trash"></i> 
                                    <br>
                                    <span class="d-none d-lg-inline">
                                        Elimina
                                    </span>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deletionDates = document.querySelectorAll('.datetime'); // Seleziona le date di eliminazione
        const expirationDates = document.querySelectorAll('.expiration-date'); // Seleziona le date di scadenza
    
        // Calcola e formatta le date di eliminazione e applica le classi in base alla data di scadenza
        deletionDates.forEach(function(dateElement, index) {
            const deletionDate = new Date(dateElement.textContent);
            const expirationDate = new Date(deletionDate.getTime() + 30 * 24 * 60 * 60 * 1000); // Aggiunge 30 giorni alla data di eliminazione
    
            // Formatta la data di eliminazione
            dateElement.textContent = deletionDate.toLocaleString('it-IT', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
    
            // Mostra la data di scadenza nel campo corrispondente
            expirationDates[index].textContent = expirationDate.toLocaleString('it-IT', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
    
            const currentDate = new Date();
            const timeDiff = expirationDate - currentDate; // Calcola il tempo rimanente fino alla scadenza
            const daysLeft = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Conversione in giorni
    
            // Rimozione di classi precedenti per evitare conflitti
            dateElement.classList.remove('text-success', 'text-warning', 'text-danger');
            expirationDates[index].classList.remove('text-success', 'text-warning', 'text-danger');
    
            // Applicazione delle classi in base ai giorni rimasti alla scadenza
            if (daysLeft < 5) {
                expirationDates[index].classList.add('text-danger');
            } else if (daysLeft < 10) {
                expirationDates[index].classList.add('text-warning');
            } else {
                expirationDates[index].classList.add('text-success');
            }
        });
    });
</script>
@endsection
