@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">INKOMEND <br> BOEKINGSAANVRAAG</h1>
            <p class="strong">Beste Hotel partner!</p>

                De heer/mevrouw {{ $name }}  heeft een boekingsaanvraag verzonden om in uw hotel te verblijven voor de volgende data: {{ $checkin }} / {{ $checkout }}
            </p><br>
            <p>
                Het maaltijdpakket dat u via het Migoda Extranet hebt weergegeven, omvat halfpension met een dagprijs van {{ $price }} per persoon.
            </p><br>
            <p>Volgens uw beheerde agenda in uw Extranet account, toont u die data beschikbaar.</p> <br>
            <p>Accepteert u alstublieft de boeking, als u beschikbaarheid heeft en deze gasten zou willen aannemen.</p> <br>
            <p>IAls uw hotel vol is, of op dit moment kunnen Migoda gasten om welke reden dan ook niet worden geaccepteerd, wijs dan alstublieft deze boeking af..</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:50px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                    valign="middle"><a href="{{ $route }}"  class="main-button"  target="_blank">ACCEPTEREN / AFWIJZEN</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text">
                * U heeft 48 uur om te reageren! <br>
                "Een snelle reactie helpt gasten om hun reis te betalen en af te ronden en zich te verheugen op hun komst naar uw hotel. Als u niet binnen 48 uur op de boekingsaanvraag van de heer/mevrouw {{ $name }}  reageert, verliest u deze gast/bedrijfskans.
                "</p>
        </div>
    </td>
</tr>

    @endsection

