<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Your Soccer Games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery.steps@1.1.2/dist/jquery-steps.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    {{-- {!! NoCaptcha::renderJs() !!} --}}
    <style>
        body {
            background: #ddd;
            min-height: 100vh;
            vertical-align: middle;
            display: flex;

        }

        .card {
            margin: auto;
            width: 600px;
            padding: 3rem 3.5rem;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .mt-50 {
            margin-top: 50px
        }

        .mb-50 {
            margin-bottom: 50px
        }


        @media(max-width:767px) {
            .card {
                width: 90%;
                padding: 1.5rem;
            }
        }

        @media(height:1366px) {
            .card {
                width: 90%;
                padding: 8vh;
            }
        }

        .card-title {
            font-weight: 700;
            font-size: 2.5em;
        }

        .nav {
            display: flex;
        }

        .nav ul {
            list-style-type: none;
            display: flex;
            padding-inline-start: unset;
            margin-bottom: 6vh;
        }

        .nav li {
            padding: 1rem;
        }

        .nav li a {
            color: black;
            text-decoration: none;
        }

        .active {
            border-bottom: 2px solid black;
            font-weight: bold;
        }

        .step-tab-panel.active {
            border-bottom: none;
            font-weight: bold;
        }

        input {
            border: none;
            outline: none;
            font-size: 1rem;
            font-weight: 600;
            color: #000;
            width: 100%;
            min-width: unset;
            background-color: transparent;
            border-color: transparent;
            margin: 0;
        }

        .stripe img.logo-mode-paiement {
            width: 215px;
        }

        form a {
            color: grey;
            text-decoration: none;
            font-size: 0.87rem;
            font-weight: bold;
        }

        form a:hover {
            color: grey;
            text-decoration: none;
        }

        form .row {
            margin: 0;
            overflow: hidden;
        }

        form .row-1 {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 0.5rem;
            outline: none;
            width: 100%;
            min-width: unset;
            border-radius: 5px;
            background-color: rgba(221, 228, 236, 0.301);
            border-color: rgba(221, 228, 236, 0.459);
            margin: 2vh 0;
            overflow: hidden;
        }

        form .row-2 {
            border: none;
            outline: none;
            background-color: transparent;
            margin: 0;
            padding: 0 0.8rem;
        }

        form .row .row-2 {
            border: none;
            outline: none;
            background-color: transparent;
            margin: 0;
            padding: 0 0.8rem;
        }

        form .row .col-2,
        .col-7,
        .col-3 {
            display: flex;
            align-items: center;
            text-align: center;
            padding: 0 1vh;
        }

        form .row .col-2 {
            padding-right: 0;
        }

        #card-header {
            font-weight: bold;
            font-size: 0.9rem;
        }

        #card-inner {
            font-size: 0.7rem;
            color: gray;
        }

        .three .col-7 {
            padding-left: 0;
        }

        .three {
            overflow: hidden;
            justify-content: space-between;
        }

        .three .col-2 {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 0.5rem;
            outline: none;
            width: 100%;
            min-width: unset;
            border-radius: 5px;
            background-color: rgba(221, 228, 236, 0.301);
            border-color: rgba(221, 228, 236, 0.459);
            margin: 2vh 0;
            width: fit-content;
            overflow: hidden;
        }

        .three .col-2 input {
            font-size: 0.7rem;
            margin-left: 1vh;
        }

        .btn {
            width: 100%;
            background-color: rgb(65, 202, 127);
            border-color: rgb(65, 202, 127);
            color: white;
            justify-content: center;
            padding: 10px 0;
            margin-top: 3vh;
        }

        .btn:focus {
            box-shadow: none;
            outline: none;
            box-shadow: none;
            color: white;
            -webkit-box-shadow: none;
            -webkit-user-select: none;
            transition: none;
        }

        .btn:hover {
            color: white;
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        input:focus:-moz-placeholder {
            color: transparent;
        }

        input:focus::-moz-placeholder {
            color: transparent;
        }

        input:focus:-ms-input-placeholder {
            color: transparent;
        }

        .step-tab-panel .container {
            padding: 0;
        }

        button.step-btn {
            width: 100%;
            height: 51px;
            border: none;
            background-color: #32c5d2;
            color: #fff;
            outline: none;
            border-radius: 5px;
            font-size: 20px;
            font-weight: 600;
        }

        label.form-check-label img {
            width: 95px;
            height: 50px;
            object-fit: contain;
        }

        .form-check-input {
            width: fit-content;
            margin-top: 10px;
        }

        img.logo-mode-paiement {
            width: 120px;
            margin: auto;
            display: block;
        }

        .step-tab-panel.step-paiment .d-none.paypal_mode {
            display: block !important;
        }

        .step-tab-panel.step-paiment.paypal .d-none.paypal_mode {
            display: block !important;
        }

        .step-tab-panel.step-paiment.paypal .d-none.stripe_mode {
            display: none !important;
        }

        .step-tab-panel.step-paiment.stripe .d-none.stripe_mode {
            display: block !important;
        }

        .step-tab-panel.step-paiment.stripe .d-none.paypal_mode {
            display: none !important;
        }

        li.text-center.step-top {
            pointer-events: none;
        }

        li.text-center.step-top.done,
        li.text-center.step-top.active {
            pointer-events: visible;
        }

        .card.mt-50.mb-50 {
            height: fit-content;
        }

        .form-check:last-child label.form-check-label img {
            width: 170px;
            height: 131px;
            object-fit: contain;
        }
    </style>
</head>

<body>

</body>
<div class="card mt-50 mb-50">
    <div style="font-size: 27px;
    text-align: center;" class="card-title mx-auto">
        {{ __('Payment') }} Your Soccer Games
    </div>

    <div class="step-app" id="demo">
        <ul class="step-steps">
            <li data-step-target="step1" class="text-center step-top">{{ __('Personal information') }}</li>
            <li data-step-target="step2" class="text-center step-top">{{ __('Payment information') }}</li>
        </ul>
        <div class="step-content">
            <div class="step-tab-panel" data-step="step1">
                <form class="info-personnelle" action="{{ route('store.commandes') }}" method="post"
                    style="border: none;" class="modal-content">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Your name') }}</label>
                        <input required name="name" class="form-control" id="name" type="text">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">{{ __('Your firstname') }}</label>
                        <input required name="last_name" type="text" class="form-control" id="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input required name="email" type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">{{ __('Phone number') }}</label>
                        <input minlength="10" maxlength="14" required name="phone_number" type="number"
                            class="form-control" id="phone_number">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                id="flexRadioDefault2" onchange="setModePaiment('paypal')" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                <img src="{{ asset('img/paypal.png') }}" alt="">
                            </label>
                        </div>
                        {{-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                id="flexRadioDefault1" onchange="setModePaiment('stripe')">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <img src="{{ asset('img/stripe.jpg') }}" alt="">
                            </label>
                        </div> --}}
                    </div>

                    <div class="step-footer">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" id="captcha"></div>
                        <button type="submit" id="validate" class="step-btn mt-3">{{ __('Next') }}</button>
                    </div>
                </form>
            </div>
            <div class="step-tab-panel step-paiment" data-step="step2">
                <div class="d-none stripe_mode">
                    <img class="logo-mode-paiement" src="{{ asset('img/stripe.jpg') }}" alt="">
                    @include('stripe', ['total' => $total])
                </div>
                <div class="panel panel-default d-none paypal_mode">
                    <div class="panel-body">
                        <img class="logo-mode-paiement" src="{{ asset('img/paypal.png') }}" alt="">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <script type="text/javascript">
                                if (document.getElementsByClassName('info-personnelle')[0].checkValidity()) {
                                    $('.info-personnelle').get(0).submit();
                                } else {
                                    $('#staticBackdrop').modal('show');
                                }
                            </script>
                        @elseif (session()->has('error'))
                            <div class="alert alert-error">
                                {{ session()->get('error') }}
                            </div>
                        @else
                            {{-- <p class="mt-3 text-center">
                                Vous voullez vraiment avec paypal?
                            </p> --}}
                        @endif
                        <div class="row m-0">
                            <div class="col-12 px-0">
                                <a style="width: 100%" class="btn btn-primary btn-lg btn-block w-100 mt-0"
                                    href="{{ route('make.payment') }}">
                                    {{ __('Proceed to order') }}
                                    ({{ $total }}€)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="step-footer">
            <button data-step-action="next" style="opacity: 0;position: absolute; z-index: -1;"
                class="step-btn next-hidden"></button>
            {{-- <button data-step-action="finish" class="step-btn">Finish</button> --}}
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('store.commandes') }}" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">
                    {{ __('Add your information') }}
                </h1>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('Your name') }}
                    </label>
                    <input required name="name" class="form-control" id="name" type="text">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">
                        {{ __('Your firstname') }}
                    </label>
                    <input required name="last_name" type="text" class="form-control" id="last_name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required name="email" type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">{{ __('Phone number') }}</label>
                    <input minlength="10" maxlength="14" required name="phone_number" type="number"
                        class="form-control" id="phone_number">
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button> --}}
                <button type="submit" class="btn btn-primary">{{ __('Proceed to order') }}</button>
            </div>
        </form>
    </div>
