@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">MİSAFİR İPTALİ</h1>
            <p class="strong">Değerli Migoda Otel Ortağı!</p>
            <p>Maalesef, ücretsiz iptal talebi süresi içinde, Bay(an) [[ guest_name ]] den gelen bir iptal isteği aldık. Misafirler rezervasyon yaptirdiklari [[ date_checkin ]] - [[ date_checkout ]] tarihlerinde otelinize gelmemektedir.</p>
            <p>Lütfen tesis içi rezervasyonunuza genel bakış bilgilerinizi güncelleyin ve bu rezervasyonu silin.</p>
            <p>Teşekkür ederiz!</p>
            <p>Saygilarımızla,</p>
            <p>Migoda Ekibiniz</p>
        </div>
    </td>
</tr>

    @endsection

