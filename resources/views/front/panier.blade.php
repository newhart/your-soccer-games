@extends('layouts.app')
<style>
    section#list-panier {
        padding-top: 150px;
    }

    .image-produit img {
        width: 145px;
        height: 145px;
    }

    input.coute-produite::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    input.coute-produite {
        background-color: #fff;
        height: 40px;
        width: 40px;
        text-align: center;
        border-radius: 5px;
        margin: 0 10px;
    }

    .info-produit {
        width: calc(100% - 290px);
    }

    .details-produit {
        padding: 15px;
    }

    .action {
        padding: 15px;
    }

    .card.list-panier {
        margin: 15px 0;
    }

    .modal-backdrop.fade.show {
        display: none;
    }

    .continier {
        display: flex;
        align-items: center;
    }

    .continier span {
        font-size: 25px;
        margin-right: 10px;
    }

    @media (max-width: 575px) {
        section#list-panier {
            padding-top: 100px;
        }
    }

    @media(max-width: 991px) {
        .info-produit {
            width: 100%;
        }

        .action {
            border-top: 1px var(--color-base) solid;
            border-bottom: 1px var(--color-base) solid;
        }
    }

    @media (max-width: 500px) {
        .item-panier.d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            justify-content: flex-end !important;
            align-items: flex-end !important;
        }

        .info-produit {
            border-bottom: 1px var(--color-base) solid;
        }
    }

    .action {
        min-width: 310px;
    }

    button.btn.btn-primary {
        position: relative;
    }

    button.btn.btn-primary .spinner-grow,
    button.btn.btn-primary .spinner-border {
        width: 25px;
        position: absolute;
        right: 5px;
        top: 5px;
        height: 25px;
        display: none;
    }

    button.btn.btn-primary.loading .spinner-grow,
    button.btn.btn-primary.loading .spinner-border {
        display: block;
    }

    @media (max-width: 991px) {
        .item-panier.d-flex.justify-content-between {
            flex-direction: column;
        }
    }
