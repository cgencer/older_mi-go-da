@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">ANNULERING <br> DOOR GAST</h1>
                <p class="strong">Beste Hotel partner!</p>
                <p>
                    Helaas hebben wij een annuleringsverzoek ontvangen van de heer/mevrouw {{ $guest}}, na de gratis annuleringsverzoek periode van 48 uur voor aankomst van de gast. De gasten komen niet naar uw hotel op de gereserveerde data {{ $checkin}} to {{ $checkout }}.
                </p>
                <p>Wij verzoeken u uw interne reserveringsoverzicht bij te werken en deze reservering te verwijderen.     </p> <br>

                <p>Omdat de annulering voorbij de gratis annuleringsperiode is, is de betaling veiliggesteld.  <span class="strong">Goed nieuws! </span>
                    ...</p> <br>
                    <p>
                        Wij zullen uw uitbetaling van 50% van {{ $amount}} binnenkort uitvoeren en zal op {{ $refund}} op uw rekening verschijnen.
                    </p>
                <p>Rekening houdend met weekenden en feestdagen kan de uitbetaling door bankuren later aankomen.</p> <br><br>
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
                                        target="_blank">OVERZICHT VAN INKOMSTEN</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <p>(MINUS THE 18,5% MIGODA COMMISION)</p>
               <p>Als u vragen heeft over uw uitbetalingen of vergoedingen, neem dan contact op met <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
                </p>
            </div>
        </td>
    </tr>

    @endsection

