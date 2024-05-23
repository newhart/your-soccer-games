@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestion du prix</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Gestion du prix</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table caption-top">
                                <caption>
                                    {{-- <button class="btn btn-success mx-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#addTypeMatch">
                                        Ajouter un nouveau type du match
                                    </button>

                                    <div class="modal fade" id="addTypeMatch" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTypeMatchLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post" action="{{ route('add.prix') }}" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addTypeMatchLabel">
                                                        Ajouter un nouveau type du match
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="match-complet" class="form-label">Nom du
                                                            type</label>
                                                        <input class="form-control" id="match-complet" type="text"
                                                            name="name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="match-complet" class="form-label">Prix</label>
                                                        <input class="form-control" id="match-complet" type="number"
                                                            name="prix">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> --}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="addPromotion" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPromotionLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addPromotionLabel">Gestion de la
                                                        promotion
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex align-items-center">
                                                        <label class="mb-0" for="si-plus">Si plus de</label>
                                                        <input style="width: 60px;" type="number" class="form-control mx-3"
                                                            id="si-plus">
                                                        <label class="mb-0" for="prix-promotion">videos, le prix est de
                                                        </label>
                                                        <input style="width: 100px;" type="number"
                                                            class="form-control mx-3" id="prix-promotion">
                                                        <label class="mb-0" for="prix-promotion">£
                                                        </label>
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-2">
                                                        <button type="button" class="btn btn-danger mx-2" type="button"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                        <button class="btn btn-warning mx-2" type="button"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Type du match</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_type as $key => $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->prix_match?->prix ? $value->prix_match?->prix : 0 }}€</td>
                                            <td class="d-flex align-items-center">
                                                <button title="Modifier le prix" class="btn btn-success mx-2" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modifier{{ $key }}">
                                                    Modifier
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="modifier{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modifier{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="post" action="{{ route('update.prix', $value->id) }}"
                                                            class="modal-content">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $value->id }}">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Modifier
                                                                    le prix du match
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="match-complet" class="form-label">Type du
                                                                        match
                                                                    </label>
                                                                    <input required class="form-control" id="match-complet"
                                                                        type="text" value="{{ $value->name }}"
                                                                        name="name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="match-complet" class="form-label">Prix
                                                                        match</label>
                                                                    <input required class="form-control"
                                                                        id="match-complet" type="number"
                                                                        value="{{ $value->prix_match?->prix ? $value->prix_match?->prix : 0 }}"
                                                                        name="prix">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
