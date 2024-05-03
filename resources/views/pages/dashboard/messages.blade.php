@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1 class="mb-4 fw-bold">Messaggi ({{ $totalMessages }})</h1>
        <div id="accordion">
            @foreach ($apartments as $apartment)
                <div class="card mb-4">
                    <div class="card-header" id="heading{{ $apartment->id }}">
                        <h2 class="mb-0">
                            <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $apartment->id }}" aria-expanded="true" aria-controls="collapse{{ $apartment->id }}">
                                @if (Str::startsWith($apartment->cover_image, 'https'))
                                    <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}" class="img-thumbnail me-2" style="width: 100px; height: auto;">
                                @else
                                    <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}" class="img-thumbnail me-2" style="width: 100px; height: auto;">
                                @endif
                                <strong>{{ $apartment->title }} {{ $apartment->messages->isEmpty() ? '' : ($apartment->messages->count() == 1 ? '- 1 Messaggio' : '- ' . $apartment->messages->count() . ' Messaggi') }}</strong>
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $apartment->id }}" class="collapse" aria-labelledby="heading{{ $apartment->id }}" data-bs-parent="#accordion">
                        <div class="card-body">
                            @if ($apartment->messages->isEmpty())
                                <p class="text-muted">Nessun messaggio per questo appartamento.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($apartment->messages as $message)
                                        <li class="list-group-item">
                                            <p>{{ $message->message }}</p>
                                            <footer class="blockquote-footer">
                                                Inviato da <cite>{{ $message->name }}</cite> il <span class="datetime">{{ $message->created_at->toIso8601String() }}</span> |
                                                <a href="mailto:{{ $message->email }}?subject=Risposta al tuo messaggio per {{ $apartment->title }}&body=Ciao {{ $message->name }},%0D%0A%0D%0AGrazie per il tuo interesse.">
                                                    Rispondi
                                                </a>
                                            </footer>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
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
                // Formatta la data e l'ora senza secondi
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
