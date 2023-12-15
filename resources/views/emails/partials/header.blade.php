<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title>@section('title') @show</title>
    <!--[if !mso]> -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <!--[if !mso]><!-->
    <style type="text/css">
        @media only screen and (max-width: 480px) {
            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }
    </style>
    <!--<![endif]--><!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml><![endif]--><!--[if lte mso 11]>
    <style type="text/css">
        .outlook-group-fix {
            width: 100% !important;
        }
    </style><![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <!--<![endif]-->
    <style type="text/css">
        @media only screen and (min-width: 480px) {
            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }

            .mj-column-per-60 {
                width: 60% !important;
                max-width: 60%;
            }

            .mj-column-per-40 {
                width: 40% !important;
                max-width: 40%;
            }

            .mj-column-per-50 {
                width: 50% !important;
                max-width: 50%;
            }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width: 480px) {
            table.full-width-mobile {
                width: 100% !important;
            }

            td.full-width-mobile {
                width: auto !important;
            }
        }
    </style>
    <style type="text/css">
        body {
            background-color: #fff;
        }

        .header {
            max-width: 600px;
            background:url('{{ asset("mailing/images/header.png") }}') top center / contain no-repeat;
            Margin:0px auto;
            max-width:600px;
        }

        .header table.top-table{
            background:url('{{ asset("mailing/images/header.png") }}') top center / contain no-repeat;
            width:100%;
        }

        .header-title {
            font-size: 40px;
            font-weight: 600;
            line-height: 55px;
        }

        .header-subtitle {
            font-size: 34px;
            font-weight: 300;
            line-height: 47px;
        }

        .header-subsubtitle {
            font-size: 20px;
            font-weight: 300;
            line-height: 30px;
        }

        .main-button{
            color: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 25px;
            font-weight: 200;
            line-height: 25px;
            Margin: 0;
            text-decoration: none;
            text-transform: none;
        }

        .main-button-holder{
            border:none;
            border-radius:10px;
            cursor:auto;
            height:70px;
            background-image: linear-gradient(8deg, #ff4d1d 0%, #f30e75 100%);
        }

        .main-button-holder-bg{
            border:1px solid #6d6f7e;
            border-radius:10px;
            cursor:auto;
            height:70px;
            background:#ffffff;
        }

        .main-button-bg{
            background:#ffffff;
            color:#6d6f7e;
            font-family: Arial, sans-serif;
            font-size: 25px;
            font-weight: 200;
            line-height: 25px;
            Margin: 0;
            text-decoration:none;
            text-transform:none;
        }

        .header-logo img {
            width: 198px !important;
            padding-bottom: 20px;
            padding-top: 0px;
        }

        p {
            line-height: 30px;
            font-size: 22px
        }

        p.note-text {
            font-size: 14px;
            font-weight: 400;
        }

        p.note-text-red {
            font-size: 12px;
            color: #fa3440;
        }

        .footer-title {
            margin-top: 0;
        }

        .footer-image img {
            width: 140px !important;
        }

        a.mail_link {
            color: #6d6f7e;
        }

        a.active_link {
            color: #fa3440;
            text-decoration: underline;
        }

        a.passive_link {
            color: #6d6f7e;
            font-size: 13px;
            display: block;
            text-decoration: underline;
        }

        a.fade_link {
            font-size: 13px;
            color: #cbcaca;
            display: block;
        }

        span.strong,
        p.strong {
            font-weight: bold;
        }

        span.underlined,
        p.underlined {
            text-decoration: underline;
        }

        .inner-step {
            font-size: 18px;
            background: #fa3440;
            color: #fff;
            display: inline-block;
            width: 30px;
            text-align: center;
            line-height: 30px;
            border-radius: 5px;
            margin-bottom: 0;
            margin-top: 30px;
        }

        .inner-title {
            font-size: 22px;
        }

        .booking-date-detail p.date-right {
            border-left: 1px solid #f4f5fa;
            padding-left: 5%;
        }

        .date-table {
            max-width: 530px !important;
            border: 1px solid #f4f5fa;
            padding: 0 15px !important;
        }

        .booking-total {
            background-color: #f4f5fa;
        }

        .booking-total td {
            background-color: #f4f5fa;
        }

        .booking-total p {
            height: 40px;
        }

        /* .booking-total p.total-price-right {
            line-height: 40px;
        } */

        .total-title {
            display: block;
            font-size: 24px;
        }

        .total-subtitle {
            display: block;
            font-size: 10px;
            color: #6d6f7e
        }

        .total-price {
            display: block;
            font-size: 28px;
        }

        .checkin-checkout {
            font-size: 12px;
            color: #ccc;
            display: block;
        }

        .invoice-exam-title{
                line-height: 22px !important;
                font-size: 18px !important;
            }

        @media all and (max-width: 480px) {
            .header {
            }

            .header-logo img {
                width: 120px !important;
            }

            .header-title {
                font-size: 25px;
                line-height: 30px;
            }

            .header-subtitle {
                font-size: 28px;
                line-height: normal;
            }

            .footer-title {
                font-size: 14px;
                line-height: 22px;
            }

            .footer-address {
                font-size: 13px!important;
                line-height: normal;
            }

            .active_link{
                font-size: 13px!important;
            }

            .footer-title span{
                font-size: 15px!important;
                line-height: normal!important;
            }

            .footer-unstep {
                padding: 10px 0px!important;
                margin-right: -40px!important;
            }

            .footer-image img {
                width: 100px !important;
                /* padding-left: 25px !important; */
            }

            p.note-text-red{
                line-height: 22px!important;
            }

            .booking-information-text{
                padding-left: 19px !important;
            }

            .invoice-pic{
                width: 100%!important;
            }

            .view-map-button{
                padding: 5px!important;
            }

            .hotel-address{
                font-size: 12px!important;
            }

            a.active_link {
                font-size: 13px;
            }

            a.fade_link {
                display: block;
            }

            a.passive_link {
            }

            .booking-detail p {
                font-size: 12px!important;
            }

            .date-table {
                margin-left: 10px !important;
                margin-right: 10px !important;
                max-width: 530px !important;
                padding: 0px;
            }

            .zpadding-column td {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }


            /* .booking-total td {
                padding-top: 10px !important;
                padding-right: 10px !important;
            } */


            .main-button{
                font-size: 17px;
                line-height: 25px;
            }

            .main-button-holder{
                height:45px;
            }

            .main-button-holder-bg{
                height:45px;
            }

            .main-button-bg{
                font-size: 17px;
                line-height: 25px;
            }

            .booking-subtitle{
                font-size: 15px!important;
                 line-height: normal!important;
            }

            p.note-text {
            line-height: 22px!important;
            }

            .invoice-exam-title{
                    line-height: 22px !important

            }

            p {
            line-height: 23px;
            font-size: 18px;
            }

            /* .total-subtitle{
                margin-top: 22px!important;
            } */


        }

        .title-h1{
            color: #0a0a0a!important;
            padding: 0;
            margin: 0;
            margin: 0;
            text-align: left;
            line-height: 1.3;
            color: inherit;
            word-wrap: normal;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: normal;
            margin-bottom: 10px;
            margin-bottom: 10px;
            font-size: 34px;
            color: #6d6f7e;
            font-family: Arial;
            font-size: 32px;
            font-weight: 700;
            line-height: 40px;
        }

        .title-h4{
            color: #0a0a0a!important;
                padding: 0;
                margin: 0;
                margin: 0;
                text-align: left;
                line-height: 1.3;
                color: inherit;
                word-wrap: normal;
                font-family: Helvetica, Arial, sans-serif;
                font-weight: normal;
                margin-bottom: 10px;
                margin-bottom: 10px;
                font-size: 24px;
                color: #6d6f7e;
                font-family: Arial;
                font-size: 20px;
                font-weight: 400;
                padding-top: 20px;
                line-height: 30px;
        }
    </style>
    @yield('custom_styles')
</head>
<body>
<div>
<!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="header-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><v:rect style="width:600px;" xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false"><v:fill origin="0.5, 0" position="0.5, 0" src="{{ asset('mailing/images/header.png') }}" type="tile" /><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]-->
    <div class="header" style="">
        <div style="line-height:0;font-size:0;">
            <table class="top-table" align="center" background="{{ asset('mailing/images/header.png') }}" border="0" cellpadding="0" cellspacing="0" role="presentation" style="">
                <tbody>
                <tr>
                    <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;text-align:center;vertical-align:top;">
                        <!--[if mso | IE]>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                        <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                <tr>
                                    <td align="left" class="header-logo" style="font-size:0px;padding:35px 45px;word-break:break-word;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                            <tbody>
                                            <tr>
                                                <td style="width:550px;">
                                                    <a href="{{ config('app.url')  }}" target="_blank"><img alt="{{ config('app.name') }}" height="auto" src="{{ asset('mailing/images/logo-header.png') }}" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;" width="550"></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
