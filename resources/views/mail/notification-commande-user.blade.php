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
                                            Bonjour {{ $content['name'] }} {{ $content['last_name'] }},</h1>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Nous vous remercions d'avoir passé commande auprès de notre service. Nous
                                            avons le plaisir de vous informer que votre commande a été validée par notre
                                            équipe administrative. Vous recevrez sous 48 heures un e-mail contenant le
                                            lien de téléchargement unique pour accéder à votre commande match et sous 7
                                            jours pour accéder à votre commande de Hight Light .
                                            <br>
                                            <br>
                                            <b>Référence de la commande: </b>
                                            Ref-{{ $content['is_same_time'] }}
                                            <br>
                                        </p>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            <span style="color: #9ce73c;">
                                                Information de(s) match(s) :
                                            </span>
                                            <hr>
                                            @foreach ($cart as $item)
                                                <b>
                                                    Nom du match:
                                                </b>
                                                {{ $item['residence'] }} VS
                                                {{ $item['visitor'] }}
                                                <br>
                                                <b>Type du match: </b>
                                                {{ $item['complet_match'] ? 'Match complet' : '' }}
                                                {{ $item['hight_light'] && $item['complet_match'] ? ' et ' : '' }}
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
                                                {{ $item['date'] }}
                                                <br>
                                                {{-- <b>
                                                    Numéro de la disque:
                                                </b>
                                                @if (array_key_exists('n_disque', $item))
                                                    {{ $item['n_disque'] }}
                                                @endif --}}
                                                <br>
                                                <hr>
                                            @endforeach
                                            <br>
                                        </p>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            Nous tenons à vous exprimer notre profonde gratitude pour la confiance que
                                            vous accordez à notre entreprise. N'hésitez pas à nous contacter si vous
                                            avez la moindre question ou besoin d'assistance supplémentaire.
                                        </p>
                                        <h3 style="text-align: end;">
                                            Cordialement, <br>L'équipe Your Soccer Games</h3>
                                        <br>
                                        <br>
                                        <p
                                            style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                            NB: les videos seront envoyées par lien de téléchargement ( We transfert ou
                                            My air bridge) Nous préconisons d'installer le lecteur VLC ( version
                                            gratuite ) pour les lire étant donné que ce sont des matchs anciens .
                                        </p>
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
