@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">BEVESTİGİNG VAN <br> AFWIJZING</h1>
                <p class="strong">Beste Migoda Hotel Partner!</p>
                    Wij hebben uw afwijzing ontvangen voor{{ $name }}s boekingsaanvraag met de data {{ $checkinCustomer }} tot {{ $checkoutCustomer }}. (Ref. {{ $code }}). Wij hebben deze afwijzing al via ons systeem aan {{ $name }} meegedeeld.
                </p> <br>
                <p>Zorg ervoor dat u altijd uw Êxtranet kalender beheert, om teleurstellingen van klanten over datumverzoeken voor uw hotel te voorkomen. Dank u!</p> <br><br>
                    <p>
                        Met vriendelijke groet,
                    </p><br>
                    <p style="font-weight: 600">Your Migoda Team</p> <br><br>
            </div>
        </td>
    </tr>
    @endsection

