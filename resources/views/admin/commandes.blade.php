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
                    <h1 class="m-0">Liste des commandes <strong>({{ $counts }} Match)</strong></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Liste des commandes</li>
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
                        <form action="{{ route('list.commandes') }}" method="get"
                            class="row card-header d-flex align-items-center">
                            <div class="col-lg-3 search-form" style='display:flex;'>
                                <input autocomplete="short_description" autofocus value="{{ $search }}"
                                    class="input-search" name="search" placeholder="Rechercher..." type="text">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                            <div class="col-lg-6 search-form filter-infos" style='display:flex;'>
                                <div class='row' style="width: 100%; ">
                                    <div class='col-lg-3'>
                                        <input type="date" name="date" class="input-select"
                                            value="{{ request()->get('date') ?? old('date') }}">
                                    </div>
                                    <div class='col-lg-3'>
                                        <select name="filter" class="input-select">
                                            <option {{ $filter === '' ? 'selected' : '' }} value="">Statuts
                                            </option>
                                            <option {{ $filter === 'Envoyer' ? 'selected' : '' }} value="Envoyer">Commandes
                                                envoyés
                                            </option>
                                            <option {{ $filter === 'En attente' ? 'selected' : '' }} value="En attente">
                                                Commandes
                                                encours</option>
                                            <option {{ $filter === 'Supprimer' ? 'selected' : '' }} value="Supprimer">
                                                Commandes
                                                Supprimer</option>
                                            {{-- Supprimer  --}}
                                        </select>
                                    </div>
                                    <div class='col-lg-3'>
                                        <select name="filter_month" class="input-select">
                                            <option {{ $filter_month === '' ? 'selected' : '' }} value="">Par mois
                                            </option>
                                            <option {{ $filter_month === '01' ? 'selected' : '' }} value="01">Janvier
                                            </option>
                                            <option {{ $filter_month === '02' ? 'selected' : '' }} value="02">Février
                                            </option>
                                            <option {{ $filter_month === '03' ? 'selected' : '' }} value="03">Mars
                                            </option>
                                            <option {{ $filter_month === '04' ? 'selected' : '' }} value="04">Avril
                                            </option>
                                            <option {{ $filter_month === '05' ? 'selected' : '' }} value="05">Mai
                                            </option>
                                            <option {{ $filter_month === '06' ? 'selected' : '' }} value="06">Juin
                                            </option>
                                            <option {{ $filter_month === '07' ? 'selected' : '' }} value="07">Juillet
                                            </option>
                                            <option {{ $filter_month === '08' ? 'selected' : '' }} value="08">Août
                                            </option>
                                            <option {{ $filter_month === '09' ? 'selected' : '' }} value="09">Septembre
                                            </option>
                                            <option {{ $filter_month === '10' ? 'selected' : '' }} value="10">Octobre
                                            </option>
                                            <option {{ $filter_month === '11' ? 'selected' : '' }} value="11">Novembre
                                            </option>
                                            <option {{ $filter_month === '12' ? 'selected' : '' }} value="12">Décembre
                                            </option>
                                            {{-- Supprimer  --}}
                                        </select>
                                    </div>
                                    <div class='col-lg-3'>
                                        @if (auth()->user()->type === 'Admin')
                                            <select name="filter_partenaire" class="input-select ">
                                                <option {{ $filter_partenaire === '' ? 'selected' : '' }} value="">
                                                    Partenaires
                                                </option>
                                                @foreach ($partenaires as $partenaire)
                                                    <option {{ $filter_partenaire === $partenaire->id ? 'selected' : '' }}
                                                        value="{{ $partenaire->id }}">{{ $partenaire->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-2 search-form">
                                <button type="submit" class="btn btn-primary button-res">Appliquer</button>
                            </div>
                        </form>
                        <div class="table-wrapper">
                            <table class="table caption-top table-container responsive-table">
                                <caption>
                                    {{ $commandes->appends([
                                            'search' => $search ?? null,
                                            'filter' => request()->get('filter'),
                                            'date' => request()->get('date'),
                                            'filter_month' => request()->get('filter_month'),
                                        ])->links('front.components.pagination') }}
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Partenaire</th>
                                        {{-- <th scope="col">Date du match</th> --}}
                                        <th scope="col">Date du commande</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd(count($commandes->groupBy('is_same_time'))) --}}
                                    @foreach ($commandes as $key => $commande)
                                        <tr>
                                            <th scope="row">Ref-{{ $commande->is_same_time }}
                                            </th>
                                            <td>{{ $commande['name'] }}</td>
                                            <td>{{ $commande['last_name'] }}</td>
                                            <td>{{ $commande['email'] }}</td>
                                            <td>
                                                {{-- {{App\Services\PartenaireHelperService::test($commande->unique('product'))}} --}}
                                            </td>
                                            {{-- <td>{{ $commande->product?->date_match }} </td> --}}
                                            <td>{{ $commande->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span
                                                    class="@if ($commande->status == 'En attente') badge badge-primary @elseif($commande->status == 'Supprimer') badge badge-danger @else  badge badge-success @endif">{{ $commande->status }}</span>
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <button title="Voir details" class="btn btn-success mx-2" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#DetailsMatch-{{ $key }}"><i
                                                        class="fas fa-eye"></i></button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="DetailsMatch-{{ $key }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="DetailsMatch-{{ $key }}-Label"
                                                    aria-hidden="true">
                                                    <div @if (count($commande->products) > 1) style="max-width: 970px;" @endif
                                                        class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="DetailsMatch-{{ $key }}-Label">
                                                                    Commande de {{ $commande['name'] }}
                                                                    {{ $commande['last_name'] }}
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('commandes.send_product', $commande->is_same_time) }}"
                                                                method="post" class="modal-body">
                                                                @csrf
                                                                <div class="row">
                                                                    @foreach ($commande->products as $product)
                                                                        <div
                                                                            @if (count($commande->products) > 1) class="col-6" @else class="col-12" @endif>
                                                                            <div class="image-match">
                                                                                <img src="{{ $product?->image }}"
                                                                                    alt="">
                                                                            </div>
                                                                            <div class="details my-3">
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Nom du match
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->residence }}
                                                                                        VS
                                                                                        {{ $product?->visitor }}
                                                                                    </p>
                                                                                </div>
                                                                                @if ($commande?->player)
                                                                                    <div
                                                                                        class="d-flex align-center justify-content-between">
                                                                                        <p class="font-weight-bold">
                                                                                            Nom du joueur
                                                                                        </p>
                                                                                        <p class="text-primary">
                                                                                            {{ $commande?->player }}
                                                                                        </p>
                                                                                    </div>
                                                                                @endif
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Référence
                                                                                    </p>
                                                                                    <p>
                                                                                        Ref-{{ $commande?->is_same_time }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Nom
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $commande?->name }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Prénom
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $commande?->last_name }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Email
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $commande?->email }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Numéro de télephone
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $commande->phone_number }}
                                                                                    </p>
                                                                                </div>

                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Date du match
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->date_match }}
                                                                                    </p>
                                                                                </div>

                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Saison
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->saison }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Score
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->result }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Numéro du disque
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->n_disque }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Date du commande
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $commande->created_at->format('d M Y') }}
                                                                                    </p>
                                                                                </div>

                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Partenaires
                                                                                    </p>
                                                                                    <p>
                                                                                        {{ $product?->user?->name === 'Administrateur' ? 'Your soccer games' : $product?->user?->name }}
                                                                                    </p>
                                                                                </div>

                                                                                <div
                                                                                    class="d-flex align-center justify-content-between">
                                                                                    <p class="font-weight-bold">
                                                                                        Type du match a commander
                                                                                    </p>
                                                                                    <p class="text-primary">
                                                                                        {{ $commande->match_complet && $commande->hight_light ? 'Les deux' : ($commande->match_complet ? 'Match complet' : 'Hight light') }}
                                                                                    </p>
                                                                                </div>
                                                                                <hr class="mt-3">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('commandes.validation', $commande) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="email"
                                                                            value="{{ $commande->email }}">
                                                                        <input type="hidden" name="is_same_time"
                                                                            value="{{ $commande->is_same_time }}">
                                                                        <input type="hidden" name="refuser"
                                                                            value="Refuser">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Refuser</button>
                                                                    </form>
                                                                    <form
                                                                        action="{{ route('commandes.validation', $commande) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="email"
                                                                            value="{{ $commande->email }}">
                                                                        <input type="hidden" name="is_same_time"
                                                                            value="{{ $commande->is_same_time }}">
                                                                        <input type="hidden" name="envoyer"
                                                                            value="Envoyer">
                                                                        <button type="submit"
                                                                            @if ($commande->status === 'Envoyer') disabled @endif
                                                                            class="btn btn-primary">Valider</button>
                                                                    </form>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($commande->status !== 'Envoyer')
                                                    <form method="POST"
                                                        action="{{ route('commandes.validation', $commande) }}">
                                                        @csrf
                                                        <input type="hidden" name="envoyer" value="Envoyer">
                                                        <input type="hidden" name="email"
                                                            value="{{ $commande->email }}">
                                                        <input type="hidden" name="is_same_time"
                                                            value="{{ $commande->is_same_time }}">
                                                        <button title="Confrimer la commande" class="btn btn-primary mx-2"
                                                            type="submit"><i class="fas fa-check-circle"></i></button>
                                                    </form>
                                                @endif
                                                @if (!$commande->mail_send)
                                                    <form method="POST" action="{{ route('email.send') }}">
                                                        @csrf
                                                        <input type="hidden" name="email"
                                                            value="{{ $commande->email }}">
                                                        <input type="hidden" name="is_same_time"
                                                            value="{{ $commande->is_same_time }}">
                                                        <button title="Envoyer le mail" class="btn btn-secondary mx-2"
                                                            type="submit"><i
                                                                class="fas fa-solid fa-paper-plane"></i></button>
                                                    </form>
                                                @endif

                                                @if ($commande->status !== 'Supprimer')
                                                    <form method="POST"
                                                        action="{{ route('commandes.delete', $commande) }}">
                                                        <input type="hidden" name="email"
                                                            value="{{ $commande->email }}">
                                                        <input type="hidden" name="is_same_time"
                                                            value="{{ $commande->is_same_time }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button onclick="return confirm('Supprimer?')"
                                                            title="Supprimer la commande" class="btn btn-danger mx-2"
                                                            type="submit"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
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