</div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.steps@1.1.2/dist/jquery-steps.min.js"></script>
<script>
    const captcha = document.getElementById("captcha");
    const submitButton = document.getElementById("validate");
    captcha.addEventListener("click", function() {
        console.log(submitButton);
        submitButton.removeAttribute("disabled");
    });
    // $('#staticBackdrop').modal('show');
    $('#demo').steps({
        onFinish: function() {
            alert('complete');
        },
        onStepChanged: function(event, currentIndex) {
            if (ocument.getElementsByClassName('info-personnelle')[0].checkValidity()) {
                return true;
            } else {
                return false;
            }
        }
    });

    const form = document.getElementsByClassName('info-personnelle')[0]

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const response = grecaptcha.getResponse();
        if (response.length === 0) {
            alert('Veuillez coucher le google captcha')
            return
        } else {
            const formData = new FormData(form);
            $.ajax({
                url: "{{ route('save.client') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    // Handle the error response
                }
            });
            if (document.getElementsByClassName('info-personnelle')[0].checkValidity()) {
                document.getElementsByClassName('next-hidden')[0].click();
            } else {
                document.getElementById('validate').click()
            }
        }
    });

    function displayErrors(errors) {
        // Affiche les erreurs de validation sur la page
        // Par exemple, vous pouvez les afficher à côté des champs correspondants dans le formulaire
        Object.keys(errors).forEach(field => {
            const errorElement = document.querySelector(`#${field}-error`);
            if (errorElement) {
                errorElement.textContent = errors[field][0]; // Affiche seulement le premier message d'erreur
            }
        });
    }

    function setModePaiment(mode) {
        if (mode === 'stripe') {
            document.getElementsByClassName('step-paiment')[0].classList.add('stripe');
            document.getElementsByClassName('step-paiment')[0].classList.remove('paypal');
        } else {
            document.getElementsByClassName('step-paiment')[0].classList.remove('stripe');
            document.getElementsByClassName('step-paiment')[0].classList.add('paypal');
        }
    }
</script>

</html>
