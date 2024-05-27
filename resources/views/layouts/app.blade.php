<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Your Soccer Games</title>
    <!-- Styles -->
    @vite('resources/js/app.js')

    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

    <!-- Styles -->

    {{-- fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")
        }

        .centered-card {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Adjust as needed */
        }

        .dark_theme.bg-dots-darker {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='30' height='30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.227 0c.687 0 1.227.54 1.227 1.227s-.54 1.227-1.227 1.227S0 1.914 0 1.227.54 0 1.227 0z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E") !important;
        }

        main {
            min-height: calc(100vh - 39px) !important;
        }

        /* Par défaut, masquez le sous-menu */
        .submenu {
            display: none;
            position: absolute;
            background-color: #fff;
            /* Couleur d'arrière-plan du sous-menu */
            /* Autres styles CSS pour le sous-menu */
        }

        /* Affichez le sous-menu lorsque l'utilisateur survole l'élément principal */
        .has-submenu:hover .submenu {
            display: block;
        }

        /* Style de la boîte de sous-menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Style du contenu du sous-menu */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            /* Couleur de fond */
            min-width: 160px;
            /* Largeur minimale */
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            /* Ombre */
            z-index: 1;
        }

        /* Style des liens dans le sous-menu */
        .dropdown-content a {
            color: #333;
            /* Couleur du texte */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Style des liens au survol */
        .dropdown-content a:hover {
            background-color: #f2f2f2;
        }

        /* Afficher le sous-menu au survol */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #loading-spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dropdown-menu a {
            color: #383030 !important;
        }
    </style>
    @yield('style')
</head>

