@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GUTE NACHRICHTEN - IHRE GÄSTE KOMMEN!</h1>
            <p class="strong">Sehr geehrter Migoda Hotel Partner!</p>
            <p>
                Wir freuen uns, Ihnen mitteilen zu können, dass der Gast die Verpflegungspauschale für den Aufenthalt vom {{ $checkin }} bis {{ $checkout }} bezahlt hat und sich freut zu Ihnen zu kommen. (Ref. {{ $code }}).
            </p><br>
            <p>Sofern es nicht zu einer unvorhergesehenen Stornierung von Seiten des Gastes 48 Stunden vor seiner Ankunft in Ihrem Hause kommt, zahlen wir Folgendes aus:</p> <br>
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
                                       target="_blank">ÜBERSICHT DER EINNAHMEN</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
          <br>  <p>...(MINUS THE 18,5% MIGODA COMMISION)</p> <br>

            <p>  Wenn Sie Fragen zu Ihren Auszahlungen oder den Gebühren haben, wenden Sie sich bitte an <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
            </p>
        </div>
    </td>
</tr>
    @endsection

