@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title"> EINGEHENDE <br> BUCHUNGSANFRAGE</h1>
            <p class="strong">Sehr geehrter Hotel Partner!</p>
                Herr/ Frau {{ $name }} hat eine Buchungsanfrage für den Aufenthalt in Ihrem Hotel für die folgenden Daten gesendet: {{ $checkin }}, {{ $checkout }}.
            </p>
            <p> <br>
                Die über das Migoda-Extranet angezeigte Verpflegungspauschale beinhaltet Halbpension zum Tagespreis von {{ $price }} pro Person.
            </p>
            <p>Bitte akzeptieren Sie die Buchung - wenn Sie Verfügbarkeit haben und diese Gäste annehmen möchten.</p> <br>
            <p>Wenn Ihr Haus voll ist, oder Migoda Gäste zu diesem Zeitpunkt aus irgendeinem Grund nicht in Ihr Haus kommen sollen, lehnen Sie bitte die Anfrage ab.</p> <br>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:50px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                    valign="middle"><a href="{{ $route }}"  class="main-button"  target="_blank">AKZEPTIEREN / ABLEHNEN (Taste)</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text">
                * Sie haben 48 Stunden Zeit, um zu antworten!<br>
                Eine schnelle Antwort hilft den Gästen, ihre Reise zu bezahlen und abzuschließen und sich darauf zu freuen, zu Ihnen in Ihr Hotel zu kommen. Wenn Sie nicht innerhalb von 48 Stunden auf die Buchungsanfrage von Mr. {{ $name }} antworten, verlieren Sie diese Gast/Business Gelegenheit für ihr Haus.</p>
        </div>
    </td>
</tr>



    @endsection

