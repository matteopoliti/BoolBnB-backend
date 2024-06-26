<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Informazioni Personali') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Aggiorna le informazioni del profilo e l'indirizzo email del tuo account.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2">
            <label for="name">{{ __('Nome') }}</label>
            <input class="form-control" type="text" name="name" id="name" autocomplete="name"
                value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    @dump($errors->first('name'))
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="surname">{{ __('Cognome') }}</label>
            <input class="form-control" type="text" name="surname" id="surname" autocomplete="surname"
                value="{{ old('surname', $user->surname) }}" required autofocus>
            @error('surname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('surname') }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email">
                {{ __('Email') }}
            </label>

            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @error('email')
                <span class="alert alert-danger mt-2" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-muted">
                        {{ __('Il tuo indirizzo email non è verificato.') }}

                        <button form="send-verification" class="btn btn-outline-dark">
                            {{ __("Fare clic qui per inviare nuovamente l'e-mail di verifica.") }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('Un nuovo link di verifica è stato inviato al tuo indirizzo email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-2">
            <label for="date_of_birth">{{ __('Data di nascita') }}</label>
            <input class="form-control" type="date" name="date_of_birth" id="date_of_birth"
                autocomplete="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" required
                autofocus min="{{ date('Y-m-d', strtotime('-100 years')) }}"
                max="{{ date('Y-m-d', strtotime('-18 years')) }}">
            @error('date_of_birth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-outline-success" type="submit">{{ __('Salva') }}</button>

            @if (session('status') === 'profile-updated')
                <script>
                    const show = true;
                    setTimeout(() => show = false, 2000)
                    const el = document.getElementById('profile-status')
                    if (show) {
                        el.style.display = 'block';
                    }
                </script>
                <p id='profile-status' class="fs-5 text-muted">{{ __('Salvato.') }}</p>
            @endif
        </div>
    </form>
</section>
