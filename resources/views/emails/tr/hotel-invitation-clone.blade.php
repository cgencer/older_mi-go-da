

@extends('emails.layouts.master-hotel')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="title-h1">Ne yapıyoruz? Dönem için SATILMAYAN odalarınızı doldurmanıza yardım ediyoruz!</h1>
            <h4 class="title-h4"> Sayın {{ $name }} <br>
                SİZLERİ Migoda ailesinin bir parçası olmanızın için seçtik. <br>
                Kaybedek hiçbir şeyiniz yok, sadece KAZANACAKSINIZ. <br>
            </h4>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
                <h2 class="title-h2"> Dönem içi satılmayan odalarınızı nasıl dolduruyoruz?</h2>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
            <p class="paragraph">
                Dönem içi satılmayan odalarınızı bizlere ücretsiz veriyorsunuz. Bizler de seyahat etmeye hazır Migoda kupon sahiplerinin,  ücretsiz odanıza karşılık sizin sunduğunuz bir yemek paketini  dijital pazar yeri olan <a target="_blank" rel="noopener noreferrer" href="https://migoda.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migoda.com</a>'dan satın almasını sağlıyoruz.
            </p>
            <br>
            <br>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                <tbody>
                    <tr style="padding:0;vertical-align:top;">
                        <td class="eclipse-holder holder-1"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                            <span class="eclipse">01</span>
                        </td>
                        <td height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                         <p class="paragraph">
                            Bildiğiniz üzere, geçmişte benzeri modellerini sunan şirketler oldu. Migoda, tamamen uluslara arası bir kitleye hizmet veren ilk dijital platforumdur. Lütfen bizleri tanımak için aşağıdaki e-broşürümüzü inceleyip, kazan-kazan modeline dayanan platformumuza katılmanın ne kadar kolay olduğuna biz göz atın.
                        </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
        </div>
    </td>
</tr>

<tr style="padding:0;vertical-align:top;text-align:left;">
        <td style="font-size:0px;padding:10px 80px 20px 165px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <table style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;">
                <tbody>
                <tr style="padding:0;vertical-align:top;text-align:left;">
                    <td style="">
                        <a target="_blank" rel="noopener noreferrer" href="https://meet.google.com/yta-hvwr-bym" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn1.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:block;border:none;"></a>
                    </td>
                    <td style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td style="">
                        <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migoda-brochure-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn2.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:block;border:none;"></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                <tbody>
                    <tr style="padding:0;vertical-align:top;text-align:left;">
                        <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">

                        </td>
                        <td  height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                            <br><br>
                            <p class="paragraph">
                                Bu bilgilere, elbette <a target="_blank" rel="noopener noreferrer" href="https://migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migodahotels.com</a>  adresindeki web sitemizden de ulaşabilirsiniz. <br><br>
                            </p>
                            <br>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">

        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                    <tbody>
                        <tr style="padding:0;vertical-align:top;text-align:left;">
                            <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                                <span class="eclipse">02</span>
                            </td>
                            <td  height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                              <p class="paragraph">  Sizleri Migoda ailesinin bir parçası olmaya davet ediyoruz. Hesabınızı özen ve sevgiyle hazırladık, extranet üzerinizdeki profilinize ulaşmak için tıklayın ...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>

<tr>
    <td align="right" style="font-size:0px;padding:10px 110px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ $url }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn3.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                    <tbody>
                        <tr style="padding:0;vertical-align:top;text-align:left;">
                            <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                                <span class="eclipse">03</span>
                            </td>
                            <br>
                            <td height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                                <p class="paragraph">
                                    Umarız ki, hazırladıklarımızı beğendiniz. Migoda'ya katılmanız bizleri çok memnun edecektir.   <br> Katılım için <a href="" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"> hizmet sözleşmesini</a> indirip imzalamanız yeterlidir.  .
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>


<tr>
    <td align="right" style="font-size:0px;padding:10px 122px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn4.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br><br>
                <p class="paragraph">
                        Lütfen sözleşmeyi paneldeki doküman yönetimi üzerinden ve ya  e-posta yoluyla <a href="mailto:register@migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">register@migodahotels.com</a> adresine ya da faks olarak +49 40 228 200 169'a gönderiniz.
                            </p>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">

                <p class="paragraph">
                    Sizlere destek olmak için daima yanınızdayız. İşinize dair ve ya dijital konularda ya da profilinizi iyileştirmemiz için iletişime geçebilirsiniz. <br><br>

                    Bizlere ulaşmaktan çekinmeyiniz.  <br><br>

                    En içten saygılarımla, beraberce işbirliği için çıktığımız bu yolculukta. en içten saygılaırmla,  <br><br><br>

                    Migoda Ekibi <br><br>

                    <b>Mischeila Golla</b><br>
                    Kurucu ve CEO
                </p ></b><br></b><br>

        </div>
    </td>
</tr>



@endsection
