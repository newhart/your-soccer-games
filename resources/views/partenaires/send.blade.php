@extends('layouts.app')

@section('content')
<div class="container centered-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ajouter le Lien de la video</h5>
            <form method="POST" action="{{route('commandes.send_product', ['id' => $id]) . '?token=' . $token}}">
                @csrf
                <div class="form-group">
                    <label for="lien">Lien de la video</label>
                    <input type="lien" name="lien" class="form-control @error('lien') is-invalid @enderror" id="link" placeholder="https://exemple.com">
                    @error('lien')
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