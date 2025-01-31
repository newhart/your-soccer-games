@extends('layouts.app')
@section('style')
    <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>
    <!-- Mobiscroll CSS Includes -->
    <link rel="stylesheet" href="{{ asset('css/mobiscroll.jquery.min.css') }}">

    <style>
        select#date {
            height: 55px !important;
        }

        section#allMatch {
            padding-top: 150px;
        }

        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input.input-filter {
            background-color: #f1f1f1;
            width: 100%;
        }

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
            cursor: pointer;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .filter-match {
            padding: 10px;
            background: var(--bg-primary);
            box-shadow: 0 0 6px #6e6e6e66;
        }

        .font12 {
            font-size: 10px;
        }

        .card.petite a.btn.btn-primary {
            FONT-SIZE: 11px;
        }

        .select2-selection--single,
        .select2-selection__rendered,
        select.form-select {
            height: 47px !important;
        }

        .select2-selection__rendered,
        .select2-selection__arrow {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
        }

        .select2-selection__arrow {
            padding-right: 10px !important;
        }

        .form-select2-cust {
            background-color: #fff;
            border: 1px #aaa solid;
            border-radius: 5px;
        }

        button.select2-selection__clear {
            height: 46px !important;
            color: #97db2c;
        }

        .card.petite:hover {
            background-color: #97db2c1a;
            transition: all 0.2s;
        }


        @media(max-width: 428px) {
            .col-2-5.px-2 {
                padding: 3px !important;
            }
        }

        @media (min-width: 429px) {
            .col-2-5 {
                flex: 50%;
                max-width: 50%;
            }

            .col-2-5.px-2 {
                padding: 3px !important;
            }
        }

        @media (min-width: 992px) {
            .col-2-5 {
                flex: 20%;
                max-width: 20%;
            }

            .col-2-5.px-2 {
                padding: 3px !important;
            }
        }

        @media (max-width: 575px) {
            section#allMatch {
                padding-top: 95px;
            }
        }

        .mbsc-scroller-wheel-item.mbsc-ios.mbsc-ltr.mbsc-wheel-item-checkmark div {
            display: none;
        }
    </style>