<body id="top" class="dark_theme bg-dots-darker">

    <div id="loading-overlay" class="overlay">
        <div class="overlay-content">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p>Chargement en cours...</p>
        </div>
    </div>

    <header class="header" data-header>
        <div class="flex-logo">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <p class="d-flex">
                        <span class="text-primary">Your Soccer Games</span>, {{ __('another way to') }} <span
                            class="text-primary px-1">{{ __('search') }}</span> {{ __('a match') }}...
                    </p>
                    <div class="navbar-actions">
                        <button class="theme-btn" aria-label="Change Theme" title="Change Theme" data-theme-btn>
                            <span class="icon"></span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center">
                    <button class="nav-toggle-btn" style="margin-right: 21px;" aria-label="Toggle Menu"
                        title="Toggle Menu" data-nav-toggle-btn>
                        <span class="one"></span>
                        <span class="two"></span>
                        <span class="three"></span>
                    </button>
                    {{-- header responsive  --}}
                    <nav class="navbar" data-navbar>
                        <ul class="navbar-list">

                            <li>
                                <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                    href="{{ url('/') }}" class="navbar-link mr-auto m-0">{{ __('Home') }}</a>
                            </li>
                            <li>
                                <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                    href="{{ url('/#cta') }}" class="navbar-link mr-auto m-0">{{ __('A bout') }}</a>
                                {{-- <ul class="submenu">
                                        <li><a href="{{ url('/#cta') }}">{{__('CTA')}}</a></li>
                                        <li><a href="{{ url('/#tem') }}">{{__('Testimonials')}}</a></li>
                                    </ul> --}}
                            </li>
                            <li>
                                <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                    href="{{ url('/#tem') }}"
                                    class="navbar-link mr-auto m-0">{{ __('Testimonials') }}</a>
                            </li>
                            <div class="dropdown" style="margin-left: 60px;">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" style="color: #f2f2f2; " type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Partenaires
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($users as $user)
                                            @if ($user->type === 'Admin')
                                                <a class="dropdown-item" href="{{ route('matchs') }}">Your soccer
                                                    game</a>
                                            @else
                                                <a class="dropdown-item"
                                                    href="{{ route('partenaires.userMatch', $user->id) }}">{{ $user->name }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <li>
                                {{-- <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                    href="{{ url('/#match_moment') }}" class="navbar-link mr-auto m-0">{{__('Current matches')}}</a> --}}
                                <div class="dropdown">
                                    <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                        href="{{ url('/#match_moment') }}"
                                        class="navbar-link mr-auto m-0">{{ __('Current matches') }}</a>
                                    <div class="dropdown-content">
                                        <a href="#">Item 1</a>
                                        <a href="#">Item 2</a>
                                        <a href="#">Item 3</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a onclick="document.getElementsByClassName('nav-toggle-btn')[0].click()"
                                    href="{{ url('/all-matchs') }}"
                                    class="navbar-link mr-auto m-0">{{ __('All match') }}</a>
                            </li>

                        </ul>
                    </nav>
                    <div class="logo me-6">
                        <a href="{{ url('/#') }}">
                            <img src="{{ asset('img/logo.webp') }}" alt="" class="logo-md">
                        </a>
                    </div>
                    <div class="list-menu-nav d-flex align-items-center">
                        <a href="{{ url('/#') }}">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ url('/#cta') }}">
                            {{ __('A bout') }}
                        </a>
                        <a href="{{ url('/#tem') }}">{{ __('Testimonials') }}</a>
                        <div class="dropdown">
                            <div class="dropdown">
                                <button class="dropdown-toggle" style="color: #f2f2f2; " type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Partenaires
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach ($users as $user)
                                        @if ($user->type === 'Admin')
                                            <a class="dropdown-item" href="{{ route('matchs') }}">Your soccer
                                                game</a>
                                        @else
                                            <a class="dropdown-item"
                                                href="{{ route('partenaires.userMatch', $user->id) }}">{{ $user->name }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('/all-matchs') }}">
                            {{ __('All match') }}
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ url('/panier') }}" class="d-flex cursor-pointor align-items-center all-panier">
                        <p class="mx-2 text-panier">
                            {{ __('Cart') }}
                        </p>
                        <img class="pe-1" src="{{ asset('img/panier.png') }}" alt="">
                        <p>
                            ({{ count((array) session('cart')) }})
                        </p>
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    @include('partials.language-selector')
                </div>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p>Copyright &copy; 2023<strong> -Your Soccer Games</strong>{{ __('All rights reserved.') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="https://www.facebook.com/yoursoccergames"
                                target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    {{--
    @if (Route::currentRouteName() === 'index')
        <div class="offcanvas offcanvas-bottom show" style="background: var(--bg-primary);" tabindex="-1"
            id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header pb-0">
                <h5 style="font-size:1.300rem; " class="offcanvas-title text-primary text-center w-100"
                    id="offcanvasBottomLabel"> {{ __('information') }}
                </h5>
                <button type="button" class="btn-close text-primary" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <p style="font-size: 1.125rem;" class="text-center">
                    {{ __('Information content') }}
                </p>
            </div>
        </div>
    @endif --}}
    @if (session('success-store-commande'))
        <div class="offcanvas offcanvas-bottom show" style="background: var(--bg-primary);" tabindex="-1"
            id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header pb-0">
                <h5 style="font-size:1.300rem; " class="offcanvas-title text-primary text-center w-100"
                    id="offcanvasBottomLabel">{{ __('thank you for your order') }}
                </h5>
                <button type="button" class="btn-close text-primary" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <p style="font-size: 1.125rem;" class="text-center">
                    {{ __('order admin') }}
                    <br>
                    {{ __('content order admin') }}
                </p>
            </div>
        </div>
        {{-- <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
            crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $("#successCommandes").modal('show');
            });
        </script>
        <div id="successCommandes" class="modal fade show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary text-center">Votre commande a été transmise à
                            l'administrateur. </h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text-black">{{ session('success-store-commande') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div> --}}
    @endif
    @if (session('error'))
        @include('partials.message')
    @endif
    <!-- End Footer -->
    <!--
    - #GO TO TOP
  -->
    <a href="#top" class="go-top" data-go-top title="Go to Top">
        <ion-icon name="arrow-up"></ion-icon>
    </a>
    {{-- <script src="{{ asset('build/assets/app-4c85f5d2.js') }}" defer>
    </script> --}}
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9F68KZN12R"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9F68KZN12R');
    </script>
    @yield('javascript')

</body>

</html>
