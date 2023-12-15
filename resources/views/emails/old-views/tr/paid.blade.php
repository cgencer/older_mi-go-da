@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">İYİ HABER</h1>
            <h2 class="header-subtitle">GELECEK MİSAFİRLERİNİZ VAR!</h2>
            <p class="strong">Değerli Migoda Otel Ortağı!</p>
            <p>Otelinizde [[ date_checkin ]] - [[ date_checkout ]] tarihileri arası konaklayacak misafirin, yemek paketi bölümü için ödeme yaptığını bildirmekten mutluluk duyuyoruz.</p>
            <p>Otelinize gelmeden 48 saat önce müşteri adına öngörülmeyen bir iptal olmadıkça - aşağıdakileri ödeyeceğiz:</p>
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
                                       target="_blank">Potansiyel Kazançlara Genel Bakış</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p>(EKSİ %18,5 MİGODA KOMİSYONU)</p>
            <p>Ödemeleriniz ve ücretlerinizle ilgili herhangi bir sorunuz varsa, lütfen <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a> ile iletişime geçin.</p>
        </div>
    </td>
</tr>
    @endsection