@endsection
@section('content')
    <section id="allMatch" class="section abouts">
        <div class="container">
            <h3 class="text-primary">
                {{ __('All match') }} @if ($user) {{__('of partenaire')}} {{$user->name}}@endif
            </h3>
            <div class="list-all-match row  mx-0  my-0">
                <form method="GET" action="{{ route($route, $user ? $user->id : null) }}"
                    class="col-12 row  mx-0 filter-match my-0" id="form_validation">
                    <input type="hidden" id="player-hidden" value="{{ request()->get('player') }}">
                    <input type="hidden" id="club-hidden" value="{{ request()->get('club') }}">
                    <input type="hidden" id="country-hidden" value="{{ request()->get('country') }}">
                    <input type="hidden" id="competition-hidden" value="{{ request()->get('competition') }}">
                    <input type="hidden" id="date-hidden" value="{{ request()->get('date') }}">
                    <div class="col-2-5 px-2 pl-0 type-joueur">
                        <div class="position-relative">
                            <input value="{{ request()->get('player') ?? '' }}" name="player" id="player-hidden-input"
                                type="hidden">
                            <label class="m-0">
                                {{ __('Players') }}
                                <input mbsc-input id="search-player-box" data-dropdown="true" data-input-style="box"
                                    data-label-style="stacked" placeholder="{{ __('search') }}..." />
                            </label>
                            @if (request()->get('player'))
                                <button id="player-clear" onclick="clearValue('player')" type="button"
                                    class="btn-close clear-select-input"></button>
                            @endif
                        </div>
                    </div>
                    <div class="col-2-5 px-2">
                        <div class="position-relative">
                            <input value="{{ request()->get('club') ?? '' }}" name="club" id="club-hidden-input"
                                type="hidden">
                            <label class="m-0">
                                {{ __('Club') }}
                                <input mbsc-input id="search-club-box" data-dropdown="true" data-input-style="box"
                                    data-label-style="stacked" placeholder="{{ __('search') }}..." />
                            </label>
                            @if (request()->get('club'))
                                <button id="club-clear" onclick="clearValue('club')" type="button"
                                    class="btn-close clear-select-input"></button>
                            @endif
                        </div>
                    </div>
                    <div class="col-2-5 px-2">
                        <div class="position-relative">
                            <input value="{{ request()->get('country') ?? '' }}" name="country" id="country-hidden-input"
                                type="hidden">
                            <label class="m-0">
                                {{ __('Pays') }}
                                <input mbsc-input id="search-pays-box" data-dropdown="true" data-input-style="box"
                                    data-label-style="stacked" placeholder="{{ __('search') }}..." />
                            </label>
                            @if (request()->get('country'))
                                <button id="country-clear" onclick="clearValue('country')" type="button"
                                    class="btn-close clear-select-input"></button>
                            @endif
                        </div>
                    </div>
                    <div class="col-2-5 px-2">
                        <div class="position-relative">
                            <input value="{{ request()->get('competition') ?? '' }}" name="competition"
                                id="competition-hidden-input" type="hidden">
                            <label class="m-0">
                                {{ __('Competition') }}
                                <input mbsc-input id="search-competition-box" data-dropdown="true" data-input-style="box"
                                    data-label-style="stacked" placeholder="{{ __('search') }}..." />
                            </label>
                            @if (request()->get('competition'))
                                <button id="competition-clear" onclick="clearValue('competition')" type="button"
                                    class="btn-close clear-select-input"></button>
                            @endif
                        </div>
                    </div>
                    <div class="col-2-5 px-2 pr-0">
                        <div class="autocomplete" style="width:100%;">
                            <?php if ($date_interval) {
                                $years = range($date_interval[1], $date_interval[0]);
                            } else {
                                $years = [];
                            } ?>
                            <div class="position-relative">
                                <select class="form-select date h-100" value="{{ request()->get('date') ?? '' }}"
                                    name="date" id="date">
                                    <option hidden disabled {{ request()->get('date') ? '' : 'selected' }}>
                                        {{ __('Season Year') }}
                                    </option>
                                    <?php foreach($years as $year) : ?>
                                    <option {{ request()->get('date') == $year ? 'selected' : '' }}
                                        value="<?php echo $year; ?>">
                                        <?php echo $year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                @if (request()->get('date'))
                                    <button id="date-clear" onclick="clearValue('date')" type="button"
                                        class="btn-close clear-select-input"></button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-2-5 px-2 pr-0 d-none">
                        <button class="btn btn-primary w-100 h-100" id="submit-forme" type="submit">
                            {{ __('search') }}
                        </button>
                    </div>
                </form>
                @if (count($all_products) > 0)
                    @foreach ($all_products as $item)
                        <div class="col-12 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2" data-toggle="tooltip"
                            data-placement="top"
                            title="Information : Les matchs affichés en double ou triple sont des sauvegardes pour assurer la meilleure qualité vidéo des enregistrements à long terme .">
                            <div class="card petite">
                                <div class="card-content w-100">
                                    <div>
                                        <a style="font-size: 12px;" class="text-primary"
                                            href="{{ url("/show/$item->slug") }}" class="">
                                            {{ $item->residence }} vs {{ $item->visitor }}
                                        </a>
                                        @if ($item->competition)
                                            <span href="{{ url("/show/$item->slug") }}" class="font12 text-white">
                                                {{ __('Competition') }} : {{ $item->competition }}
                                            </span>
                                        @endif
                                        <span href="{{ url("/show/$item->slug") }}" class="font12 text-white">
                                            @if ($item->date_match === '2009-01-01')
                                                Saison : {{ $item->saison }}
                                            @else
                                                {{ __('Date of match') }} : {{ $item->date_match }}
                                            @endif
                                        </span>
                                        <span href="{{ url("/show/$item->slug") }}" class="font12 text-white">
                                            Score : {{ $item->result }}
                                        </span>
                                        @if ($item->langue)
                                            <span href="{{ url("/show/$item->slug") }}" class="font12 text-white">
                                                Langue : {{ $item->langue }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end w-100 mt-2">
                                        <a href="{{ url('add-to-cart/' . $item->id . '?player=' . request()->get('player')) }}"
                                            class="btn btn-primary">
                                            {{ __('Add to cart') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-primary AUCUN">
                        {{ __('Search results for') }} :
                        {{ request()->get('player') . ' .' ?? '' }}{{ request()->get('club') . ' .' ?? '' }}{{ request()->get('competition') . ' .' ?? '' }}{{ request()->get('date') . ' .' ?? '' }}
                        <br>
                        {{ __('nout found match') }}
                    </h4>
                @endif
            </div>
            <input type="hidden" id="url-hidden" value="{{asset('')}}">
            {{ $all_products->appends([
                    'player' => request()->get('player'),
                    'club' => request()->get('club'),
                    'competition' => request()->get('competition'),
                    'date' => request()->get('date'),
                    'country' => request()->get('country'),
                ])->links('front.components.pagination') }}
        </div>
    </section>
@endsection
@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/mobiscroll.jquery.min.js') }}"></script>
    <script>
        const  current_uri = document.getElementById('url-hidden').value 
        mobiscroll.setOptions({
            locale: mobiscroll
                .localeFr,
            theme: 'ios',
            themeVariant: 'light'
        });

        function clearValue(e) {
            if (e === 'date') {
                document.querySelector('#date').value = null
                document.querySelector('#date-clear').classList.add('d-none');
            } else {
                if (e === 'country') {
                    document.querySelector('#search-pays-box').value = ''
                    document.querySelector('#' + e + '-clear').classList.add('d-none');
                    document.querySelector('#' + e + '-hidden-input').value = '';
                } else {
                    document.querySelector('#search-' + e + '-box').value = ''
                    document.querySelector('#' + e + '-clear').classList.add('d-none');
                    document.querySelector('#' + e + '-hidden-input').value = '';
                }
            }
            document.querySelector('#submit-forme').click()
        }

        $(function() {
            const validation_form = document.getElementById('form_validation');

            var inst = $('#search-player-box').mobiscroll().select({
                display: 'anchored',
                filter: true,
                data: [],
                onFilter: function(
                    ev
                ) { // More info about onFilter: https://docs.mobiscroll.com/5-23-2/select#event-onFilter
                    remoteFiltering(ev.filterText);
                    return false;
                },
                onChange: function(ev, inst) {
                    console.log(ev);
                    $('#player-hidden-input').val(ev.value)
                    $('#submit-forme').click()
                    document.getElementById('loading-overlay').style.display = 'flex';
                },
            }).mobiscroll('getInst');

            var inst1 = $('#search-club-box').mobiscroll().select({
                display: 'anchored',
                filter: true,
                data: [],
                onFilter: function(
                    ev
                ) { // More info about onFilter: https://docs.mobiscroll.com/5-23-2/select#event-onFilter
                    remoteFiltering1(ev.filterText);
                    return false;
                },
                onChange: function(ev, inst) {
                    $('#club-hidden-input').val(ev.value)
                    $('#submit-forme').click()
                    document.getElementById('loading-overlay').style.display = 'flex';
                },
            }).mobiscroll('getInst');


            var inst2 = $('#search-pays-box').mobiscroll().select({
                display: 'anchored',
                filter: true,
                data: [],
                onFilter: function(
                    ev
                ) { // More info about onFilter: https://docs.mobiscroll.com/5-23-2/select#event-onFilter
                    remoteFiltering2(ev.filterText);
                    return false;
                },
                onChange: function(ev, inst) {
                    $('#country-hidden-input').val(ev.value)
                    $('#submit-forme').click()
                    document.getElementById('loading-overlay').style.display = 'flex';
                },
            }).mobiscroll('getInst');

            var inst3 = $('#search-competition-box').mobiscroll().select({
                display: 'anchored',
                filter: true,
                data: [],
                onFilter: function(
                    ev
                ) { // More info about onFilter: https://docs.mobiscroll.com/5-23-2/select#event-onFilter
                    remoteFiltering3(ev.filterText);
                    return false;
                },
                onChange: function(ev, inst) {
                    $('#competition-hidden-input').val(ev.value)
                    $('#submit-forme').click()
                    document.getElementById('loading-overlay').style.display = 'flex';
                },
            }).mobiscroll('getInst');

            function remoteFiltering(filterText) {
                $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').addClass('loading')
                $.getJSON(current_uri + 'players/search' + '?search=' + filterText + '&club=' + document
                    .getElementById(
                        'club-hidden').value,
                    function(data) {
                        var item;
                        var airports = [];
                        for (var i = 0; i < data.data.length; i++) {
                            item = data.data[i];
                            airports.push({
                                text: item.full_name,
                                value: item.full_name
                            })
                        }
                        $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').removeClass('loading')

                        inst.setOptions({
                            data: airports
                        });
                    }, 'jsonp');
            }

            function remoteFiltering1(filterText) {
                $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').addClass('loading')
                $.getJSON(current_uri + 'club/search' + '?search=' + filterText + '&player=' + document
                    .getElementById(
                        'search-player-box').value,
                    function(data, loading) {
                        var item1;
                        var airports1 = [];

                        for (var i = 0; i < data.length; i++) {
                            item1 = data[i];
                            airports1.push({
                                text: item1.name,
                                value: item1.name
                            })
                        }
                        $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').removeClass('loading')
                        inst1.setOptions({
                            data: airports1
                        });
                    }, 'jsonp');
            }

            function remoteFiltering2(filterText) {
                $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').addClass('loading')
                $.getJSON(current_uri + 'country/search' + '?search=' + filterText + '&player=' + document
                    .getElementById(
                        'search-player-box').value,
                    function(data) {
                        var item2;
                        var airports2 = [];

                        for (var i = 0; i < data.length; i++) {
                            item2 = data[i];
                            airports2.push({
                                text: item2.name,
                                value: item2.name
                            })
                        }
                        $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').removeClass('loading')
                        inst2.setOptions({
                            data: airports2
                        });
                    }, 'jsonp');
            }

            function remoteFiltering3(filterText) {
                $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').addClass('loading')
                $.getJSON(current_uri + 'competition/search' + '?search=' + filterText + '&player=' + document
                    .getElementById(
                        'search-player-box').value,
                    function(data) {
                        var item3;
                        var airports3 = [];

                        if (data.data && data.data.length > 0) {
                            for (var i = 0; i < data.data.length; i++) {
                                item3 = data.data[i];
                                airports3.push({
                                    text: item3.name,
                                    value: item3.name
                                })
                            }
                        }
                        $('.mbsc-select-empty-text.mbsc-flex.mbsc-ios').removeClass('loading')
                        inst3.setOptions({
                            data: airports3
                        });
                    }, 'jsonp');
            }

            function clearValue(e) {
                if (e === 'date') {
                    document.querySelector('#date').value = null
                    document.querySelector('#date-clear').classList.add('d-none');
                } else {
                    document.querySelector('#search-box-' + e).value = ''
                    document.querySelector('#' + e + '-clear').classList.add('d-none');
                }
                $('#submit-forme').click()
            }


            // set value$
            document.getElementById('search-player-box').value = document.getElementById('player-hidden').value

            document.getElementById('search-club-box').value = document.getElementById('club-hidden').value

            document.getElementById('search-pays-box').value = document.getElementById('country-hidden').value

            document.getElementById('search-competition-box').value = document.getElementById('competition-hidden')
                .value

            document.querySelector('#date').addEventListener('change', function(event) {
                validation_form.submit()
            });

            remoteFiltering(document.querySelector('#search-player-box').value);
            remoteFiltering1(document.querySelector('#search-club-box').value);
            remoteFiltering2(document.querySelector('#search-pays-box').value);
            remoteFiltering3(document.querySelector('#search-competition-box').value);
        });
    </script>
@endsection
