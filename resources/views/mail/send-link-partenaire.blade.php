<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>Your Soccer Games</title>
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Arial, sans-serif;
        }

        input#lien {
            width: 100%;
            height: 33px;
            border: 1px #97db2c solid;
            border-right: none;
            outline: none;
            border-radius: 5px 0 0 5px;
        }

        button.btn-btn-primary {
            height: 33px;
            border: none;
            color: #fff;
            background-color: #97db2c;
            padding: 0 37px;
            border-radius: 5px;
        }
    </style>
</head>

<body style="margin:0;padding:0;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
        <tr>
            <td align="center" style="padding:0;">
                <table role="presentation"
                    style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                    <tr>
                        <td align="center" style="padding:40px 0 30px 0;background:#70bbd9;">
                            <img src="{{ asset('img/logo.png') }}" alt="" width="300"
                                style="height:auto;display:block;" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation"
                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td style="color:#153643;">
                                        <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                                            Bonjour {{$user['name']}},</h1>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Vous avez une nouvelle commande du match:
                                        </p>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">

                                            <span style="color: #9ce73c;">
                                                Information du client :
                                            </span>
                                            <hr>
                                            <b>
                                                Nom:
                                            </b>
                                            {{ $commandes['commande']['name'] }}
                                            <br>
                                            <b>
                                                Prénom:
                                            </b>
                                            {{ $commandes['commande']['last_name'] }}
                                            <br>
                                            <b>
                                                email:
                                            </b>
                                            {{ $commandes['commande']['email'] }}
                                            <br>
                                            <b>Référence: </b>
                                            Ref-{{ $commandes['commande']['is_same_time'] }}
                                            <br>
                                        </p>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">

                                            <span style="color: #9ce73c;">
                                                Information de(s) match(s) :
                                            </span>
                                            <hr>
                                            @foreach ($data as $item)
                                                <b>
                                                    Nom du match:
                                                </b>
                                                {{ $item['product']['residence'] }} VS
                                                {{ $item['product']['visitor'] }}
                                                <br>
                                                <b>Type du match: </b>
                                                {{ $item['match_complet'] ? 'Match complet' : '' }}
                                                {{ $item['hight_light'] && $item['match_complet'] ? ' et ' : '' }}
                                                {{ $item['hight_light'] ? 'Hight light' : '' }}
                                                <br>
                                                @if ($item['hight_light'] && array_key_exists('player', $item))
                                                    <b>Nom du joueur: </b>
                                                    {{ $item['player'] }}
                                                    <br>
                                                @endif
                                                <b>
                                                    Date du match:
                                                </b>
                                                {{ $item['product']['date_match'] }}
                                                <br>
                                                <b>
                                                    Numéro de la disque:
                                                </b>
                                                @if (array_key_exists('n_disque', $item['product']))
                                                    {{ $item['product']['n_disque'] }}
                                                @endif
                                                <br>
                                                <hr>
                                            @endforeach
                                            <br>
                                        </p>
                                        <form method="get" class="modal-body">
                                            @csrf
                                            <div
                                                style="margin: 5px 0; display:flex; align-items:center; justify-content: center;">
                                                <a href="{{$link}}" target="_blank" class="btn-btn-primary">
                                                    Envoyer la lien du match
                                                </a>
                                            </div>
                                        </form>
                                        <br><br>
                                        <p>
                                            On vous remercie infiniment pour votre confiance.
                                        </p>
                                        <h3 style="text-align: end;">
                                            Cordialement, <br>Your Soccer Games</h3>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;background:#97db2c;">
                            <table role="presentation"
                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                    <td style="padding:0;width:50%;" align="left">
                                        <p
                                            style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                            &reg; Someone, Somewhere 2023<br /><a href="#"
                                                style="color:#ffffff;text-decoration:underline;">Your Soccer Games</a>
                                        </p>
                                    </td>
                                    <td style="padding:0;width:50%;" align="right">
                                        <table role="presentation"
                                            style="border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a href="http://www.twitter.com/" style="color:#ffffff;"><img
                                                            src="https://assets.codepen.io/210284/tw_1.png"
                                                            alt="Twitter" width="38"
                                                            style="height:auto;display:block;border:0;" /></a>
                                                </td>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a href="http://www.facebook.com/" style="color:#ffffff;"><img
                                                            src="https://assets.codepen.io/210284/fb_1.png"
                                                            alt="Facebook" width="38"
                                                            style="height:auto;display:block;border:0;" /></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
