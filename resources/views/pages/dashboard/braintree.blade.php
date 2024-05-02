@extends('layouts.app')

@section('content')
    <div class="py-12">
        @csrf
        <div class="container">

            <div id="dropin-container"></div>
            <button id="submit-button" class="btn btn-success ">Purchase</button>
        </div>
    </div>
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: '{{ $token }}',
            selector: '#dropin-container'
        }, function(err, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
                    axios.post("{{ route('token') }}", {
                            nonce: payload.nonce
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(function(response) {
                            console.log('success', payload.nonce);
                        })
                        .catch(function(error) {
                            console.log('error', payload.nonce);
                        });
                });
            });
        });
    </script>
@endsection
