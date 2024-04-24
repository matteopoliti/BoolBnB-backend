@extends('layouts.app')

@section('content')
{{-- @dd($apartments) --}}
    <div class="container-fluid mt-3">
        <h1>Appartamenti - {{ count($apartments) }}</h1>
    
        <div class="mx-3 mt-3">
            <a href="{{ route('dashboard.apartments.create') }}" class="btn btn-primary mx-auto">
                <i class="bi bi-pencil"></i> Create
            </a>
    
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        @foreach ($table_headers_values as $table_header)
                            <th>{{ $table_header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.apartments.show', $apartment->slug) }}">{{ $apartment->title }}</a>
                            </td>
                            <td>{{ $apartment->description }}</td>
                            <td>{{ $apartment->created_at }}</td>
                            <td>{{ $apartment->updated_at }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <a class="btn btn-warning" href="{{ route('dashboard.apartments.edit', $apartment->slug) }}">
                                            <i class="fa-solid fa-pen"></i> Modifica
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $apartment->id }}">
                                            <i class="fa-solid fa-trash"></i> Elimina
                                        </button>
                                    </div>
                                      <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $apartment->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Conferma eliminazione</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Questa operazione è irreversibile.</strong><br>Sei sicuro di voler eliminare l'appartamento: "{{ $apartment->title }}"
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                            <form action="{{ route('dashboard.apartments.destroy', $apartment->slug) }}" method="POST">
    
                                            @csrf
            
                                            @method('DELETE')
        
                                            <input class="btn btn-danger" type="submit" value="Confermo">
                                        </form>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
