@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title"> GELEN <br> REZERVASYON TALEBİ</h1>
            <p class="strong">Değerli Migoda Otel Ortağı!</p>
            <p>
                Bay(an) {{ $name }} , aşağıdaki tarihlerde otelinizde kalmak için bir rezervasyon isteği gönderdi: {{ $checkin }} - {{ $checkout }}.
            </p><br>
            <p>
                Migoda Extranet aracılığıyla sunduğunuz yemek ödeneği, Yarım-Pansiyon kişi başı günlük {{ $price }} dir.
            </p>

            <p>Extranet hesabınızda düzenlenen takviminize göre, bu tarihler müsait.</p> <br>
            <p>Eğer müsaitlik durumunuz varsa ve bu konukları almak istiyorsanız -Lütfen rezervasyonu kabul ediniz!</p> <br>
            <p>Eğer oteliniz dolu ise  - ya da bu aşamada Migoda misafirlerini herhangi bir sebepten dolayı kabul edemiyorsanız - lütfen bu rezervasyonu reddediniz.</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:50px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                    valign="middle"><a href="{{ $route }}"  class="main-button"  target="_blank">Kabul Et / Reddet</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text">
                * Yanıt vermek için 48 saatiniz var! <br>
                Hızlı yanıt, misafirlerin seyahatlerini netleştirmelerine yardımcı olur ve otelinize gelmeyi dört gözle beklerler. Rezervasyon isteğine 48 saat içinde cevap vermezseniz, bu misafir / iş fırsatını kaybedersiniz.</p>
        </div>
    </td>
</tr>

    @endsection

