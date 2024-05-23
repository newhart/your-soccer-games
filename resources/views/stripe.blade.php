<div class="container">
    <div class="panel-body">

        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p class="mb-0">{{ Session::get('success') }}</p>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p class="mb-0">{{ Session::get('error') }}</p>
            </div>
        @endif

        <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
            @csrf

            <div class='form-row row'>
                <div class='col-12 px-0 form-group required'>
                    <label class='control-label'>
                        Nom sur la carte</label> <input class='form-control' size='4' type='text' required>
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-12 px-0 form-group required'>
                    <label class='control-label'>
                        Numéro de carte</label> <input id="test" autocomplete='off'
                        class='form-control card-number' size='20' type='text' maxlength="19" required>
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-12 col-md-4 form-group cvc required'>
                    <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc'
                        placeholder='ex. 123' size='4' type="text" pattern="\d*" maxlength="4" required>
                </div>
                <div class='col-12 px-0 col-md-4 form-group expiration required'>
                    <label class='control-label'>
                        Mois d'expiration</label> <input class='form-control card-expiry-month' placeholder='ex. 12'
                        size='2' type="text" pattern="\d*" maxlength="2" required>
                </div>
                <div class='col-12 col-md-4 form-group expiration required'>
                    <label class='control-label'>
                        Année d'expiration</label> <input class='form-control card-expiry-year' placeholder='ex. 2024'
                        size='4' type="text" pattern="\d*" maxlength="4" required>
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-md-12 px-0 error form-group hide mb-0'>
                    <div class='alert-danger alert mb-0'>
                        Chargement...
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 px-0">
                    <button id="valider_compte_stripe" style="width: 100%"
                        class="btn btn-primary btn-lg btn-block w-100" type="submit">Payez
                        maintenant
                        ({{ $total }}€)
                        <div class="spinner-border  text-light" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
<style>
    .hide {
        display: none;
    }

    button.btn.btn-primary {
        position: relative;
    }

    button.btn.btn-primary .spinner-grow,
    button.btn.btn-primary .spinner-border {
        width: 30px;
        position: absolute;
        right: 15px;
        top: 15px;
        height: 30px;
        display: none;
    }

    button.btn.btn-primary.loading .spinner-grow,
    button.btn.btn-primary.loading .spinner-border {
        display: block;
    }
</style>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var input = document.getElementById("test");

        input.onkeydown = function(event) {
            if (input.value.length > 0) {
                input.value.trim();
                if (event.code === 'Backspace' || event.code === 'Delete') {
                    input.value = "";
                }
                if (input.value.length === 4) {
                    input.value += " ";
                }
                if (input.value.length === 9) {
                    input.value += " ";
                }
                if (input.value.length === 14) {
                    input.value += " ";
                }
            }
        }


        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            $('#valider_compte_stripe').addClass('loading');
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]', 'input[type=number]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                console.log(response);
                $('#valider_compte_stripe').removeClass('loading');
                if (response.error.code === "missing_payment_information" ||
                    response.error.code === "invalid_number" ||
                    response.error.code === "invalid_expiry_year" ||
                    response.error.code === "invalid_expiry_month" ||
                    response.error.code === "incorrect_number" ||
                    response.error.code === "invalid_cvc") {
                    if (response.error.code === "invalid_number") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("Le numéro de la carte n'est pas valide.");
                    }
                    if (response.error.code === "missing_payment_information") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("Impossible de trouver les informations de paiement ");
                    }
                    if (response.error.code === "invalid_expiry_year") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("L'année d'expiration de votre carte n'est pas valide.");
                    }
                    if (response.error.code === "invalid_expiry_month") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("Le mois d'expiration de votre carte n'est pas valide.");
                    }
                    if (response.error.code === "incorrect_number") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("Votre numéro de carte est incorrect.");
                    }
                    if (response.error.code === "invalid_cvc") {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text("Le code de sécurité de votre carte est invalide.");
                    }
                } else {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                }

            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $('#valider_compte_stripe').removeClass('loading');
                if (document.getElementsByClassName('info-personnelle')[0].checkValidity()) {
                    $form.get(0).submit();
                    $('.info-personnelle').get(0).submit();
                } else {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text('Votre information personnelle est mal remplissez');
                }
            }
        }
    });
</script>
