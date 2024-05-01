<h1>Ciao Host</h1>
<h4>Hai ricevuto un nuovo messaggio:</h4>
<p>
    Nome: {{ $lead->name }} <br>
    Email: {{ $lead->email }} <br>
    Messaggio: <br>
    {{ $lead->message }}
</p>
<p>

    {{-- @php
        dd($message);
    @endphp --}}
</p>
