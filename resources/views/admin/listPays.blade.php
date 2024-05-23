@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des pays</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Liste des pays</li>
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
                            <form class="d-flex align-items-center search-form" action="{{ route('country-item') }}"
                                method="get">
                                <input autocomplete="short_description" autofocus value="{{ $search }}"
                                    class="input-search" name="search" placeholder="Rechercher..." type="text">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </form>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Ajouter un pays
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" action="{{ route('country.store') }}" class="modal-content">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ajouter un
                                                nouveau pays
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name_pays" class="form-label">Nom du pays</label>
                                                <input required type="text" class="form-control" name="name"
                                                    id="name_pays">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nationality" class="form-label">Nationalité</label>
                                                <input required type="text" class="form-control" name="nationality"
                                                    id="nationality">
                                            </div>
                                            <div class="mb-3">
                                                <label for="logitude" class="form-label">Logitude</label>
                                                <input required type="text" class="form-control" name="logitude"
                                                    id="logitude">
                                            </div>
                                            <div class="mb-3">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input required type="text" class="form-control" name="latitude"
                                                    id="latitude">
                                            </div>
                                            <div class="mb-3">
                                                <label for="timezone" class="form-label">Timezone</label>
                                                <input required type="text" class="form-control" name="timezone"
                                                    id="timezone">
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Type du
                                                    match</label>
                                                <select class="form-control" name="continent_id">
                                                    @foreach ($continents as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
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
                                    {{ $countries->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Nom du pays</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $key => $country)
                                        <tr>
                                            <th scope="row"><img class="img-match"
                                                    src="{{ asset('img/pays/default.webp') }}" alt="real_barc">
                                            </th>
                                            <td>{{ $country->name }}</td>
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
                                                                    Supprimer ce pays
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('country.destroy', $country['id']) }}"
                                                                class="modal-body">
                                                                @csrf
                                                                <div class="mb-3 d-flex align-items-center">
                                                                    <label class="form-label mb-0">Vous voullez vraiment
                                                                        supprimer ce pays</label>
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
                                                            action="{{ route('country.update', $country['id']) }}"
                                                            class="modal-content">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Modifier ce pays
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="name_pays" class="form-label">Nom du
                                                                        pays</label>
                                                                    <input required type="text" class="form-control"
                                                                        name="name" value="{{ $country['name'] }}"
                                                                        id="name_pays">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="nationality"
                                                                        class="form-label">Nationalité</label>
                                                                    <input required type="text" class="form-control"
                                                                        name="nationality"
                                                                        value="{{ $country['nationality'] }}"
                                                                        id="nationality">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="logitude"
                                                                        class="form-label">Logitude</label>
                                                                    <input required type="text" class="form-control"
                                                                        name="logitude"
                                                                        value="{{ $country['logitude'] }}"
                                                                        id="logitude">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="latitude"
                                                                        class="form-label">Latitude</label>
                                                                    <input required type="text" class="form-control"
                                                                        name="latitude"
                                                                        value="{{ $country['latitude'] }}"
                                                                        id="latitude">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="timezone"
                                                                        class="form-label">Timezone</label>
                                                                    <input required type="text" class="form-control"
                                                                        name="timezone"
                                                                        value="{{ $country['timezone'] }}"
                                                                        id="timezone">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="price" class="form-label">Type du
                                                                        match</label>
                                                                    <select class="form-control" name="continent_id">
                                                                        @foreach ($continents as $value)
                                                                            <option
                                                                                {{ $value->id === $country['continent_id'] ? 'selected' : '' }}
                                                                                value="{{ $value->id }}">
                                                                                {{ $value->name }}</option>
                                                                        @endforeach
                                                                    </select>
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
    <script defer>
        const form_country = document.querySelector('#form-delete')
        form_country.addEventListener('submit', function(event) {
            const confirmation = window.confirm('Vous voullez le supprimer ?')
            if (!confirmation) {
                event.preventDefault()
                return
            }
        })
    </script>
    <!-- /.content -->
@endsection
