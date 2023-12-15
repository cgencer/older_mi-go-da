@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">"Het spijt ons te horen over uw last minute annulering ...</h1>
            <p>Uw boeking met referentienummer {{ $reference }} is geannuleerd in ons systeem. Wij hebben het hotel ook geïnformeerd dat u niet zult komen.</p> <br>
            <p>Helaas is uw annulering erg laat <a style="text-decoration: underline">- eigenlijk te laat - </a> en voorbij de gratis annuleringsperiode.  </p> <br>

            <p>Dit betekent dat wij uw coupons en uw betaling niet kunnen terugbetalen.</p> <br>

            <p>
                Hopelijk kunt u snel een andere reis bij ons boeken!
            </p>

            <br><br>
            <p><strong>Uw Migoda Team</strong></p> <br><br><br><br>
        </div>
    </td>
</tr>
    @endsection

