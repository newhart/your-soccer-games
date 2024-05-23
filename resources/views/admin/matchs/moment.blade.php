@extends('layouts.admin')

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var switch_video = document.getElementById('type_video');
            var form_switch_video = document.getElementById('form_type_video');
            switch_video.addEventListener('change', function() {
                form_switch_video.submit();
            });
        });
    </script>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des matchs du moment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Liste des matchs du moment</li>
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
                            <form class="d-flex align-items-center search-form" action="{{ route('home') }}" method="get">
                                <input autocomplete="short_description" autofocus value="{{ $search }}"
                                    class="input-search mr-4" name="search" placeholder="EquipeA vs EquipeB"
                                    type="text">
                                <input autocomplete="short_description" autofocus value="{{ $date }}"
                                    class="input-search" name="date" placeholder="{{ __('search') }}..." type="date">
                                <button type="submit" class="btn btn-primary">{{ __('search') }}</button>
                            </form>

                            <form action="{{ route('moment.index') }}" method="GET" id="form_type_video">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        @if ($moment_type->video === 'on') checked @endif role="switch" name="type_video"
                                        id="type_video">
                                    <label class="form-check-label" for="type_video">De type vidéo ? </label>
                                </div>
                            </form>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Ajouter
                            </button>

                            <!-- Modal create -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                Ajouter
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        @if ($moment_type->video === 'on')
                                            <form method="POST" action="{{ route('create.video') }}"
                                                enctype="multipart/form-data" class="modal-body">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="titleVideo" class="form-label">Tire de la video</label>
                                                    <input type="text"
                                                        class="form-control @error('title_video') is-invalid @enderror"
                                                        name="title_video" value="{{ old('title_video') }}" required
                                                        autocomplete="title_video" autofocus id="titleVideo">
                                                    @error('title_video')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="url_video" class="form-label">Url de la video</label>
                                                    <input type="text"
                                                        class="form-control @error('url_video') is-invalid @enderror"
                                                        name="url_video" value="{{ old('url_video') }}" required
                                                        autocomplete="url_video" autofocus id="url_video">
                                                    @error('url_video')
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
                                        @else
                                            <form method="POST" action="{{ route('product.store') }}"
                                                enctype="multipart/form-data" class="modal-body">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Photo</label>
                                                    <input class="form-control" id="image" name="image"
                                                        type="file" required autocomplete="image"
                                                        accept="image/png, image/gif, image/jpeg, image/*" autofocus>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="titleNewMatch" class="form-label">Pétite
                                                        description</label>
                                                    <input type="text"
                                                        class="form-control @error('short_description') is-invalid @enderror"
                                                        name="short_description" value="{{ old('short_description') }}"
                                                        required autocomplete="short_description" autofocus
                                                        id="titleNewMatch">
                                                    @error('short_description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="genre" class="form-label">Categorie</label>
                                                    <select required id="genre" class="form-control" name="genre">
                                                        <option value="Homme">
                                                            Masculin</option>
                                                        <option value="Femme">Feminine
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Type du
                                                        match</label>
                                                    <div class="mt-3 d-flex align-items-center">
                                                        <input checked class="w-fit-content"
                                                            name="possibility_match_complet" type="checkbox">
                                                        <label class="form-label mx-2 mb-0">Match complet</label>
                                                    </div>
                                                    <div class="mt-3 d-flex align-items-center">
                                                        <input checked class="w-fit-content"
                                                            name="possibility_hight_light" type="checkbox">
                                                        <label class="form-label mx-2 mb-0">Hight
                                                            light</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="saison" class="form-label">Saison</label>
                                                    <input type="text"
                                                        class="form-control @error('saison') is-invalid @enderror"
                                                        name="saison" value="{{ old('saison') }}" required
                                                        autocomplete="saison" autofocus id="saison">
                                                    @error('saison')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="n_disque" class="form-label">Numéro de la disque</label>
                                                    <input type="number"
                                                        class="form-control @error('n_disque') is-invalid @enderror"
                                                        name="n_disque" value="{{ old('n_disque') }}" required
                                                        autocomplete="n_disque" autofocus id="n_disque">
                                                    @error('n_disque')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="residence" class="form-label">Residence</label>
                                                    <input type="text"
                                                        class="form-control @error('residence') is-invalid @enderror"
                                                        name="residence" value="{{ old('residence') }}" required
                                                        autocomplete="residence" autofocus id="residence">
                                                    @error('residence')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="visitor" class="form-label">Visiteur</label>
                                                    <input type="text"
                                                        class="form-control @error('visitor') is-invalid @enderror"
                                                        name="visitor" value="{{ old('visitor') }}" required
                                                        autocomplete="visitor" autofocus id="visitor">
                                                    @error('visitor')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date_match" class="form-label">Date du match</label>
                                                    <input type="date"
                                                        class="form-control @error('date_match') is-invalid @enderror"
                                                        name="date_match" value="{{ old('date_match') }}" required
                                                        autocomplete="date_match" autofocus id="date_match">
                                                    @error('date_match')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="journey" class="form-label">Journée</label>
                                                    <input type="text"
                                                        class="form-control @error('journey') is-invalid @enderror"
                                                        name="journey" value="{{ old('journey') }}" required
                                                        autocomplete="journey" autofocus id="journey">
                                                    @error('journey')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="result" class="form-label">Résultat du match</label>
                                                    <input type="text"
                                                        class="form-control @error('result') is-invalid @enderror"
                                                        name="result" value="{{ old('result') }}" required
                                                        autocomplete="result" autofocus id="result">
                                                    @error('result')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description du
                                                        match</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                                        value="{{ old('description') }}" autocomplete="description" autofocus id="description"></textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 d-flex align-items-center">
                                                    <input class="w-fit-content" name="is_right_now" id="is_right_now"
                                                        type="checkbox">
                                                    <label class="form-label mx-2 mb-0">Match en ce moment</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        @endif


                                    </div>
                                </div>
                            </div>
                            {{-- end Modal create --}}
                        </div>
                        @if ($moment_type->video === 'on')
                            @include('admin.matchs.video')
                        @else
                            <div class="card-body">
                                <div class="table-wrapper">
                                    <table class="table caption-top responsive-table">
                                        <caption>
                                            {{ $all_product->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                        </caption>
                                        <thead>
                                            <tr>
                                                <th scope="col">Photo</th>
                                                <th scope="col">Nom du match</th>
                                                <th scope="col">Type du match</th>
                                                <th scope="col">Match en ce moments</th>
                                                <th scope="col">Date du match</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($all_product as $key => $item)
                                                <tr>
                                                    <th scope="row"><img class="img-match" src="{{ $item->image }}"
                                                            alt="real_barc">
                                                    </th>
                                                    <td>{{ $item->residence }} vs {{ $item->visitor }}</td>
                                                    <td>
                                                        @if ($item->possibility_match_complet)
                                                            Match complet
                                                        @endif
                                                        @if ($item->possibility_hight_light && $item->possibility_match_complet)
                                                            <br>Et<br>
                                                        @endif
                                                        @if ($item->possibility_hight_light)
                                                            Hight light
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->is_right_now ? 'Oui' : 'Non' }}
                                                    </td>
                                                    <td>
                                                        {{ $item->date_match }}
                                                    </td>
                                                    <td class="d-flex align-items-center">
                                                        <button class="btn btn-danger mx-2"
                                                            type="button"data-bs-toggle="modal"
                                                            data-bs-target="#delete{{ $key }}"><i
                                                                class="fas fa-trash-alt"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="delete{{ $key }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="delete{{ $key }}Label"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="delete{{ $key }}Label">
                                                                            Supprimer ce match
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('product.destroy', $item['id']) }}"
                                                                        class="modal-body">
                                                                        @csrf
                                                                        <div class="mb-3 d-flex align-items-center">
                                                                            <label class="form-label mb-0">Vous voullez
                                                                                vraiment
                                                                                supprimer ce match</label>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Valider</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-warning mx-2" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modify{{ $key }}"><i
                                                                class="fas fa-edit"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modify{{ $key }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="modify{{ $key }}Label"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="modify{{ $key }}Label">Modifier
                                                                            le
                                                                            match
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('product.update', $item['id']) }}"
                                                                        enctype="multipart/form-data" class="modal-body">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="image"
                                                                                class="form-label">Photo</label>
                                                                            <input class="form-control" id="image"
                                                                                name="image" type="file"
                                                                                autocomplete="image"
                                                                                accept="image/png, image/gif, image/jpeg, image/*"
                                                                                autofocus>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="titleNewMatch"
                                                                                class="form-label">Pétite
                                                                                description</label>
                                                                            <input type="text"
                                                                                class="form-control @error('short_description') is-invalid @enderror"
                                                                                name="short_description"
                                                                                value="{{ $item['short_description'] }}"
                                                                                required autocomplete="short_description"
                                                                                autofocus id="titleNewMatch">
                                                                            @error('short_description')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="genre"
                                                                                class="form-label">Categorie</label>
                                                                            <select value="{{ $item['genre'] }}" required
                                                                                id="genre" class="form-control"
                                                                                name="genre">
                                                                                <option value="Homme">
                                                                                    Masculin</option>
                                                                                <option value="Femme">Feminine
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="price" class="form-label">Type
                                                                                du
                                                                                match</label>
                                                                            <div class="mt-3 d-flex align-items-center">
                                                                                <input
                                                                                    {{ $item['possibility_match_complet'] ? 'checked' : '' }}
                                                                                    class="w-fit-content"
                                                                                    name="possibility_match_complet"
                                                                                    type="checkbox">
                                                                                <label class="form-label mx-2 mb-0">Match
                                                                                    complet</label>
                                                                            </div>
                                                                            <div class="mt-3 d-flex align-items-center">
                                                                                <input
                                                                                    {{ $item['possibility_hight_light'] ? 'checked' : '' }}
                                                                                    class="w-fit-content"
                                                                                    name="possibility_hight_light"
                                                                                    type="checkbox">
                                                                                <label class="form-label mx-2 mb-0">Hight
                                                                                    light</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="saison"
                                                                                class="form-label">Saison</label>
                                                                            <input type="text"
                                                                                class="form-control @error('saison') is-invalid @enderror"
                                                                                name="saison"
                                                                                value="{{ $item['saison'] }}" required
                                                                                autocomplete="saison" autofocus
                                                                                id="saison">
                                                                            @error('saison')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="residence"
                                                                                class="form-label">Residence</label>
                                                                            <input type="text"
                                                                                class="form-control @error('residence') is-invalid @enderror"
                                                                                name="residence"
                                                                                value="{{ $item['residence'] }}" required
                                                                                autocomplete="residence" autofocus
                                                                                id="residence">
                                                                            @error('residence')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="visitor"
                                                                                class="form-label">Visiteur</label>
                                                                            <input type="text"
                                                                                class="form-control @error('visitor') is-invalid @enderror"
                                                                                name="visitor"
                                                                                value="{{ $item['visitor'] }}" required
                                                                                autocomplete="visitor" autofocus
                                                                                id="visitor">
                                                                            @error('visitor')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="n_disque"
                                                                                class="form-label">Numéro de
                                                                                la
                                                                                disque</label>
                                                                            <input type="number"
                                                                                class="form-control @error('n_disque') is-invalid @enderror"
                                                                                name="n_disque"
                                                                                value="{{ $item['n_disque'] }}"
                                                                                value="{{ old('n_disque') }}" required
                                                                                autocomplete="n_disque" autofocus
                                                                                id="n_disque">
                                                                            @error('n_disque')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="date_match"
                                                                                class="form-label">Date du
                                                                                match</label>
                                                                            <input type="date"
                                                                                class="form-control @error('date_match') is-invalid @enderror"
                                                                                name="date_match"
                                                                                value="{{ $item['date_match'] }}" required
                                                                                autocomplete="date_match" autofocus
                                                                                id="date_match">
                                                                            @error('date_match')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="journey"
                                                                                class="form-label">Journée</label>
                                                                            <input type="text"
                                                                                class="form-control @error('journey') is-invalid @enderror"
                                                                                name="journey"
                                                                                value="{{ $item['journey'] }}" required
                                                                                autocomplete="journey" autofocus
                                                                                id="journey">
                                                                            @error('journey')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="result"
                                                                                class="form-label">Résultat
                                                                                du
                                                                                match</label>
                                                                            <input type="text"
                                                                                class="form-control @error('result') is-invalid @enderror"
                                                                                name="result"
                                                                                value="{{ $item['result'] }}" required
                                                                                autocomplete="result" autofocus
                                                                                id="result">
                                                                            @error('result')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="description"
                                                                                class="form-label">Description du
                                                                                match</label>
                                                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                                                                autocomplete="description" autofocus id="description">{{ $item['description'] }}</textarea>
                                                                            @error('description')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3 d-flex align-items-center">
                                                                            <input class="w-fit-content"
                                                                                name="is_right_now" id="is_right_now"
                                                                                {{ $item->is_right_now ? 'checked' : '' }}
                                                                                type="checkbox">
                                                                            <label class="form-label mx-2 mb-0">Match en ce
                                                                                moment</label>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Enregistrer</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button title="Voir details" class="btn btn-success mx-2"
                                                            type="button" data-bs-toggle="modal"
                                                            data-bs-target="#DetailsMatch-{{ $key }}"><i
                                                                class="fas fa-eye"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="DetailsMatch-{{ $key }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="DetailsMatch-{{ $key }}-Label"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="DetailsMatch-{{ $key }}-Label">
                                                                            {{ $item->residence }} vs {{ $item->visitor }}
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="image-match">
                                                                            <img src="{{ $item->image }}"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="details my-3">
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Residence
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->residence }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Visiteur
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->visitor }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Saison
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->saison }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Journée
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->journey }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Date du match
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->date_match }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Type du match
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->type_match?->name }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Populaire en ce moment
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->is_right_now ? 'Oui' : 'Non' }}
                                                                                </p>
                                                                            </div>
                                                                            <div
                                                                                class="d-flex align-center justify-content-between">
                                                                                <p class="font-weight-bold">
                                                                                    Resultat
                                                                                </p>
                                                                                <p>
                                                                                    {{ $item->result }}
                                                                                </p>
                                                                            </div>
                                                                            <hr>
                                                                            <div>
                                                                                <p>
                                                                                    {{ $item->short_description }}
                                                                                </p>
                                                                            </div>
                                                                            @if ($item->description)
                                                                                <div>
                                                                                    <p class="font-weight-bold">
                                                                                        Description
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $item->description }}
                                                                                    </p>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Fermer</button>
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
                        @endif

                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
