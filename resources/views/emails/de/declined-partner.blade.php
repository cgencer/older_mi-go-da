@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">BESTÄTIGUNG <br> ABGELEHNT</h1>
                <p class="strong">Sehr geehrter Migoda Hotel Partner!</p>
                    Wir haben von Ihnen Ihre Ablehnung der Buchungsanfrage von {{ $name }}’s mit den Daten vom {{ $checkinCustomer }} bis {{ $checkoutCustomer }} erhalten. (Ref. {{ $code }}). Wir haben Ihre Absage {{ $name }}’s bereits über unser System mitgeteilt.
                </p> <br>
                <p>Bitte achten Sie darauf, Ihren Extranet-Kalender immer zu verwalten, um Kundenenttäuschungen bei Terminanfragen für Ihr Haus zu vermeiden. Vielen Dank!</p> <br><br>
                    <p>
                        Mit freundlichen Grüßen,
                    </p> <br>
                    <p style="font-weight: 600">Ihr Migoda-Team!</p> <br><br>
            </div>
        </td>
    </tr>
    @endsection

