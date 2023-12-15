@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">MİSAFİR <br> İPTALİ</h1>
                <p class="strong">Değerli Migoda Otel Partneri!</p>
                <p>
                    Maalesef, konukların varışından 48 saat önce ücretsiz iptal talebi süresi geçtikten sonra Bay(an) {{ $guest }} (ler) den bir iptal talebi aldık. Misafirler{{ $checkin}} - {{ $checkout }}tarihleri arasında otelinize gelememektedir.
                </p><br>

                <p>Lütfen tesis içi rezervasyonunuza genel bakış bilgilerinizi güncelleyin ve bu rezervasyonu silin.</p> <br>
                <p>İptal, ücretsiz iptal dönemini geçtiği için ödeme güvence altına alınmıştır ve  <span class="strong">İyi haber!</span> </p> <br>
                <p>{{ $amount}}  tutarındaki %50 ödemenizi kısa süre içinde yapacağız ve hesabınıza {{ $refund }} tarihinde ulaşacak.</p>
                <p>Hafta sonları ve tatil günleri göz önüne alındığında ki banka saatleri nedeniyle ödemeniz geç gelebilir.</p> <br><br>
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
                        valign="middle"><a href="{{ $url}}"
                                        class="main-button-bg"
                                        target="_blank">KAZANÇLARA GENEL BAKIŞ / KAZANÇ ÖZETİ</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <p>(MINUS THE 18,5% MIGODA COMMISION)</p>
                <p>Ödemeleriniz ve ücretlerinizle ilgili herhangi bir sorunuz varsa, lütfen <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>  ile iletişime geçin.
                </p>
            </div>
        </td>
    </tr>

    @endsection

