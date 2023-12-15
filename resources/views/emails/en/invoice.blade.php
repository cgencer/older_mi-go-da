@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">YOUR BOOKING OVERVIEW</h1>
            <p class="strong">Dear {{ $name }},</p>
            <p>We at Migoda are so happy to see you go to {{ $hotel }}</p>
            <p>We are wishing you a wonderful stay with unforgettable memories and experiences that warm your heart, feed your soul and connect you back to yourself.</p>
            <p>Have a wonderful time!</p>
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
            <h2 class="header-subtitle" style="font-weight: 600">Receipt Details</h2>
            <p> {{ $nights }} nights,  {{ (int)$person+$children }} people in {{ $hotel }}</p>

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
                        <p class="invoice-exam-title">Booking by <strong  style="color: #6d6e94"> {{ $name }}</strong><br> {{ $dayNamedDate }}</p>
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
        <td align="right" style="font-size:0px;padding-right: 35px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:right;color:#aba6a6;"><span class="total-subtitle"></span>
                <p class="invoice-exam-title"><strong style="color: #6d6e94">Code</strong><br> {{ $code }}</p>

            </div>
        </td>
       </tr>
   </table>
</div>


<div style="font-family:Arial, sans-serif;font-size:12px;line-height:1;text-align:left;color:#aba6a6;">
</div>

</div>
<!--[if mso | IE]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!--[if mso | IE]></td>
<td class="booking-detail-outlook" style="width:600px;"><![endif]-->
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
                                            <p><span class="checkin-checkout">CHECK-IN</span>  {{ $checkin }}</p>
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
                                            <p class="date-right"><span class="checkin-checkout">CHECK-OUT</span>  {{ $checkout }}</p>
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
                                            <p> {{ $person }} Person</p>
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
                                            <p class="date-right"> {{ $children == 0 ? "No ": $children }} Children</p>
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
                                            <p>Room Price</p>
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
                                            <p>FREE</p>
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
                                            <p   style="line-height: normal!important;margin-bottom:unset!important">Breakfast Only
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
                                            line-height: 35px;" > {{ $price }}</p>
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
                                            <p style="line-height: normal!important;">  <span  class="total-title strong">Total</span> <span style="margin-top:unset!important" class="total-subtitle">Tax Included</span></p>
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
                                            <p class="total-price total-price-right "> {{ $priceTotal }}</p>
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

                         </div>
                    </div>
                    <div class="mj-column-per-100 outlook-group-fix booking-date-detail"
                         style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                        <!--[if mso | IE]>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align:top;width:390px;"><![endif]-->
                        <div class="mj-column-per-100 outlook-group-fix zpadding-column"
                             style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                   style="vertical-align:top;"
                                   width="100%">
                                <tr>
                                    <td align="left"
                                        style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                            <p>Payment</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="mj-column-per-100 outlook-group-fix zpadding-column"
                             style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                   style="vertical-align:top;"
                                   width="100%">
                                <tr>
                                    <td align="left"
                                        style="font-size:0px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                            <p
                                            style="

                                            color: #999999;
                                            font-size: 18px;
                                            font-weight: 400;
                                            margin-bottom:unset!important
                                            "
                                            >Paid with  {{ $cardType }} ---- {{ $cardLastFour }}</p>
                                            <p style="
                                            color: #aaaaaa;
                                            font-size: 16px;
                                            font-weight: 400;
                                            margin-top:unset!important

                                            ">
                                            {{ $paymentDateStamp }}
                                        </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--[if mso | IE]></td>

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
                                            <p style="line-height: normal!important;">  <span class="total-title strong">Total</span> <span style="margin-top:unset!important"  class="total-subtitle">Tax Included</span></p>

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
                                            <p class="total-price total-price-right "> {{ $totalWithTax }}</p>
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

        <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                <tr>
                    <td style="font-size:0px;padding:10px 25px;padding-top:20px;word-break:break-word;">
                        <p style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:100%;"></p>
                        <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #f4f5fa;font-size:1;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
                        </td></tr></table><![endif]-->
                    </td>
                </tr>
            </table>
        </div>
    </div>
        <!--[if mso | IE]></td>

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
                                            valign="middle"><a href=" {{ $receiptUrl }}"
                                                               class="main-button"
                                                               target="_blank">Download Receipt</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--[if mso | IE]></td>
                <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix"
                     style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;"
                           width="100%">
                        <tr>
                            <td align="left"
                                style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                                    <p>&nbsp;</p>
                                    <h1 class="strong">Hotel Adress</h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="border-collapse:collapse;border-spacing:0px;">
                                    <tbody>
                                    <tr>
                                        <td style="width:550px;"><img height="auto"
                                                                      src="{{ asset('mailing/images/fake-map.png') }}"
                                                                      style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;"
                                                                      width="550"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

                <!--[if mso | IE]></td>
                <td class="booking-date-detail-outlook" style="width:600px;"><![endif]-->
                <div class="mj-column-per-100 outlook-group-fix booking-date-detail"
                     style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr; ">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;margin-bottom:20px">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;"
                               width="100%">
                            <tr>
                                <td align="left"
                                    style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
                                    <div class="hotel-address" style="font-family:Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#6d6f7e;">

                                        <br>
                                        {{ $hotelAddress }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]></td>
                    <td style="vertical-align:top;width:300px;"><![endif]-->
                    <div class="mj-column-per-50 outlook-group-fix"
                         style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;margin-bottom:30px">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;    margin-top: 10px;"
                               width="100%">
                            <tr>
                                <td align="right" vertical-align="middle"
                                    style="font-size:0px;padding:10px 25px;word-break:break-word; margin-top:10px">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                           style="border-collapse:separate;width:100%;line-height:100%;">
                                        <tr>
                                            <td class="view-map-button" align="center" bgcolor="gray" role="presentation"
                                                style="border:none;border-radius:10px;cursor:auto;height:25px;padding:10px 25px;background:gray;"
                                                valign="middle">
                                                <br>
                                                <a href="{{ $mapUrl }}" style="background:gray;color:#ffffff;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">View Map</a>


                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>



    @endsection

