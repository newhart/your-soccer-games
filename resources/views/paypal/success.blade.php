<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('Title payment') }}</h1>
            <p class="lead">{{ __('Sub title payment') }}</p>
            <hr class="my-4">
            <p>
                {{ __('Description payment') }}
            </p>
            <a class="btn btn-primary btn-lg mt-4" href="{{ route('index') }}" role="button">Retour à la boutique</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (popper.js and jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>

</html>
