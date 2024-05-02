@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Riepilogo Transazione</div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <p class="mb-4">Grazie per il pagamento! Di seguito è riportato un riepilogo della tua transazione:</p>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Importo: </strong>{{ Session::get('payment_amount') }} €</li>
                        <li class="list-group-item"><strong>Data:</strong> <span class="datetime">{{ now()->format('Y-m-d H:i:s') }}</span></li>
                    </ul>
                    <p>Per eventuali domande, contatta il nostro team di supporto.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aggiunto script per formattare le date e le ore senza secondi -->
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
