@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GOED NIEUWS - UW GASTEN KOMEN!</h1>
            <p class="strong">Beste Migoda Hotel Partner!</p>

                We zijn blij om u te laten weten dat de gast heeft betaald voor het maaltijdpakket voor de datum(s) van {{ $checkin }} to {{ $checkout }}  en kijkt uit naar een verblijf bij u! (Ref {{ $code }} ).
            </p><br>
            <p>Tenzij er een onvoorziene annulering door de gast plaatsvindt 48 uur voor aankomst bij uw hotel, zullen wij het volgende uitbetalen:</p> <br>
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
                    valign="middle"><a href="{{ $route }}"
                                       class="main-button-bg"
                                       target="_blank">OVERZICHT VAN İNKOMSTEN</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
          <br>  <p>...(MINUS THE 18,5% MIGODA COMMISION)</p> <br>
            <p>Als u vragen heeft over uw uitbetalingen of vergoedingen, neem dan contact op met  <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
            </p>
        </div>
    </td>
</tr>
    @endsection

