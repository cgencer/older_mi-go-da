@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Désolé d'entendre parler de <br> votre annulation de dernière minute ...</h1>
            <p>Votre réservation sous le numéro de référence suivant {{ $reference }} a été annulée de notre système. Nous avons aussi informé l'hôtel que vous n'allez pas venir.</p><br>
            <p>Malheureusement, votre annulation est très tardive  <a style="text-decoration: underline">- en fait trop tardive -</a> et au-delà de la période d'annulation gratuite. </p> <br>
            <p>Cela signifie que nous ne pouvons pas rembourser vos coupons ni votre paiement.</p> <br>

            <p>
                Nous espérons que vous pourrez bientôt réserver un voyage avec nous!
            </p>

            <br><br>
            <p><strong>Votre Équipe-Migoda</strong></p> <br><br><br><br>
        </div>
    </td>
</tr>
    @endsection

