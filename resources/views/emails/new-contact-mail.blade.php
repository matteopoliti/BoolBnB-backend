@extends('layouts.app')

@section('content')
    <h1>Hai ricevuto un nuovo messaggio:</h1>

    <p>
        Nome: {{ $message->name }} <br>
        Email: {{ $message->email }} <br>
        Message: <br>
        {{ $message->message }}
    </p>
@endsection
