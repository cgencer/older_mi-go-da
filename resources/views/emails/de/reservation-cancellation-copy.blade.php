@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Tut uns leid, von Ihrer <br> Stornierung in letzter Minute zu erfahren ...</h1>
            <p>Ihre Buchung mit der Referenznummer  {{ $reference }} wurde in unserem System storniert. Wir haben das Hotel darüber informiert, dass Sie nicht kommen werden.</p><br>
            <p>Leider ist Ihre Stornierung sehr spät <a style="text-decoration: underline">- tatsächlich zu spät -</a> und hat die kostenlose Stornierungsfrist überschritten.  </p> <br>
            <p>Dies bedeutet, dass wir weder Ihre Gutscheine noch Ihre Zahlung zurückerstatten können.</p> <br>

            <p>
                Dies bedeutet, dass wir weder Ihre Gutscheine noch Ihre Zahlung zurückerstatten können.
            </p>

            <br><br>
            <p><strong>Ihr Migoda Team</strong></p> <br><br><br><br>
        </div>
    </td>
</tr>
    @endsection

