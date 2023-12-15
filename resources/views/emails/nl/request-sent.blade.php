@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Hallo {{ $name }} </h1>
            <p class="strong" style="font-weight: bold">Verzoek verzonden ...</p>
            <p style="">Uw boekingsaanvraag is succesvol verzonden naar het door u gekozen hotel.
                <br>
                <br>
                Het hotel zal nu controleren of er beschikbaarheid is en zal binnen 48 uur contact met u opnemen met een bevestiging of afwijzing.
                <br>
                <br>

                Nadat uw boekingsaanvraag is geaccepteerd, ontvangt u een melding per e-mail om te betalen en uw boeking binnen 48 uur te voltooien.
            </p>

        </div>
    </td>
</tr>

<tr>
    <td style="font-size:0px;padding:10px 25px;padding-top:20px;word-break:break-word;">
        <p style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:100%;"></p>
        <!--[if mso | IE]>
        <table align="center" border="0" cellpadding="0" cellspacing="0"
               style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:550px;" role="presentation"
               width="550px">
            <tr>
                <td style="height:0;line-height:0;"> &nbsp;
                </td>
            </tr>
        </table><![endif]-->
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p >Details Boekingsaanvraag</p>
            <h2 >{{ $hotelName }}</h2>
        </div>
    </td>
</tr>
<tr>
    <td style="" width="550" align="center">
        <a href="{{ config('app.url')  }}" target="_blank"><img class="invoice-pic" alt="{{ config('app.name') }}" height="auto" src="{{ asset('mailing/images/hotel-room.png') }}" style="border:none;display:block;outline:none;text-decoration:none;height:auto;" width="550"></a>
    </td>
