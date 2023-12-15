@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">APPROVAL <br> CONFIRMATION</h1>
            <p class="strong">Değerli Migoda Otel Ortağı!</p>
            <p>Bay(an) [[ guest_name ]]'in, [[ date_checkin ]] - [[ date_checkout ]] tarihleri için yaptığı rezervasyon talebinin kabul ettiğinizi bildirdiniz. Kabulünüzü, Bay(an) [[ guest_name ]]'e sistemimiz aracılığıyla ilettik.</p>
            <p>Memnun olduk! Müşteri de öyle!</p>
            <p>Önümüzdeki 48 saat içinde, müşterilerin talep ettikleri tarihler için ödemeleri hakkında sizi bilgilendiren başka bir e-posta alacaksınız.</p>
            <p>Sizi haberdar edeceğiz! .. takipte kalın!</p>
            <p>Saygilarımızla,</p>
            <p style="font-weight: 600">Migoda Ekibiniz</p>
        </div>
    </td>
</tr>
    @endsection

