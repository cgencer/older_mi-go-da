@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Son dakika iptalinizi <br> duyduğumuz için üzgünüz ...</h1>
            <p>Sistemimizde, {{ $reference }} referans numaralı rezervasyonunuz iptal edilmiştir. Gelmeyeceğinizi de otele bildirdik.</p><br>
            <p>Maalesef iptaliniz çok geç kalmıştır ve  <a style="text-decoration: underline">ücretsiz iptal süresini </a>aşmıştır. </p> <br>
            <p>Bu, Kuponlarınızı veya ödemenizi iade edemeyeceğimiz anlamına gelirmektedir.</p> <br>
            <p>
                Umarız yakında bizimle başka bir yolculuk düzenleyebilirsiniz!
            </p>
            <br><br>
            <p><strong>Migoda Ekibiniz</strong></p> <br><br><br><br>
        </div>
    </td>
</tr>
    @endsection

