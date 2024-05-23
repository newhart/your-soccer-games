@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('admin/css/mobiscroll.javascript.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des partenaires</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Liste des partenaires</li>
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
                                    class="input-search" name="search" placeholder="{{ __('search') }}..." type="text">
                                <button type="submit" class="btn btn-primary">{{ __('search') }}</button>
                            </form>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Ajouter un partenaire
                            </button>

                            <!-- Modal add new  -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                Ajouter un nouveau partenaires
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('partenaires.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                                    id="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nom</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                                    id="name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="type" class="form-label">Lecteur vidéo conseille</label>
                                                <input type="text"
                                                    class="form-control @error('type') is-invalid @enderror" name="type"
                                                    value="{{ old('type') }}" required autocomplete="type" autofocus
                                                    id="type">
                                                @error('type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="presentation" class="form-label">Présentation du
                                                    collectionneur</label>
                                                <input type="text"
                                                    class="form-control @error('presentation') is-invalid @enderror"
                                                    name="presentation" value="{{ old('presentation') }}" required
                                                    autocomplete="presentation" autofocus id="presentation">
                                                @error('presentation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="format" class="form-label">Format vidéo : avi/ mp4</label>
                                                <input type="text"
                                                    class="form-control @error('format') is-invalid @enderror"
                                                    name="format" value="{{ old('format') }}" required
                                                    autocomplete="format" autofocus id="format">
                                                @error('format')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="livraison" class="form-label">Livraison</label>
                                                <input type="text"
                                                    class="form-control @error('livraison') is-invalid @enderror"
                                                    name="livraison" value="{{ old('livraison') }}" required
                                                    autocomplete="livraison" autofocus id="livraison">
                                                @error('livraison')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="total_number" class="form-label">Nombre de match total
                                                    disponible</label>
                                                <input type="number"
                                                    class="form-control @error('total_number') is-invalid @enderror"
                                                    name="total_number" value="{{ old('total_number') }}" required
                                                    autocomplete="total_number" autofocus id="total_number">
                                                @error('total_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="coverture" class="form-label">Couverture</label>
                                                <input type="text"
                                                    class="form-control @error('coverture') is-invalid @enderror"
                                                    name="coverture" value="{{ old('coverture') }}" required
                                                    autocomplete="coverture" autofocus id="coverture">
                                                @error('presentation')
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
                                    {{ $users->appends(['search' => $search ?? null])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <th>
                                                {{ $item->name }}
                                            </th>
                                            <td>{{ $item->email }}</td>
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
                                                                    Supprimer ce utilisateur
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('partenaires.delete', $item['id']) }}"
                                                                class="modal-body">
                                                                @method('DELETE')
                                                                @csrf
                                                                <div class="mb-3 d-flex align-items-center">
                                                                    <label class="form-label mb-0">Vous voullez vraiment
                                                                        supprimer cette partenaire</label>
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
                                                                    id="modify{{ $key }}Label">Modifier
                                                                    l'utilisateur
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('partenaires.updateUser', ['user' => $item['id']]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <input type="text"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        name="email"
                                                                        value="{{ $item['email'] ?? old('email') }}"
                                                                        required autocomplete="email" autofocus
                                                                        id="email">
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nom</label>
                                                                    <input type="text"
                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                        name="name"
                                                                        value="{{ $item['name'] ?? old('name') }}"
                                                                        required autocomplete="name" autofocus
                                                                        id="name">
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="type" class="form-label">Lecteur vidéo conseille</label>
                                                                    <input type="text"
                                                                        class="form-control @error('type') is-invalid @enderror" name="type"
                                                                        value="{{ $item?->profile?->type ?? old('type') }}" required autocomplete="type" autofocus
                                                                        id="type">
                                                                    @error('type')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="presentation" class="form-label">Présentation du
                                                                        collectionneur</label>
                                                                    <input type="text"
                                                                        class="form-control @error('presentation') is-invalid @enderror"
                                                                        name="presentation" value="{{ $item?->profile?->presentation ??  old('presentation') }}" required
                                                                        autocomplete="presentation" autofocus id="presentation">
                                                                    @error('presentation')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                    
                                                                <div class="mb-3">
                                                                    <label for="format" class="form-label">Format vidéo : avi/ mp4</label>
                                                                    <input type="text"
                                                                        class="form-control @error('format') is-invalid @enderror"
                                                                        name="format" value="{{ $item->profile?->format ?? old('format') }}" required
                                                                        autocomplete="format" autofocus id="format">
                                                                    @error('format')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="livraison" class="form-label">Livraison</label>
                                                                    <input type="text"
                                                                        class="form-control @error('livraison') is-invalid @enderror"
                                                                        name="livraison" value="{{ $item->profile?->livraison ?? old('livraison') }}" required
                                                                        autocomplete="livraison" autofocus id="livraison">
                                                                    @error('livraison')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="total_number" class="form-label">Nombre de match total
                                                                        disponible</label>
                                                                    <input type="number"
                                                                        class="form-control @error('total_number') is-invalid @enderror"
                                                                        name="total_number" value="{{$item->profile?->total_number ??  old('total_number') }}" required
                                                                        autocomplete="total_number" autofocus id="total_number">
                                                                    @error('total_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                    
                                                                <div class="mb-3">
                                                                    <label for="coverture" class="form-label">Couverture</label>
                                                                    <input type="text"
                                                                        class="form-control @error('coverture') is-invalid @enderror"
                                                                        name="coverture" value="{{ $item->profile?->coverture ??  old('coverture') }}" required
                                                                        autocomplete="coverture" autofocus id="coverture">
                                                                    @error('presentation')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Modifier</button>
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

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/mobiscroll.javascript.min.js') }}"></script>
    <script>
        mobiscroll.select('#multiple-select', {
            inputElement: document.getElementById('my-input'),
            touchUi: false
        });
    </script>
@endsection
