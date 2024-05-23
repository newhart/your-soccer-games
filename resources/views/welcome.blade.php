@extends('layouts.app')
<style>
    .font12 {
        font-size: 10px;
    }

    .card.petite:hover {
        background-color: #97db2c1a;
        transition: all 0.2s;
    }
</style>
@section('content')
    <section id="home" class="img-bg-top">
        <div id="carouselSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item w-100 active">
                    <img src="{{ asset('img/carousel/mbape.jpg') }}" class="d-block w-100 h-100" alt="...">
                    <div class="carousel-caption d-block w-100">
                        <div class="container">
                            <h3 class="text-primary">{{ __('+ 300,000 matches to choose from !') }}</h3>
                            <p class="text-white">
                                {{ __('Your Soccer Games offers you the largest football match database since 2004.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item w-100">
                    <img src="{{ asset('img/carousel/messi.png') }}" class="d-block w-100 h-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption d-block">
                            <h3 class="text-primary">{{ __('+ 300,000 matches to choose from !') }}</h3>
                            <p class="text-white">
                                {{ __('Your Soccer Games offers you the largest football match database since 2004.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item w-100">
                    <img src="{{ asset('img/carousel/christ.jpg') }}" class="d-block w-100 h-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption d-block">
                            <h3 class="text-primary">{{ __('+ 300,000 matches to choose from !') }}</h3>
                            <p class="text-white">
                                {{ __('Your Soccer Games offers you the largest football match database since 2004.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="match_moment" class="section match_moment">
        <div class="container">
            <h3 class="text-primary">
                {{ __('Current matches') }}
            </h3>
            <div id="recipeCarousel" class="carousel multiple slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach ($product_rigt_now as $key => $product)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <div class="col-lg-3 col-md-4 col-sm-12 p-2">
                                <div class="card">

                                    @if ($moment_type->video === 'on')
                                        <h6 class="mb-2" style="color: white; text-align:center; margin-top: 5px;">
                                            {{ $product->title }}
                                            </h4>
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="{{ $product->url }}"></iframe>
                                            </div>
                                        @else
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
                                                    <a href="{{ route('add.to.cart', $product->id) }}"
                                                        class="btn btn-primary">
                                                        {{ __('Add to cart') }}
                                                    </a>
                                                </div>
                                            </div>
                                    @endif

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

    {{-- <section  class="section match_moment">
        <div class="container">
            <h3 class="text-primary">
                Partenaires
            </h3>
            <div id="partenaireCarousel" class="carousel multiple" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach ($partenaires as $k => $partenaire)
                        <div class="carousel-item {{ $k === 0 ? 'active' : '' }}">
                            <div class="col-lg-12 col-md-6 col-sm-12 p-2">
                                <div class="card">
                                    <a href="{{route('partenaires.userMatch' , $partenaire)}}" class="card-img position-relative">
                                        <img src="https://via.placeholder.com/400x400.png/00ff77?text=blanditiis" class="img-fluid">
                                        <img src="{{ asset('img/logo.webp') }}" alt=""
                                            class="logo-md absolute-logo">
                                    </a>
                                    <div class="card-content d-flex">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2">
                                                    <a href="{{route('partenaires.userMatch', $partenaire)}}">
                                                        {{$partenaire->name}}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-end">
                                                    <p class="p-2"><strong>Format du video</strong> : {{$partenaire->profile?->format}}</p>
                                                    <p class="p-2"><strong>Nombre du matchs</strong> : {{$partenaire->profile?->total_number}}</p>
                                                    <p class="p-2"><strong>Livraison</strong> : {{$partenaire->profile?->livraison}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev bg-transparent w-aut" href="#partenaireCarousel" role="button"
                    data-bs-slide="prev">
                    <span class="bg-row">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </span>
                </a>
                <a class="carousel-control-next bg-transparent w-aut" href="#partenaireCarousel" role="button"
                    data-bs-slide="next">
                    <span class="bg-row">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </span>

                </a>
            </div>
        </div>
    </section> --}}
    <section id="cta" class="cta">
        <div class="container">
            <div class="text-center">
                <h3>{{ __('About Us') }}</h3>
                <p>
                    {{ __('about content') }}
                </p>
            </div>
        </div>
    </section>
    <section id="allMatch" class="section abouts">
        <div class="container">
            <h3 class="text-primary">
                {{ __('Good discovery') }}
            </h3>
            <div class="list-all-match row m-0">
                @foreach ($all_products as $item)
                    <div class="col-12 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
                        <div class="card petite">
                            {{-- <div>
                                    <a href="{{ url("/show/$item->slug") }}" class="card-img position-relative">
                                        <img src="{{ $item->image }}" class="img-fluid">

                                        <img src="{{ asset('img/logo.webp') }}" alt=""
                                            class="logo-md absolute-logo">
                                    </a>
                                    <a class="text-center mt-1" href="{{ url("/show/$item->slug") }}" class="">
                                        {{ $item->result }}
                                    </a>
                                </div> --}}
                            <div class="card-content w-100">
                                <div>
                                    <a style="font-size: 12px;" class="text-primary" href="{{ url("/show/$item->slug") }}"
                                        class="">
                                        {{ $item->residence }} vs {{ $item->visitor }}
                                    </a>
                                    @if ($item->competition)
                                        <span href="{{ url("/show/$item->slug") }}" style="font-size: 12px"
                                            class="font12 text-white">
                                            {{ __('Competition') }} : {{ $item->competition }}
                                        </span>
                                    @endif
                                    <span href="{{ url("/show/$item->slug") }}" style="font-size: 12px"
                                        class="font12 text-white">
                                        Date : {{ $item->date_match }}
                                    </span>
                                    <span href="{{ url("/show/$item->slug") }}" style="font-size: 12px"
                                        class="font12 text-white">
                                        Score : {{ $item->result }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-end w-100 mt-2">
                                    {{-- <h3 class="text-base mb-0">
                                            {{ $item->price }}$
                                        </h3> --}}
                                    <a href="{{ route('add.to.cart', $item->id) }}" class="btn btn-primary">
                                        {{ __('Add to cart') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="tem">
        <div class="container mt-4">
            <h3 class="text-primary text-center">
                <i class="fa fa-user-o"></i>
                {{ __('Testimonials') }}
            </h3>
            <div class="carousel slide" data-bs-ride="carousel" id="myCarousel">
                <div class="carousel-inner">
                    <ul class="list-unstyled">
                        <!-- Les vidéos seront ajoutées ici dynamiquement -->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="playerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="playerModalLabel">Joyeux Anniversaire</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Carousel -->
                    <div id="recipeCarousels" class="carousel multiple slide" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            @foreach ($playersWithBirthdayToday as $index => $player)
                                <div class="carousel-item {{ $index === 2 ? 'active' : '' }}">
                                    <div class="col-lg-3 col-md-4 col-sm-12 p-2">
                                        <div class="card">
                                            <a href="#" class="card-img position-relative">
                                                <img src="{{ asset('img/birthday.jpg') }}" class="img-fluid">
                                                <img src="{{ asset('img/logo.webp') }}" alt=""
                                                    class="logo-md absolute-logo">
                                            </a>
                                            <div class="card-content">
                                                <p class="mb-2">
                                                    <strong>Nom:</strong> {{ $player->first_name }}
                                                </p>
                                                <p class="mb-2">
                                                    <strong>Prénom:</strong> {{ $player->last_name }}
                                                </p>
                                                <p class="mb-2">
                                                    <strong>Date de naissance:</strong>
                                                    {{ \Carbon\Carbon::parse($player->birth_date)->format('d-m-Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousels" role="button"
                            data-bs-slide="prev">
                            <span class="bg-row">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </span>
                        </a>
                        <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousels" role="button"
                            data-bs-slide="next">
                            <span class="bg-row">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Afficher le modal au chargement de la page
            $('#playerModal').modal('show');
        });
    </script>
    <script>
        const loadCarousel = function(items) {
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
        }
        const items = document.querySelectorAll('.multiple .carousel-item')
        loadCarousel(items)
        document.addEventListener("DOMContentLoaded", function() {
            var youtubeVideos = [
                'https://www.youtube.com/watch?v=QyTmUNnj_YE',
                'https://www.youtube.com/watch?v=8aB8XJkSpFE',
                'https://www.youtube.com/watch?v=2ItC9-JSOmw',
                'https://www.youtube.com/watch?v=Ugv4UlUMGdg',
                'https://www.youtube.com/watch?v=ysQIss3HojQ',
                'https://www.youtube.com/watch?v=CkO56PUoY3c',
                'https://www.youtube.com/watch?v=3U9vc7Mjltc'
            ];

            var videoList = document.querySelector('.carousel-inner ul');

            youtubeVideos.forEach(function(videoUrl, index) {
                var videoId = videoUrl.split('v=')[1];
                var listItem = document.createElement('li');
                listItem.classList.add('carousel-item');
                if (index === 0) {
                    listItem.classList.add('active');
                }
                var iframe = document.createElement('iframe');
                iframe.setAttribute('width', '100%');
                iframe.setAttribute('height', '315');
                iframe.setAttribute('src', 'https://www.youtube.com/embed/' + videoId);
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allowfullscreen', '');
                listItem.appendChild(iframe);
                videoList.appendChild(listItem);
            });
            var carousel = document.getElementById('myCarousel');
            var prevBtn = document.createElement('a');
            prevBtn.classList.add('carousel-control-prev');
            prevBtn.href = '#myCarousel';
            prevBtn.role = 'button';
            prevBtn.setAttribute('data-bs-slide', 'prev');
            prevBtn.innerHTML =
                '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span>';

            var nextBtn = document.createElement('a');
            nextBtn.classList.add('carousel-control-next');
            nextBtn.href = '#myCarousel';
            nextBtn.role = 'button';
            nextBtn.setAttribute('data-bs-slide', 'next');
            nextBtn.innerHTML =
                '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span>';

            carousel.appendChild(prevBtn);
            carousel.appendChild(nextBtn);
        });
    </script>
@endsection
