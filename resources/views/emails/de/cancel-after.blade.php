@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">STORNIERUNG VON <br> SEITEN DES GASTES</h1>
                <p class="strong">Sehr geehrtes Partnerhotel!</p>
                <p>
                    Leider haben wir nach der kostenfreien Widerrufsfrist eine Stornierung von Herrn {{ $guest }} erhalten. Die Gäste kommen zu den reservierten Terminen{{ $checkin}} to {{ $checkout }} nicht zu Ihnen ins Hotel.
                </p>
                <p>Bitte aktualisieren Sie Ihre interne Reservierungsübersicht und löschen Sie diese Buchung daraus.</p> <br>
                <p>Da die Stornierung nach Ablauf der kostenlosen Stornierungsfrist erfolgt ist, ist die Zahlung gesichert und <span class="strong">eine gute Nachricht</span>
                    ...</p> <br>

                <p>Ihre 50%ige Auszahlung in Höhe von {{ $amount}} erfolgt in Kürze und wird am {{ $refund}} auf Ihrem Konto eingehen.</p>
                <p>Unter Berücksichtigung von Wochenenden und Feiertagen kann dies aufgrund von Bankzeiten später eintreffen.</p> <br><br>
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
                        valign="middle"><a href="{{ $url}}"
                                        class="main-button-bg"
                                        target="_blank">ÜBERSICHT DER  EINNAHMEN</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <p>(MINUS THE 18,5% MIGODA COMMISION)</p>
                <p>Bei Fragen zu Auszahlungen und Gebühren wenden Sie sich bitte an <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>

                </p>
            </div>
        </td>
    </tr>

    @endsection

