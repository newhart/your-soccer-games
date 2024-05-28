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
                            {{ __('Veuillez entrer vos informations.') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('older.player.store') }}" enctype="multipart/form-data">
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
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</p>

                                <div class="col-md-6">
                                    <input id="name" type="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback text-primary" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Numéro WhatsApp') }}</p>

                                <div class="col-md-6">
                                    <input id="whatsapp" type="number" min="0"
                                        class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp"
                                        required autocomplete="current-whatsapp">

                                    @error('whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Langue parlée') }}</p>

                                <div class="col-md-6">
                                    <input id="langue" type="text"
                                        class="form-control @error('langue') is-invalid @enderror" name="langue" required
                                        autocomplete="current-langue">

                                    @error('langue')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Photo pièce d\'identité') }}</p>

                                <div class="col-md-6">
                                    <input id="photo" type="file"
                                        class="form-control @error('photo') is-invalid @enderror" name="photo" required
                                        autocomplete="current-photo">

                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Valider') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
