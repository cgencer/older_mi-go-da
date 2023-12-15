@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">APPROVAL <br> CONFIRMATION</h1>
            <p class="strong">Lieber Migoda Hotel Partner!</p>
            <p>Wir haben von Ihnen Ihre akzeptierte Buchungsanfrage von Herrn [[ guest_name ]] mit den Daten [[ date_checkin ]] - [[ date_checkout ]] erhalten. Diese Buchungsbestätigung haben wir Herrn [[ guest_name ]] schon durch unser System mitgeteilt.</p>
            <p>Wir sind sehr erfreut! So ist der Gast!</p>
            <p>Innerhalb der nächsten 48 Stunden erhalten Sie eine weitere E-Mail von uns, die Sie über die Zahlung des Kunden für die angefragten Zeiten informiert.</p>
            <p>Wir halten Sie auf dem Laufenden! Bleiben Sie dran!</p>
            <p>Mit freundlichen Grüßen,</p>
            <p style="font-weight: 600">Ihr Migoda Team</p>
        </div>
    </td>
</tr>
@endsection

