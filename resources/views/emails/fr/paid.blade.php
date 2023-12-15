@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">BONNES NOUVELLES - VOUS AVEZ DES CLIENTS QUI ARRIVENT!</h1>
            <p class="strong">Cher Partenaire!!</p>
            <p>
                Nous sommes heureux de vous informer que le client a bien payé son forfait-repas et qu'il/elle séjournera dans votre établissement et ce pour la/Les date(s) du {{ $checkin }} to {{ $checkout }}. (Réf. {{ $checkout }}).
            </p><br>
            <p>À moins d'une annulation imprévue de la part du client et ce 48 heures avant l'arrivée à votre établissement, nous paierons ce qui suit:</p> <br>
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
                    valign="middle"><a href="{{ $route }}"
                                       class="main-button-bg"
                                       target="_blank">APERÇU DES GAINS</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
          <br>  <p>...(MINUS THE 18,5% MIGODA COMMISION)</p> <br>
            <p>Si vous avez des questions sur vos paiements ou sur vos frais, veuillez contacter <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
            </p>
        </div>
    </td>
</tr>
    @endsection

