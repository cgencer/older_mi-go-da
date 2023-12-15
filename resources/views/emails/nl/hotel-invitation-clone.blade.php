

@extends('emails.layouts.master-hotel')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="title-h1">Wat doen we - Wij zullen u helpen uw ONVERKOCHTE kamers te vullen!</h1>
            <h4 class="title-h4">
                @if ($gender == "f")
                    Beste mevrouw {{ $name }}
                    @else
                    Beste Heer {{ $name }}
                @endif
                <br>
                We kozen UW om deel uit te maken van onze familie! <br>
                U heeft niets te verliezen - alleen maar te WINNEN! <br>
            </h4>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
                <h2 class="title-h2"> Hoe vullen we uw onverkochte kamers?</h2>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
            <p class="paragraph">
                <a target="_blank" rel="noopener noreferrer" href="https://migoda.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migoda.com</a>.
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
                            Zoals u misschien al weet - er zijn enkele bedrijven die een soortgelijk model aanbieden - maar we zijn nu het eerste bedrijf - volledig digitaal met een internationaal publiek. Lees onze e-brochure voor meer informatie over ons - en begrijp hoe gemakkelijk het is om deel te nemen aan dit win-win bedrijfsmodel!
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
                                Natuurlijk kunt u al deze informatie ook vinden op onze website <a target="_blank" rel="noopener noreferrer" href="https://migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migodahotels.com</a>.<br><br>
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
                              <p class="paragraph">  Omdat we je uitnodigen om deel uit te maken van onze familie, hebben we met veel LIEFDE je account en je profiel in ons Extranet-systeem gemaakt. Klik hier om het te bekijken ...</p>
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
                                    Wij hopen van harte dat u geniet van wat wij hebben gecreëerd en wij zouden u zeer dankbaar zijn als u zich bij ons zou willen aansluiten. <br>
                                    Daarvoor hoeft u alleen maar akkoord te gaan en uw <a href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">accommodatiecontract</a> te ondertekenen.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>


<tr>
    <td align="right" style="font-size:0px;padding:10px 135px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
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
                                  U kunt het ondertekende contract uploaden in de rubriek dashboard/ documenten van uw extranet, het ons toezenden per fax (F. +49 40 228 200 169) of ook per gescande e-mail (<a href="mailto:register@migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">register@migodahotels.com</a>).
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
                    We zijn er altijd voor u om u te ondersteunen met onze kennis - of het nu zakelijke, digitale vragen zijn of gewoon hoe u sommige delen van uw profiel kunt verbeteren. <br><br>

                    Aarzel niet om contact met ons op te nemen.   <br><br>

                    Met de hartelijke groeten voor een leuke reis en samenwerking, <br><br><br>

                    Uw Migoda Team <br> <br>

                    <b>Mischeila Golla</b><br>
                    Founder &amp; CEO
                </p ></b><br></b><br>

        </div>
    </td>
</tr>



@endsection
