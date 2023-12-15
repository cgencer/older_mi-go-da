@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">ANNULATION DU <br> CLIENT</h1>
                <p class="strong">Cher(e) partenaire!</p>
                <p>
                    Malheureusement, nous avons reçu une demande d'annulation de Mme / M. {{ $guest}} après la période d'annulation gratuite prévue de 48 heures. Les clients ne pourront pas venir à votre hôtel aux dates réservées du {{ $checkin}} to {{ $checkout }}.
                </p>
 <br>
                <p>Merci de bien vouloir mettre à jour l'aperçu des réservations de votre établissement et Veuillez supprimer cette réservation annulée.</p> <br>
                <p>Étant donné que l'annulation a été effectuée après l'expiration de la période d'annulation gratuite, le paiement a bien été sécurisé et -
                  <span class="strong">Bonne nouvelle! </span>
                    </p> <br>
                <p>We will issue your payout shortly of {{ $amount}} and is due to
                    arrive to your account on {{ $refund}}.</p> <br>
                    <p>
                        Nous émettrons bientôt votre paiement de 50% de {{ $amount}} et il devrait arriver sur votre compte le {{ $refund}}.
                    </p>
                <p>En tenant compte des week-ends et des jours fériés, il se peut que votre paiement arrive par la suite et ce, en raison des horaires bancaires.</p> <br><br>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#ffffff" role="presentation"
                        class="main-button-holder-bg"
                        valign="middle"><a href="{{ $url}}"
                                        class="main-button-bg"
                                        target="_blank">APERÇU DES RECETTES </a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <p>(MINUS THE 18,5% MIGODA COMMISION)</p>
                <p>Si vous avez des questions sur vos paiements ou sur vos frais, veuillez contacter <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
                </p>
            </div>
        </td>
    </tr>

    @endsection

