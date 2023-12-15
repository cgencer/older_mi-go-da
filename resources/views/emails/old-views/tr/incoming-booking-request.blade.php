@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GELEN REZERVASYON <br> TALEBİ</h1>
            <p class="strong">Değerli Migoda Otel Ortağı!</p>
            <p>Bay(an) [[ guest_name ]], aşağıdaki tarihlerde otelinizde kalmak için bir rezervasyon isteği gönderdi: [[ date_checkin ]] - [[ date_checkout ]]. Migoda Extranet aracılığıyla sunduğunuz yemek ödeneği, Yarım-Pansiyon kişi başı günlük [[ nightly_price ]] TL dir. </p>
            <p>Extranet hesabınızda düzenlenen takviminize göre, bu tarihler müsait.</p>
            <p>Eğer müsaitlik durumunuz varsa ve bu konukları almak istiyorsanız -Lütfen rezervasyonu kabul edin!</p>
            <p>Eğer oteliniz dolu ise  - ya da bu noktada Migoda misafirleri herhangi bir sebepten dolayı gelemezlerse - lütfen reddediniz.</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                valign="middle"><a href="#" class="main-button"  target="_blank">Kabul Et / Reddet</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text-red">* Yanıt vermek için 48 saatiniz var!</p>
            <p class="note-text">Hızlı yanıt, misafirlerin seyahatlerini netleştirmelerine yardımcı olur ve otelinize gelmeyi dört gözle beklerler. Rezervasyon isteğine 48 saat içinde cevap vermezseniz, bu misafir / iş fırsatını kaybedersiniz.</p>
        </div>
    </td>
</tr>
    @endsection

