@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">VOTRE PAIEMENT EST EN COURS!</h1>
            <p class="strong">Cher/Chère Partenaire de Migoda Hotel!</p>
            <p>Bonnes nouvelles! ...</p>
            <p>Nous avons émis votre paiement et il est maintenant en cours. Le paiement de xxxxxx € / TL devrait arriver sur votre compte le xx, xx 2019.</p>
            <p>Merci de prendre en considération les week-ends et les jours fériés, le paiement pourrait être retardé à cause des heures d'ouverture.</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#ffffff" role="presentation" style="border:1px solid #6d6f7e;border-radius:10px;cursor:auto;height:25px;padding:10px 25px;background:#ffffff;"
                    valign="middle"><a href="#" style="background:#ffffff;color:#6d6f7e;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;"
                                       target="_blank">Aperçu des gains potentiels</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p>(MOINS DE 18,5% DE COMMISSION MIGODA)</p>
            <p>Si vous avez des questions concernant vos paiements et frais, veuillez contacter <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a></p>
        </div>
    </td>
</tr>
    @endsection

