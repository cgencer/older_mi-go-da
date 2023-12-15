@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">RED BİLGİSİ - TEYİDİ</h1>
                <p class="strong">Değerli Migoda Otel Partneri!</p>
                <p>
                    {{ $checkinCustomer }} - {{ $checkoutCustomer }} tarihleri arasında {{ $name }}'in yaptığı (Ref: {{ $code }}) rezervasyon talebinin reddini bildirdiniz. Reddinizi,  {{ $name }} isimli misafir(ler)e sistemimiz aracılığıyla ilettik.
                </p> <br>
                <p>Oteliniz için talep edilen tarihlerde müşteri hayal kırıklıklarını önlemek için, lütfen Extranet Takviminizi her zaman düzenlediğinizden emin olunuz. Teşekkür ederiz!</p> <br><br>
                    <p>
                        Saygilarımızla,
                    </p> <br>
                    <p style="font-weight: 600">Migoda Ekibiniz!</p> <br><br>
            </div>
        </td>
    </tr>
    @endsection

