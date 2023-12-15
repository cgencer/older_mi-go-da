@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GUTE NACHRICHT</h1>
            <h2 class="header-subtitle">SIE HABEN GÄSTE, DIE KOMMEN!</h2>
            <p class="strong">Lieber Migoda Hotel Partner!</p>
            <p>Wir freuen uns, Ihnen mitteilen zu können, dass der Gast die Verpflegungspauschale für den Aufenthalt vom [[ date_checkin ]] bis [[ date_checkout ]] bei Ihnen bezahlt hat.</p>
            <p>Wenn keine unvorhergesehene Stornierung bis 48 Stunden vor Ankunft des Gastes in Ihrem Hotel erfolgt, zahlen wir Ihnen Folgendes:</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#ffffff" role="presentation"
                    style="border:1px solid #6d6f7e;border-radius:10px;cursor:auto;height:25px;padding:10px 25px;background:#ffffff;"
                    valign="middle"><a href="#"
                                       style="background:#ffffff;color:#6d6f7e;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;"
                                       target="_blank">Überblick über mögliche Einnahmen</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p>(Minus der 18,5% -Migoda-Kommission)</p>
            <p>Bei Fragen zu Auszahlungen und Gebühren wenden Sie sich bitte an <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a></p>
        </div>
    </td>
</tr>
    @endsection