</tr>
</table>
</div>
<!--[if mso | IE]></td>
<td class="booking-detail-outlook" style="width:600px;"><![endif]-->

    <div class="mj-column-per-100 outlook-group-fix booking-detail"
     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align:top;width:300px;"><![endif]-->
    <div class="mj-column-per-50 outlook-group-fix"
         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
               width="100%">
            <tr>
                <td class="booking-information-text" align="left"
                    style="font-size:0px;padding-left: 30px;padding-top:0;padding-bottom:0;word-break:break-word;">
                    <div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:left;color:#aba6a6;">
                        <p class="invoice-exam-title">Boeking door <strong  style="color: #6d6e94">{{ $name }}!</strong><br>{{ $dayNamedDate }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="mj-column-per-50 outlook-group-fix"
    style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
   <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
          width="100%">
       <tr>
        <td align="right" style="padding-right: 35px;font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:right;color:#aba6a6;"><span class="total-subtitle"></span>
                <p class="invoice-exam-title"><strong style="color: #6d6e94">Code</strong><br>{{ $code }}</p>

            </div>
        </td>
       </tr>
   </table>
</div>


<div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:left;color:#aba6a6;">
</div>

</div>
<!--[if mso | IE]></td></tr></table><![endif]-->

<div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:left;color:#aba6a6;">
</div>

    <!--[if mso | IE]></td>
    <td style="vertical-align:top;width:300px;"><![endif]-->
    <div class="mj-column-per-50 outlook-group-fix"
         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">

    </div>
    <!--[if mso | IE]></td></tr></table><![endif]-->
</div>
<!--[if mso | IE]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!--[if mso | IE]></v:textbox></v:rect></td></tr></table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="date-table-outlook" style="width:600px;"
       width="600">
    <tr>
        <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
<div class="date-table" style="Margin:0px auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
        <tbody>
        <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="booking-date-detail-outlook" style="width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix booking-date-detail"
                     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                        <p><span class="checkin-checkout">İnchecken</span> {{ $checkinCustomer }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                        <p class="date-right"><span class="checkin-checkout">Uitchecken</span>  {{ $checkoutCustomer }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                </div>
                <!--[if mso | IE]></td>
                <td class="zpadding-column-outlook" style="vertical-align:top;width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix zpadding-column"
                     style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;"
                           width="100%">
                        <tr>
                            <td style="font-size:0px;padding:10px 25px;padding-top:10px;word-break:break-word;">
                                <p style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:100%;"></p>
                                <!--[if mso | IE]>
                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                       style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:550px;"
                                       role="presentation" width="550px">
                                    <tr>
                                        <td style="height:0;line-height:0;"> &nbsp;
                                        </td>
                                    </tr>
                                </table><![endif]-->
                            </td>
                        </tr>
                    </table>
                </div>
                <!--[if mso | IE]></td>
                <td class="booking-date-detail-outlook" style="width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix booking-date-detail"
                     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                        <p> {{ $person }} volwassen(en)</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                        <p class="date-right"> {{ $children == null ? "No " : $children}} kind(eren)</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                </div>
                <!--[if mso | IE]></td>
                <td class="zpadding-column-outlook" style="vertical-align:top;width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix zpadding-column"
                     style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;"
                           width="100%">
                        <tr>
                            <td style="font-size:0px;padding-top:10px;word-break:break-word;">
                                <p style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:100%;"></p>
                                <!--[if mso | IE]>
                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                       style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:550px;"
                                       role="presentation" width="550px">
                                    <tr>
                                        <td style="height:0;line-height:0;"> &nbsp;
                                        </td>
                                    </tr>
                                </table><![endif]-->
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="mj-column-per-100 outlook-group-fix booking-date-detail" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:390px;"><![endif]-->
                    <div class="mj-column-per-65 outlook-group-fix zpadding-column" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:65%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                            <tbody><tr>
                                <td align="left" style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                        <p>Kamer:</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:210px;"><![endif]-->
                    <div class="mj-column-per-35 outlook-group-fix zpadding-column" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:35%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                            <tbody><tr>
                                <td align="right" style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:20px;line-height:1;text-align:right;color:#6d6f7e;">
                                        <p>Gratis</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                </div>

                <div class="mj-column-per-100 outlook-group-fix zpadding-column" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                        <tbody><tr>
                            <td style="font-size:0px;padding:10px 25px;padding-top:10px;word-break:break-word;">
                                <p style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:100%;"></p>
                                <!--[if mso | IE]>
                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                       style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:550px;"
                                       role="presentation" width="550px">
                                    <tr>
                                        <td style="height:0;line-height:0;"> &nbsp;
                                        </td>
                                    </tr>
                                </table><![endif]-->
                            </td>
                        </tr>
                    </tbody></table>
                </div>

                <!--[if mso | IE]></td>
                <td class="booking-date-detail-outlook" style="width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix booking-date-detail"
                     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:390px;"><![endif]-->
                    <div class="mj-column-per-65 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:65%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                <div class="package-total-title" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                    <p   style="line-height: normal!important;margin-bottom:unset!important">Alleen ontbijt
                                        <div style="font-family:Arial, sans-serif;font-size:14px;line-height:normal;text-align:left;color:#999999;">
                                            Per Person Per Day
                                        </div>
                                    </p>
                                </div>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:210px;"><![endif]-->
                    <div class="mj-column-per-35 outlook-group-fix zpadding-column"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:35%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="right"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:20px;line-height:1;text-align:right;color:#6d6f7e;">
                                        <p class="package-total" style="font-size: 28px;
                                        line-height: 35px;" >{{ $price }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                </div>
                <!--[if mso | IE]></td>
                <td class="booking-date-detail-outlook booking-total-outlook" style="width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix booking-date-detail booking-total"
                     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:360px;"><![endif]-->
                    <div class="mj-column-per-60 outlook-group-fix"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:60%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                style="font-size:0px;padding: 2px 8px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                    <p style="line-height: normal!important">  <span class="total-title strong">Totaal</span> <span style="margin-top:unset!important" class="total-subtitle">BTW incl.</span></p>
                                </div>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:240px;"><![endif]-->
                    <div class="mj-column-per-40 outlook-group-fix"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:40%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="right"
                                    style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;"><span
                                                class="total-subtitle"></span>
                                        <p class="total-price total-price-right ">{{ $priceTotal }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td></tr></table><![endif]-->
                </div>
                <!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!--[if mso | IE]></td></tr></table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600">
    <tr>
        <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
<div style="Margin:0px auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
        <tbody>
        <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix"
                     style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;"
                           width="100%">
                        <tr>
                            <td align="center" vertical-align="middle"
                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="border-collapse:separate;width:100%;line-height:100%;">
                                    <tr>
                                        <td align="center" bgcolor="#fa3440" role="presentation"
                                            class="main-button-holder"
                                            valign="middle"><a href="{{ $route }}"
                                            class="main-button"
                                                               target="_blank">Bekijk Boekingsstatus</a> <br><br> </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 50px">
                                            <br><br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
    @endsection
