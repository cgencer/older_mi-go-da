@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">İYİ HABER - GELECEK MİSAFİRLERİNİZ VAR!</h1>
            <p class="strong">Değerli Migoda Otel Partneri!</p>

            <p>
                {{ $checkin }} - {{ $checkout }} tarihileri arası konaklayacak misafiriniz, yemek paketi için ödeme yaptığını bildirmekten mutluluk duyuyoruz. Misafrimiz de otelinize gelmeyi dört gözle bekliyor.(Ref:  {{ $code }} )
            </p><br>
            <p>Otelinize gelmeden 48 saat önce müşteri adına öngörülmeyen bir iptal olmadıkça - aşağıdakileri ödeyeceğiz:</p> <br>
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
                                       target="_blank">KAZANCINIZA GENEL BAKIŞ</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
          <br>  <p>...(MINUS THE 18,5% MIGODA COMMISION)</p> <br>
            <p>Ödemeleriniz ve ücretlerinizle ilgili herhangi bir sorunuz varsa, lütfen <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a> ile iletişime geçiniz.
            </p>
        </div>
    </td>
</tr>
    @endsection

