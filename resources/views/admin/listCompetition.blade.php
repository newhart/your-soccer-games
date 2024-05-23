@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des compétitions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Liste des compétitions</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
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
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <form class="d-flex align-items-center search-form" action="{{ route('competition.index') }}"
                                method="get">
                                <input autocomplete="short_description" autofocus value="{{ $search }}"
                                    class="input-search" name="search" placeholder="Rechercher..." type="text">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </form>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Ajouter une nouvelle compétition
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" action="{{ route('competition.store') }}" class="modal-content">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter une
                                                nouvelle compétition
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="titleNewMatch" class="form-label">Nom de la compétition</label>
                                                <input required type="text" name="name" class="form-control"
                                                    id="titleNewMatch">
                                            </div>
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
                        <div class="card-body">
                            <table class="table caption-top">
                                <caption>
                                    {{ $competitions->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Nom de la compétiton</th>
                                        {{-- <th scope="col">Pays de la compétiton</th> --}}
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($competitions as $key => $competition)
                                        <tr>
                                            <td>{{ $competition->name }}</td>
                                            {{-- <td>{{ $competition->country?->name }}</td> --}}
                                            <td class="d-flex align-items-center">
                                                <button class="btn btn-danger mx-2" type="button"data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $key }}"><i
                                                        class="fas fa-trash-alt"></i></button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="delete{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="delete{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="delete{{ $key }}Label">
                                                                    Supprimer ce compétition
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('competition.destroy', $competition['id']) }}"
                                                                class="modal-body">
                                                                @csrf
                                                                <div class="mb-3 d-flex align-items-center">
                                                                    <label class="form-label mb-0">Vous voullez vraiment
                                                                        supprimer ce compétition</label>
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

                                                <!-- Modal -->
                                                <div class="modal fade" id="modify{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modify{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="post"
                                                            action="{{ route('competition.update', $competition['id']) }}"
                                                            class="modal-content">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Modifier ce compétition
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="titleNewMatch" class="form-label">Nom de
                                                                        la
                                                                        compétition</label>
                                                                    <input required value="{{ $competition->name }}"
                                                                        type="text" name="name"
                                                                        class="form-control">
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
                                                {{-- <button class="btn btn-success mx-2" type="button"><i
                                                        class="fas fa-eye"></i></button> --}}
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
    <script defer>
        document.querySelector('#delete-competition')
            .addEventListener('submit', function(event) {
                if (!window.confirm('Vous voullez le supprimer ? ')) {
                    event.preventDefault()
                }
            })
    </script>
    <!-- /.content -->
@endsection
