

@extends('emails.layouts.master-hotel')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="title-h1">What do we do?  - We help you fill your UNSOLD rooms!</h1>
            <h4 class="title-h4">
                @if ($gender == "f")
                Dear Mrs {{ $name }}
                    @else
                Dear Mr {{ $name }}
                @endif
                <br>
            We have chosen YOU to be part of our family! <br>
            You have nothing to loose – only to WIN! <br>
            </h4>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
                <h2 class="title-h2"> How will we fill your unsold rooms?</h2>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
            <p class="paragraph">
                You agree to give your unsold rooms to us for free and we fill your house with ready to travel coupon holders – who appreciate your free room in exchange to agreeing to pay a meal package that you offer on our digital market place
                <a target="_blank" rel="noopener noreferrer" href="https://migoda.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migoda.com.</a>
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
                              As you may already know – there have been a few companies who offer a similar model – but we are now the first company - completely digital with an international audience. Please view our e-brochure to learn about us - and understand how easy your participation for this win-win business model is!
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
                        <a target="_blank" rel="noopener noreferrer" href="https://meet.google.com/yta-hvwr-bym" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn1.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;display:block;border:none;"></a>
                    </td>
                    <td style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td style="">
                        <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migoda-brochure-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn2.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;display:block;border:none;"></a>
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
                                Of course, our website  <a target="_blank" rel="noopener noreferrer" href="https://migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migodahotels.com</a> gives all this information too.<br><br>
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
                              <p class="paragraph">  As we invite you to be part of our family - we have with much LOVE created your account as well as your profile in our Extranet system. Please click here to view it ...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>

<tr>
    <td align="right" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ $url }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn3.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;display:inline-block;border:none;"></a>
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
                                    We truly hope that you like what we created and would be so thankful if you join us. <br> For that you just need to agree and sign your    <a href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">our Service Agreement</a>.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>


<tr>
    <td align="right" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn4.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br><br>
                <p class="paragraph">
                                 You can either upload the signed agreement in the dashboard/ document section of your extranet section, send it to us by fax (F. +49 40 228 200 169) or by scanned email too (<a href="mailto:register@migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">register@migodahotels.com</a>).
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
                    We are always here to support you with our knowledge - be it business related, digital questions or how just to improve some parts of your profile.   <br><br>

                    Please never hesitate to reach out to us.   <br><br>

                    With warmest regards for a beautiful journey and cooperation together,<br><br><br>

                    Your Migoda Team <br><br>

                    <b>Mischeila Golla</b><br>
                    Founder &amp; CEO
                </p ></b><br></b><br>

        </div>
    </td>
</tr>



@endsection
