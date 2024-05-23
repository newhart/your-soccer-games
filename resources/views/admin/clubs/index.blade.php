@extends('layouts.admin')
@section('style')
    <style>
        tr {
            line-height: 66px;
        }

        .details div {
            line-height: 20px;
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des clubs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Liste des clubs</li>
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
        <div class="container">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="">
                        <form action="{{ route('clubs.index') }}" method="get"
                            class="row card-header d-flex align-items-center">
                            <div class="col-lg-12 search-form" style='display:flex;'>
                                <input autocomplete="short_description" autofocus value="" class="input-search"
                                    name="search" placeholder="Rechercher..." type="text" value="{{ $search }}">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>

                        </form>
                        <div class="table-wrapper">
                            <table class="table caption-top table-container responsive-table">
                                <caption>
                                    {{ $clubs->appends([
                                            'search' => $search ?? null,
                                        ])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Nom du clubs</th>
                                        {{-- <th scope="col">Modifier en</th> --}}
                                        {{-- <th scope="col">Nom en En</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clubs as $key => $club)
                                        <tr>
                                            <td>{{ $club->residence }}</td>
                                            {{-- <td></td> --}}
                                            <td class="d-flex align-items-center">
                                                <button title="Voir details" class="btn btn-success mx-2" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#DetailsMatch-{{ $key }}"><i
                                                        class="fas fa-edit"></i></button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="DetailsMatch-{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="DetailsMatch-{{ $key }}-Label"
                                                    aria-hidden="true">
                                                    <div style="max-width: 970px;" class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="DetailsMatch-{{ $key }}-Label">
                                                                    Modification nom du club
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('clubs.change') }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="name_club">Nom du club</label>
                                                                    <input type="text" value="{{ $club->residence }}"
                                                                        name="oldName" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="name_club">Modifier en</label>
                                                                    <input type="text" name="newName" required
                                                                        class="form-control">
                                                                </div>
                                                                {{-- <div class="form-group">
                                                                <label for="name_club">Nom du club en englais</label>
                                                                <input type="text" class="form-control">
                                                            </div> --}}
                                                                <button class="btn btn-primary btn-lg">Valider</button>
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
