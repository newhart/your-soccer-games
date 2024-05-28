<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Your Soccer Games</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}">
    @vite('resources/js/app.js')
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

    <style>
        img.img-match {
            width: 70px;
            object-fit: contain;
        }

        td {
            min-height: 87px;
        }

        body:not(.layout-fixed) .main-sidebar {
            position: fixed;
            top: 0;
        }

        .w-fit-content {
            width: fit-content;
        }

        .wrapper .content-wrapper {
            min-height: calc(100vh - calc(3.5rem + 1px) - calc(3.5rem + 1px)) !important;
        }

        .input-search {
            width: 100%;
            height: 40px;
            background-color: #fff;
            padding-left: 10px;
            border-radius: 10px;
            border: 1px #00000024 solid;
        }

        .input-select {
            width: 100%;
            height: 40px;
            background-color: #fff;
            border-radius: 10px;
            border: 1px #00000024 solid;
            padding: 10px
        }

        .button-res {
            padding-left: 27px !important;
            border-radius: 10px !important;
            padding-left: 20px !important;
            padding-right: 20px !important;
            width: 100%;
        }
    </style>
    @yield('style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <div class="header-responsive menu-toggle">
            <span onclick="setMenu()"></span>
            <span onclick="setMenu()"></span>
            <span onclick="setMenu()"></span>
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" id="sidebar">
            <!-- Brand Logo -->
            <a href="/home" class="brand-link">
                <img src="{{ asset('img/logo.webp') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
                <p class="brand-text font-weight-light font16">Administrateur</p>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/home') }}" class="nav-link li-home">
                                        <i class="fas fa-baseball-ball  nav-icon"></i>
                                        <p>Liste des matchs</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/home') }}" class="nav-link li-home">
                                        <i class="fas fa-baseball-ball  nav-icon"></i>
                                        <p>Match du moment</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('competition.index') }}" class="nav-link li-competition">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Liste des compétitions</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('clubs.index') }}" class="nav-link li-club">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Liste des clubs</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('partenaires.index') }}" class="nav-link li-club"
                                            id="partenaires">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Gestion des partenaires </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('list-pays') }}" class="nav-link li-pays">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Liste des pays</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('players') }}" class="nav-link li-player">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Liste des joueurs</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('list.commandes') }}" class="nav-link li-commandes">
                                        <i class="fas fa-baseball-ball  nav-icon"></i>
                                        <p>
                                            Commandes
                                            @if ($commandes > 0)
                                                <span class="right badge badge-danger">{{ $commandes }}</span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('players.older') }}" class="nav-link li-player-older">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>
                                                Encient Joueurs
                                                @if ($older_player > 0)
                                                    <span class="right badge badge-danger">{{ $older_player }}</span>
                                                @endif
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('disk.index') }}" class="nav-link li-commandes">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Gestion de disque</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('match.prix') }}" class="nav-link li-prix">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Gestion du prix</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->type === 'Admin')
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/translations" class="nav-link li-prix">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Translations</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.parametre') }}" class="nav-link li-prix">
                                            <i class="fas fa-baseball-ball  nav-icon"></i>
                                            <p>Paramètre</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#desconnect" href="#"
                                class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Se deconnecter
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" onclick="setMenu()">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer d-flex">
            <!-- To the right -->
            <!-- Default to the left -->
            <strong class="d-flex">Copyright &copy; 2023 <a href="#" class="px-1">soccer_games.</a></strong>
            All rights
            reserved.
        </footer>
        <!-- Modal -->
        <div class="modal fade" id="desconnect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="desconnectLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="desconnectLabel">
                            Se déconnecter
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="modal-body">
                        @csrf
                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label mb-0">Vous voullez vraiment
                                se deconnecter?</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <script type="text/javascript">
        var currentRoute = "{{ Route::currentRouteName() }}";
        if (window.location.href.indexOf("/home") > -1) {
            document.getElementsByClassName("li-home")[0].classList.add('active');
        }
        if (window.location.href.indexOf("/competitions") > -1) {
            document.getElementsByClassName("li-competition")[0].classList.add('active');
        }
        // li-player
        if (window.location.href.indexOf("/players") > -1) {
            document.getElementsByClassName("li-player")[0].classList.add('active');
        }
        if (window.location.href.indexOf("/list-pays") > -1) {
            document.getElementsByClassName("li-pays")[0].classList.add('active');
        }
        if (window.location.href.indexOf("/list-commandes") > -1) {
            document.getElementsByClassName("li-commandes")[0].classList.add('active');
        }
        if (window.location.href.indexOf("/older") > -1) {
            document.getElementsByClassName("li-player-older")[0].classList.add('active');
        }
        if (window.location.href.indexOf("/gestion-prix") > -1) {
            document.getElementsByClassName("li-prix")[0].classList.add('active');
        }
        if (currentRoute === 'clubs.index') {
            document.getElementsByClassName("li-club")[0].classList.add('active');
        }
        if (currentRoute === 'partenaires.index') {
            document.getElementById('partenaires').classList.add('active');
        }
        const setMenu = () => {
            const menu = document.getElementById('sidebar')
            menu.classList.toggle('a')
        }
    </script>

    @yield('script')
</body>

</html>
