<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site en Maintenance</title>
    {{-- <link rel="stylesheet" href="styles.css"> --}}
    <style>
     body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .maintenance-wrapper {
        text-align: center;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #333;
    }

    p {
        color: #555;
        font-size: 18px;
    }

    .maintenance-image {
        max-width: 100%;
        margin-top: 20px;
    }

    </style>
</head>
<body>
    <div class="maintenance-wrapper">
        <h1>Site en Maintenance</h1>
        <p>Nous travaillons dur pour améliorer votre expérience. Le site sera bientôt de retour.</p>
        <img src="{{asset('img/m.png')}}" alt="Image de maintenance" class="maintenance-image">
        <p>Merci de votre patience.</p>
    </div>
</body>
</html>
