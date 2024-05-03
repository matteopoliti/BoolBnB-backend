{{-- resources/views/pages/dashboard/sponsors.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1 class="mb-4 fw-bold">Lista Sponsorizzazioni</h1>
    <div class="accordion" id="sponsorshipAccordion">
        @foreach ($totalSponsorhips as $index => $sponsorship)
            <div class="card mb-2">
                <div class="card-header" id="heading{{ $sponsorship->id }}">
                    <h5 class="mb-0">
                        <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $sponsorship->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $sponsorship->id }}">
                            Sponsorizzazione #{{ $sponsorship->id }} - <span class="datetime">{{ $sponsorship->created_at->toIso8601String() }}</span>
                        </button>
                    </h5>
                </div>

                <div id="collapse{{ $sponsorship->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $sponsorship->id }}" data-bs-parent="#sponsorshipAccordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $sponsorship->apartment->cover_image }}" alt="Immagine Appartamento" class="img-fluid rounded mb-3">
                                <h5>Dettagli Appartamento:</h5>
                                <p><strong>Titolo:</strong> <a href="{{ route('dashboard.apartments.show', $sponsorship->apartment->slug) }}">{{ $sponsorship->apartment->title }}</p></a>
                            </div>
                            <div class="col-md-6">
                                <h5>Dettagli Sponsorizzazione:</h5>
                                <p><strong>Tipologia:</strong> {{ $sponsorship->sponsorship->name }}</p>
                                <p><strong>Durata:</strong> {{ $sponsorship->sponsorship->duration }} ore</p>
                                <p><strong>Costo:</strong> {{ $sponsorship->sponsorship->amount }} €</p>
                                <p><strong>Data Transazione:</strong> <span class="datetime">{{ $sponsorship->created_at->toIso8601String() }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
