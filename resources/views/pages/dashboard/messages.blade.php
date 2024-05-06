@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1 class="mb-4 fw-bold">Messaggi ({{ $totalMessages }})</h1>
        <div id="accordion">
            @foreach ($apartments as $apartment)
                <div class="card mb-4 message-card">
                    <div class="card-header message-card-header m-0 p-0" id="heading{{ $apartment->id }}">
                        <h2 class="mb-0">
                            <button class="btn w-100 text-start m-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $apartment->id }}" aria-expanded="true" aria-controls="collapse{{ $apartment->id }}">
                                @if (Str::startsWith($apartment->cover_image, 'https'))
                                    <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}" class="img-thumbnail me-2 col-2" style="width: 150px; height:auto; max-height: 100px; object-fit:cover;">
                                @else
                                    <img src="{{ asset('storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}" class="img-thumbnail me-2" style="width: 100px; height: auto;">
                                @endif
                                <strong>{{ $apartment->title }} {{ $apartment->messages->isEmpty() ? '' : ($apartment->messages->count() == 1 ? '- 1 Messaggio' : '- ' . $apartment->messages->count() . ' Messaggi') }}</strong>
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $apartment->id }}" class="collapse" aria-labelledby="heading{{ $apartment->id }}" data-bs-parent="#accordion">
                        <div class="card-body message-card-body">
                            @if ($apartment->messages->isEmpty())
                                <p class="text-muted">Nessun messaggio per questo appartamento.</p>
                            @else
                                <ul class="list-group list-group-flush gap-3">
                                    @foreach ($apartment->messages as $message)
                                        <li class="list-group-item ">
                                            <p class="mb-4">{{ $message->message }}</p>
                                            <footer class="blockquote-footer mb-1">
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

            const accordion = document.getElementById('accordion');

            // Aggiungi event listeners per gli eventi di show e hide del collapse di Bootstrap
            accordion.addEventListener('show.bs.collapse', function(event) {
                // Trova il card-header associato al collapse aperto
                const cardHeader = event.target.previousElementSibling;
                cardHeader.classList.add('active');
            });

            accordion.addEventListener('hide.bs.collapse', function(event) {
                // Trova il card-header associato al collapse che si sta chiudendo
                const cardHeader = event.target.previousElementSibling;
                cardHeader.classList.remove('active');
            });

            // Controlla se qualche collapse è già aperto al caricamento e aggiungi la classe active
            document.querySelectorAll('.collapse.show').forEach(function(collapseElement) {
                const cardHeader = collapseElement.previousElementSibling;
                cardHeader.classList.add('active');
            });
        });
    </script>
@endsection
