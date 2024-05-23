@extends('layouts.app')

@section('content')
<div class="container centered-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="color: #fff; ">Ajouter votre mot de passe</h5>
            <form method="POST" action="{{route('partenaires.update') . '?token=' . $email}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-2">Confrimer</button>
            </form>
        </div>
    </div>
</div>

@endsection