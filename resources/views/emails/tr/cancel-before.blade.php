@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">MİSAFİR <br> İPTALİ</h1>
            <p class="strong">Değerli Migoda Otel Partneri!</p>
            <p>Maalesef, ücretsiz iptal talebi süresi içinde, Bay(an) {{ $guest }} den gelen bir iptal isteği aldık. Misafirler rezervasyon yaptirdiklari {{ $checkin}} - {{ $checkout }} tarihlerinde otelinize gelememektedir.</p>
            <p>Lütfen tesis içi rezervasyonlarınızı gözden geçirip güncelleyiniz ve bu rezervasyonu siliniz.</p> <br>
            <p>Teşekkür ederiz!</p><br>
            <p>Saygılarımızla,</p> <br>
            <p><strong>Migoda Ekibiniz!</strong></p> <br><br>
        </div>
    </td>
</tr>
    @endsection

