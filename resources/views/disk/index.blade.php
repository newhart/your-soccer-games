@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des disques</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Liste des disques</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center justify-content-between mx-3" role="alert">
            <div>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center justify-content-between mx-3" role="alert">
            <div>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <form class="d-flex align-items-center search-form" action="{{ route('disk.index') }}" method="get">
                                <input autocomplete="short_description" autofocus value="{{ $search }}"
                                    class="input-search" name="search" placeholder="{{__('search')}}..." type="text">
                                <button type="submit" class="btn btn-primary">{{__('search')}}</button>
                            </form>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                               Ajouter un disque
                            </button>

                            <!-- Modal add new  -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                Ajouter un nouveau disque
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('disk.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="number" class="form-label">Numero de la disque</label>
                                                <input type="text"
                                                    class="form-control @error('number') is-invalid @enderror"
                                                    name="number" value="{{ old('number') }}" required
                                                    autocomplete="number" autofocus id="number">
                                                @error('number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table caption-top">
                                <caption>
                                    {{ $disks->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de la disque</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($disks as $key => $item)
                                        <tr>
                                            <th>
                                                    Disque numero : 
                                            </th>
                                            <td>{{$item->number}}</td>
                                            <td class="d-flex align-items-center">
                                                <button class="btn btn-danger mx-2" type="button"data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $key }}"><i
                                                        class="fas fa-trash-alt"></i></button>

                                                <!-- Modal confirmation delete -->
                                                <div class="modal fade" id="delete{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="delete{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="delete{{ $key }}Label">
                                                                    Supprimer
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('disk.delete', $item) }}"
                                                                class="modal-body">
                                                                @method('DELETE')
                                                                @csrf
                                                                <div class="mb-3 d-flex align-items-center">
                                                                    <label class="form-label mb-0">Vous voullez vraiment
                                                                        supprimer cette disque</label>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Valider</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning mx-2" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modify{{ $key }}"><i
                                                        class="fas fa-edit"></i></button>

                                                <!-- Modal modifications -->
                                                <div class="modal fade" id="modify{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modify{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="modify{{ $key }}Label">Modifier le disque
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="{{ route('disk.update' , $item) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="number" class="form-label">Numero</label>
                                                                    <input type="text"
                                                                        class="form-control @error('number') is-invalid @enderror"
                                                                        name="number" value="{{ $item['number'] ?? old('number') }}" required
                                                                        autocomplete="number" autofocus id="number">
                                                                    @error('number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                                </div>
                                                            </form>
                                                        </div>
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