</style>
@section('content')
    <section id="list-panier">
        <div class="container">
            <h3 class="text-primary">
                {{__('Cart')}}
            </h3>
            <div class="row m-0">
                <div class="col-lg-9 col-md-8 py-2">
                    @if (session('cart'))
                        @foreach (session('cart') as $id => $details)
                            @php
                                $slug = $details['slug'];
                            @endphp
                            <div data-id="{{ $id }}" id="cart_{{ $id }}" class="card list-panier">
                                <div class="item-panier d-flex justify-content-between">
                                    <div class="d-flex info-produit">
                                        {{-- <a href="{{ url("/show/$slug") }}" class="image-produit">
                                            <img src="{{ $details['image'] }}" alt="">
                                        </a> --}}
                                        <a href="{{ url("/show/$slug") }}" class="details-produit w-100">
                                            <p class="font-bold font16">
                                                {{ $details['residence'] }} vs {{ $details['visitor'] }}
                                            </p>
                                            @if (array_key_exists('competition', $details) && $details['competition'])
                                                <p>
                                                    {{__('Competition')}} : {{ $details['competition'] }}
                                                </p>
                                            @endif
                                            @if (array_key_exists('date', $details))
                                                <p>
                                                    {{__('Date of match')}}: {{ $details['date'] }}
                                                </p>
                                            @endif
                                            @if (array_key_exists('result', $details))
                                                <p>
                                                    Score : {{ $details['result'] }}
                                                </p>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="action">
                                        <p class="font-bold font16">
                                            {{__('Choice your product')}}
                                        </p>
                                        <form class="form-validate" method="post" action="#">
                                            @if (array_key_exists('possibility_match_complet', $details) && $details['possibility_match_complet'] == true)
                                                <div class="d-flex">
                                                    <p class="w-100 d-flex align-items-center">
                                                        <input id="checkbox-match_complet_{{ $id }}"
                                                            name="match_complet"
                                                            onChange="updateCarte(
                                                                {{ $details['id'] }},
                                                                'complet_match',
                                                                'checkbox-match_complet_{{ $id }}'
                                                            )"
                                                            {{ array_key_exists('complet_match', $details) && $details['complet_match'] ? 'checked' : '' }}
                                                            class="w-fit-content mr-2" type="checkbox">
                                                        <span class="pl-2">Match complet :
                                                            @foreach ($prix as $value_prix)
                                                                @if ($value_prix['id'] === 1)
                                                                    {{ $value_prix['prix'] }}€
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </p>
                                                </div>
                                            @elseif (!array_key_exists('possibility_match_complet', $details))
                                                <div class="d-flex">
                                                    <p class="w-100 d-flex align-items-center">
                                                        <input id="checkbox-match_complet1_{{ $id }}"
                                                            onChange="updateCarte(
                                                                {{ $details['id'] }},
                                                                'complet_match',
                                                                'checkbox-match_complet1_{{ $id }}'
                                                            )"
                                                            {{ array_key_exists('complet_match', $details) && $details['complet_match'] ? 'checked' : '' }}
                                                            name="match_complet" class="w-fit-content mr-2" type="checkbox">
                                                        <span class="pl-2">Match complet :
                                                            @foreach ($prix as $value_prix)
                                                                @if ($value_prix['id'] === 1)
                                                                    {{ $value_prix['prix'] }}€
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </p>
                                                </div>
                                            @endif
                                            @if (array_key_exists('possibility_hight_light', $details) && $details['possibility_hight_light'] == true)
                                                <div class="d-flex">
                                                    <p class="w-100 d-flex align-items-center">
                                                        <input id="checkbox-hight_light_{{ $id }}"
                                                            onChange="updateCarte(
                                                                {{ $details['id'] }},
                                                                'hight_light',
                                                                'checkbox-hight_light_{{ $id }}'
                                                            )"
                                                            name="hight_light"
                                                            {{ array_key_exists('hight_light', $details) && $details['hight_light'] ? 'checked' : '' }}
                                                            class="w-fit-content mr-2" type="checkbox">
                                                        <span class="pl-2">Hight light :
                                                            @foreach ($prix as $value_prix)
                                                                @if ($value_prix['id'] === 2)
                                                                    {{ $value_prix['prix'] }}€
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </p>
                                                </div>
                                            @elseif (!array_key_exists('possibility_hight_light', $details))
                                                <div class="d-flex">
                                                    <p class="w-100 d-flex align-items-center">
                                                        <input id="checkbox-hight_light1_{{ $id }}"
                                                            onChange="updateCarte(
                                                                {{ $details['id'] }},
                                                                'hight_light',
                                                                'checkbox-hight_light1_{{ $id }}'
                                                            )"
                                                            name="hight_light"
                                                            {{ array_key_exists('hight_light', $details) && $details['hight_light'] ? 'checked' : '' }}
                                                            class="w-fit-content mr-2" type="checkbox">
                                                        <span class="pl-2">Hight light :
                                                            @foreach ($prix as $value_prix)
                                                                @if ($value_prix['id'] === 2)
                                                                    {{ $value_prix['prix'] }}€
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </p>
                                                </div>
                                            @endif
                                        </form>
                                        <!-- Afficher l'élément de saisie de texte "Nom du joueur" uniquement si la case à cocher "hight_light" est cochée -->
                                        <input type="text" placeholder="Tapez le nom du joueur"
                                            class="form-text-name-joueur 
                                            @if (array_key_exists('hight_light', $details) && $details['hight_light']) @else
                                            d-none @endif"
                                            data-id="{{ $details['id'] }}"
                                            value="@if (array_key_exists('player', $details)) {{ $details['player'] }} @endif">
                                        <div class="error text-danger mt-2 font12"></div>
                                    </div>
                                    <form class="p-3" action="{{ route('remove.from.cart', $details['id']) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            {{__('Delete')}}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-primary AUCUN">{{__('Nothing match added')}}</h4>
                    @endif
                    <p>
                        <a href="{{ route('matchs') }}" class="text-primary continier">
                            <span>
                                < </span>{{__('Continue shopping')}}</a>
                    </p>
                </div>
                <div class="col-lg-3 col-md-4 py-2">
                    <div class="card total-prix">
                        <div class="px-2 pt-2">
                            <div class="d-flex align-items center justify-content-between">
                                <p>
                                    {{__('Number of match')}}
                                </p>
                                <p>
                                    {{ count((array) session('cart')) }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="px-2 pb-2 d-flex align-items center justify-content-between">
                            <p class="font16">
                                Total
                            </p>
                            <p class="font16 total-payer text-primary">
                                {{ $total ?? 0 }} €
                            </p>
                        </div>
                        <div class="mx-2 mb-2">
                            {{-- data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop" --}}
                                <form action="#" method="post">
                                    <button  id="valider_commande" class="btn btn-primary w-100" type="button" onclick="validateCommande()">
                                    {{__('Validate the order')}}
                                    <div class="spinner-border  text-light" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    </button>
                                    {{-- <button  class="btn btn-primary w-100" type="submit">
                                    {{__('Validate the order')}}
                                    <div class="spinner-border  text-light" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    </button> --}}
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="match_moment" class="section match_moment">
        <div class="container">
            <h3 class="text-primary">
               {{__('We also recommend')}}
            </h3>
            <div id="recipeCarousel" class="carousel multiple slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach ($product_rigt_now as $key => $product)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <div class="col-lg-3 col-md-4 col-sm-12 p-2">
                                <div class="card">
                                    <a href="{{ url("/show/$product->slug") }}" class="card-img position-relative">
                                        <img src="{{ $product->image }}" class="img-fluid">
                                        <img src="{{ asset('img/logo.webp') }}" alt=""
                                            class="logo-md absolute-logo">
                                    </a>
                                    <div class="card-content">
                                        <p class="mb-2">
                                            <a href="{{ url("/show/$product->slug") }}">
                                                {{ $product->residence }} vs {{ $product->visitor }}
                                            </a>
                                        </p>
                                        <div class="d-flex align-items-center justify-content-end w-100">
                                            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-primary">
                                                {{__('Add to cart')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button"
                    data-bs-slide="prev">
                    <span class="bg-row">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </span>
                </a>
                <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button"
                    data-bs-slide="next">
                    <span class="bg-row">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </span>
                </a>
            </div>
        </div>
    </section>
    <script>
        let items = document.querySelectorAll('.multiple .carousel-item')

        items.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    // wrap carousel by using first child
                    next = items[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
    </script>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('store.commandes') }}" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">Ajouter votre
                        information
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Votre nom</label>
                        <input required name="name" class="form-control" id="name" type="text">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Votre prénom</label>
                        <input required name="last_name" type="text" class="form-control" id="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input required name="email" type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Numéro téléphone</label>
                        <input minlength="10" maxlength="14" required name="phone_number" type="number"
                            class="form-control" id="phone_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Commander</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        function updateCarte(id, type, value) {
            $.post('update-cart/' + id, {
                type: type,
                value: document.getElementById(value).checked,
                _token: "{{ csrf_token() }}",
            }).done(function(response) {
                document.getElementsByClassName('total-payer')[0].innerHTML = response.total + ' €'
            });

            // Récupérez la case à cocher et l'input "Nom du joueur"
            const checkbox = document.getElementById('checkbox-hight_light_' + id);
            const checkbox1 = document.getElementById('checkbox-hight_light1_' + id);

            // Ajoutez un écouteur d'événements de changement sur la case à cocher
            if (checkbox !== null && checkbox.checked) {
                console.log('if');
                document.querySelector('#cart_' + id + ' .form-text-name-joueur').classList.remove('d-none')
                document.querySelector('#cart_' + id + ' .error').classList.remove('d-none')
            } else {
                document.querySelector('#cart_' + id + ' .form-text-name-joueur').classList.add('d-none')
                document.querySelector('#cart_' + id + ' .error').classList.add('d-none')
                console.log('else');
            }
            // if (checkbox1 !== null && checkbox1.checked) {
            //     console.log('if');
            //     document.querySelector('#cart_' + id + ' .form-text-name-joueur').classList.remove('d-none')
            // } else {
            //     document.querySelector('#cart_' + id + ' .form-text-name-joueur').classList.add('d-none')
            //     console.log('else');
            // }
        }

        var inputs = document.querySelectorAll('.form-text-name-joueur');

        inputs.forEach(input => {
            input.value = input.value.trim();
            input.addEventListener('input', function(event) {
                updatePlayerCart(input.getAttribute('data-id'), event.data);
            });
        });

        function updatePlayerCart(id, player) {
            $.post('update-player-cart/' + id, {
                player: document.querySelector('#cart_' + id + ' .form-text-name-joueur').value,
                _token: "{{ csrf_token() }}",
            }).done(function(response) {
                console.log('ok');
            });
        }

        function validateCommande() {
            $('#valider_commande').addClass('loading');
            $.get('validate-cart').done(function(response) {
                const propertyValues = Object.values(response.cart);
                propertyValues.forEach(element => {
                    $('#cart_' + element.id + ' .error').html('');
                });
                $('#valider_commande').removeClass('loading');
                if (response.errors || response.errors1) {
                    response.errors.forEach(element => {
                        $('#cart_' + element + ' .error').html(
                            'Vous devez choisir au moins une type de match');
                    });
                    response.errors1.forEach(element => {
                        $('#cart_' + element + ' .error').html(
                            'Vous devez tapez le nom du joueur');
                    });
                } else {
                    window.location.href = '/paiment'
                }
            });
        }
    </script>
@endsection
