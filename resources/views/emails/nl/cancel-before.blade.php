@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">ANNULERING <br> DOOR GAST</h1>
            <p class="strong">Beste Hotel partner,</p>
            <p>
                Helaas hebben wij een annuleringsverzoek ontvangen van de heer/mevrouw {{ $guest }} binnen de gratis annuleringsverzoek periode. De gast(en) komen niet naar uw hotel op de gereserveerde data {{ $checkin}} to {{ $checkout }}.
            </p>
            <p>Wij verzoeken u uw interne reserveringsoverzicht bij te werken en deze reservering te verwijderen.</p> <br>
            <p>Dank u!</p><br>
            <p>Met vriendelijke groet,</p> <br>
            <p><strong>Uw Migoda Team!</strong></p> <br><br>
        </div>
    </td>
</tr>
    @endsection

