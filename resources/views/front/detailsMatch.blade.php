@extends('layouts.app')
<style>
    section#details-produite {
        padding-top: 150px;
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

    .image-produite-details img.img-pro {
        width: 450px;
        height: 285px;
        border-radius: 10px;
    }
</style>
@section('content')
    <section id="details-produite">
        <div class="container">
            <h3 class="text-primary">
                Détails match
            </h3>
            <div class="d-flex flex-details-match">
                <div class="image-produite-details me-4 position-relative">
                    <img class="img-pro" src="{{ $product->image }}" alt="{{ $product->matchs }}">
                    <img src="{{ asset('img/logo.webp') }}" alt="" class="logo-md absolute-logo">
                </div>
                <div class="details-produite-details w-100">
                    <h3 class="text-primary">
                        {{ $product->residence }} vs {{ $product->visitor }}
                    </h3>
                    <p>
                        {{ $product->short_description }}
                    </p>
                    <div class="d-flex align-items-center justify-content-between mt-3 w-100">
                        {{-- <h3 class="text-base my-0 d-flex">
                            Prix:
                            <span class="text-primary pl-2">
                                {{ $product->price }}$
                            </span>
                        </h3> --}}
                        <div class="d-flex align-items-center">
                            {{-- <div class="nombre-produit d-flex align-items-center">
                                <div class="action-up-down">
                                    <a href="#">
                                        <i class="fa fa-chevron-up text-primary"></i>
                                    </a>
                                    <a href="#">
                                        <i class="fa fa-chevron-down text-primary"></i>
                                    </a>
                                </div>
                                <input value="1" class="coute-produite" type="number">
                            </div> --}}
                            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-primary">
                                Ajouter au panier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="cta"
        style="
            background: linear-gradient(rgba(2, 2, 2, 0.5), rgba(0, 0, 0, 0.8)), url('{{ $product->image }}') center center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        "
        class="cta mt-5">
        <div class="container">
            <div>
                <h3 class="text-primary">Informations complémentaires</h3>
                <div class="row my-0 mx-0">
                    <div class="col-md-3">
                        <p>Saison</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->saison }}</p>
                    </div>
                    <div class="col-md-3">
                        <p>Journée</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->journey }}</p>
                    </div>
                    <div class="col-md-3">
                        <p>Identification du match</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->matchs }}</p>
                    </div>
                    <div class="col-md-3">
                        <p>Date du match</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->date_match }}</p>
                    </div>
                    <div class="col-md-3">
                        <p>Résultat du match</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->result }}
                            {{-- {{ (int) explode('-', $product->result)[0] > (int) explode('-', $product->result)[1] ? "(Victoire $product->residence)" : "(Victoire $product->visitor)" }} --}}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p>Format de la video</p>
                    </div>
                    <div class="col-md-9">
                        <p> : .{{ $product->format }}</p>
                    </div>
                    {{-- <div class="col-md-3">
                        <p>Nombre du fichier</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->format }}</p>
                    </div> --}}
                    <div class="col-md-3">
                        <p>Numéro dans le disque</p>
                    </div>
                    <div class="col-md-9">
                        <p> : {{ $product->n_disque }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="match_moment" class="section match_moment">
        <div class="container">
            <h3 class="text-primary">
                Nous vous conseillons également
            </h3>
            <div id="recipeCarousel" class="carousel multiple slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach ($related_products as $key => $product)
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
                                            {{-- <h3 class="text-base mb-0">
                                                <a href="{{ url("/show/$product->slug") }}">
                                                    {{ $product->price }}$
                                                </a>
                                            </h3> --}}
                                            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-primary">
                                                Ajouter au panier
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
@endsection
