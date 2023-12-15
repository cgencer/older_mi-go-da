

@extends('emails.layouts.master-hotel')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="title-h1">Was machen wir? - Wir helfen Ihnen, Ihre UNVERKAUFTEN Zimmer zu füllen!</h1>
            <h4 class="title-h4">
                @if ($gender == "f")
                     Sehr geehrte Frau {{ $name }}
                @else
                     Sehr geehrter Herr {{ $name }}
                @endif
                <br>
                Wir haben SIE ausgewählt, ein Teil unserer Familie zu sein! <br>
                Sie haben nichts zu verlieren - nur zu GEWINNEN! <br>
            </h4>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
                <h2 class="title-h2"> Wie füllen wir Ihre nicht verkauften Zimmer?</h2>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
            <p class="paragraph">
                Sie erklären sich damit einverstanden, uns Ihre nicht verkauften Zimmer kostenlos zur Verfügung zu stellen, und wir füllen Ihr Haus mit reisebereiten Gutschein Inhabern - die sich bereit erklären, eine von Ihnen auf unserem digitalen Marktplatz <a target="_blank" rel="noopener noreferrer" href="https://migoda.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migoda.com</a> angebotene Verpflegungspauschale zu bezahlen.
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
                            Wie Sie vielleicht bereits wissen - gibt es einige Unternehmen, die ein ähnliches Modell anbieten, aber wir sind jetzt das erste Unternehmen - vollständig digital mit einem internationalen Publikum. Bitte lesen Sie unsere E-Broschüre, um mehr über uns zu erfahren - und verstehen Sie, wie einfach Ihre Teilnahme an diesem Win-Win-Geschäftsmodell ist!
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
                                Selbstverständlich finden Sie auch all diese Informationen auf unserer Website <a target="_blank" rel="noopener noreferrer" href="https://migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migodahotels.com</a>.
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
                              <p class="paragraph">  Wir möchten Sie einladen, Teil unserer Familie zu sein, und haben bereits mit viel LIEBE Ihr Konto sowie Ihr Profil in unserem Extranet-System erstellt. Bitte klicken Sie hier, um es anzuzeigen …</p>
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
                                    Wir hoffen sehr, dass Ihnen das, was wir geschaffen haben, gefällt und wir wären Ihnen sehr dankbar, wenn Sie sich uns anschließen würden.<br>
                                    Dafür müssen Sie nur zustimmen und unseren <a href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">Dienstleistungsvertrag</a>  unterschreiben.
                                </p>
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
                    <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn4.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br><br>
                <p class="paragraph">
                             Sie können den unterschriebenen Vertrag entweder im Dashboard/ Dokumentenbereich Ihres Extranetbereichs hochladen, per Fax (F. +49 40 228 200 169) oder auch per eingescannter E-Mail (<a href="mailto:register@migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">register@migodahotels.com</a>) an uns senden.
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
                    Wir sind immer für Sie da, um Sie mit unserem Wissen zu unterstützen - sei es geschäftliche, digitale Fragen oder einfach nur wie Sie einige Teile Ihres Profils verbessern können.  <br><br>

                    Zögern Sie bitte nie, uns zu kontaktieren.  <br><br>

                    Mit den herzlichsten Grüßen für eine schöne gemeinsame Reise und Zusammenarbeit,<br><br><br>

                    <b>Ihr Migoda Team</b><br>
                    Gründer &amp;  CEO
                </p ></b><br></b><br>

        </div>
    </td>
</tr>



@endsection
