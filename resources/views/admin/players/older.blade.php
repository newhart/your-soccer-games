@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des anciens joueurs</h1>
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
                            <form class="d-flex align-items-center search-form" action="{{ route('players') }}"
                                method="get">
                                <input autocomplete="short_description" autofocus class="input-search" name="search"
                                    placeholder="Rechercher..." type="text">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </form>
                            <!-- Button trigger modal -->
                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Ajouter un nouveau joueur
                            </button> --}}

                        </div>
                        <div class="card-body">
                            <table class="table caption-top">
                                <caption>
                                    {{ $players->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Numéro whatsapp</th>
                                        <th scope="col">Langue</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($players as $key => $player)
                                        <tr>
                                            <th scope="row"><img class="img-match" src="{{ $player->imageUrl() }}"
                                                    alt="real_barc">
                                            </th>
                                            <td>{{ $player->email }}</td>
                                            <td>{{ $player->name }}</td>
                                            <td>{{ $player->whatsapp }}</td>
                                            <td>{{ $player->langue }}</td>
                                            <td>
                                                <span
                                                    class="@if ($player->status == 'En attente') badge badge-primary @elseif($player->status == 'Supprimer') badge badge-danger @else  badge badge-success @endif">{{ $player->status }}</span>
                                            </td>
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
                                                                    Supprimer ce joueur
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('players.older.delete', $player['id']) }}"
                                                                class="modal-body">
                                                                @csrf
                                                                <div class="mb-3 d-flex align-items-center">
                                                                    <label class="form-label mb-0">Vous voullez vraiment
                                                                        supprimer ce joueur</label>
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

                                                <form action="{{ route('players.older.validate', $player->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <button title="Confrimer son indentification"
                                                        class="btn btn-primary mx-2" type="submit"><i
                                                            class="fas fa-check-circle"></i></button>
                                                </form>



                                                <!-- Modal -->
                                                <div class="modal fade" id="modify{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modify{{ $key }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="post" enctype="multipart/form-data"
                                                            action="{{ route('players.update', $player['id']) }}"
                                                            class="modal-content">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="modify{{ $key }}Label">
                                                                    Modifier un joueur
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="photoModify"
                                                                        class="form-label">Photo</label>
                                                                    <input class="form-control" id="photoModify"
                                                                        type="file" name="image" accept="images/*">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nom</label>
                                                                    <input required type="text" name="name"
                                                                        value="{{ $player['first_name'] }}"
                                                                        class="form-control" id="name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="last_name"
                                                                        class="form-label">Prénom</label>
                                                                    <input required type="text" name="last_name"
                                                                        value="{{ $player['last_name'] }}"
                                                                        class="form-control" id="last_name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="full_name" class="form-label">Nom
                                                                        complet</label>
                                                                    <input type="text" name="full_name"
                                                                        value="{{ $player['full_name'] }}"
                                                                        class="form-control" id="full_name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="birth_date" class="form-label">Date de
                                                                        naissance</label>
                                                                    <input required type="date" name="birth_date"
                                                                        value="{{ $player['birth_date'] }}"
                                                                        class="form-control" id="birth_date">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="birth_date"
                                                                        class="form-label">Genre</label>
                                                                    <select required class="form-control" name="genre">
                                                                        <option
                                                                            {{ !$player['is_woman'] ? 'selected' : '' }}
                                                                            value="Homme">Homme</option>
                                                                        <option {{ $player['is_woman'] ? 'selected' : '' }}
                                                                            value="Femme">Femme</option>
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="mb-3">
                                                                    <label for="birth_date"
                                                                        class="form-label">Pays</label>
                                                                    <select required class="form-control"
                                                                        name="country_id">
                                                                        @foreach ($country as $value)
                                                                            <option
                                                                                {{ $player['country_id'] === $value->id ? 'selected' : '' }}
                                                                                value="{{ $value->id }}">
                                                                                {{ $value->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> --}}
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
                                                <button title="Voir details" class="btn btn-success mx-2" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#DetailsPlayer-{{ $key }}"><i
                                                        class="fas fa-eye"></i></button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="DetailsPlayer-{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="DetailsPlayer-{{ $key }}-Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="DetailsPlayer-{{ $key }}-Label">
                                                                    {{ $player->email }}
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div style="max-width: 150px;
                                                                margin: auto;"
                                                                    class="image-match">
                                                                    <img src="{{ $player->imageUrl() ? $player->imageUrl() : asset('img/players/default.jpg') }}"
                                                                        alt="">
                                                                </div>
                                                                <hr class="mt-3">
                                                                <div class="details my-3">
                                                                    <div
                                                                        class="d-flex align-center justify-content-between">
                                                                        <p class="font-weight-bold">
                                                                            Email
                                                                        </p>
                                                                        <p>
                                                                            {{ $player->email }}
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="d-flex align-center justify-content-between">
                                                                        <p class="font-weight-bold">
                                                                            Numéro whatsapp
                                                                        </p>
                                                                        <p>
                                                                            {{ $player->whatsapp }}
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="d-flex align-center justify-content-between">
                                                                        <p class="font-weight-bold">
                                                                            Langues
                                                                        </p>
                                                                        <p>
                                                                            {{ $player->langue }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Fermer</button>

                                                                    <form
                                                                        action="{{ route('older.player.plus_info', ['id' => $player->id]) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Plus
                                                                            d'information</button>
                                                                    </form>

                                                                </div>
                                                            </div>
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
    <script defer>
        document.querySelector('#delete-players')
            .addEventListener('submit', function(event) {
                if (!window.confirm('Vous voullez le supprimer ?')) {
                    event.preventDefault()
                }
            })
    </script>
    <!-- /.content -->
@endsection
