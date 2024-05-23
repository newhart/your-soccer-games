@extends('layouts.app')
<style>
    .login {
        min-height: calc(100vh - 39px) !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center login">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-primary text-center">
                            {{ __('Espace réservé au administrateur') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Address email') }}</p>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback text-primary" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</p>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <p class="form-check-label">
                                            {{ __('Je me souviens') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Se connecter') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="text-primary mt-2 text-end" href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
