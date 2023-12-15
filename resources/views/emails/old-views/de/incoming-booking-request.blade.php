@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">EINGEHENDE <br> BUCHUNGSANFRAGE</h1>
            <p class="strong">Sehr geehrter Migoda Hotel Partner!</p>
            <p>Herr/Frau [[ guest_name ]] hat eine Buchungsanfrage für den folgenden Termin in Ihrem Hotel gesendet: [[ date_checkin ]] bis [[ date_checkout ]]. Die im Migoda Extranet angezeigte Verpflegungspauschale beinhaltet Halbpension mit einem Tagespreis von &euro; [[ nightly_price ]] / pro Person.</p>
            <p>In Ihrem Migoda Konto Extranet-Kalender zeigen Sie diese Daten als verfügbar an.</p>
            <p>Bitte akzeptieren Sie diese Buchung - wenn Sie Verfügbarkeit haben und diese Gäste annehmen möchten!</p>
            <p>Wenn Ihr Haus voll ist - oder Migoda-Gäste aus irgendeinem Grund nicht kommen sollen - lehnen Sie dies Buchung bitte ab.</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"   valign="middle"><a href="#" class="main-button"   target="_blank">Akzeptieren / Ablehnen</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text-red">* Sie haben 48 Stunden, um zu antworten!</p>
            <p class="note-text">Eine schnelle Antwort hilft den Gästen, ihre Reise abzuschließen und sich zu freuen, Ihr Hotel zu besuchen. Wenn Sie nicht innerhalb von 48 Stunden auf diese Buchungsanfrage reagieren, verlieren Sie diesen Gast als auch diese Geschäftsmöglichkeit.</p>
        </div>
    </td>
</tr>
    @endsection

