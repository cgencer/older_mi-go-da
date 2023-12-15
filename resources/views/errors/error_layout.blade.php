@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
    <!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{$app_locale}}"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="{{$app_locale}}"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="{{$app_locale}}"> <![endif]--><!--[if gt IE 8]><!-->
<html class="no-js" lang="{{$app_locale}}"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@section('title') | {{config('app.name')}} @show</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta http-equiv="cleartype" content="on">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Responsive and mobile friendly stuff -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="375">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ mix('front/assets/css/oldstyles_bundled.css') }}"
          rel="stylesheet" media="all">
    <link href="{{ mix('front/assets/css/migoda-styles.css') }}"
          rel="stylesheet" media="all">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
    @yield('stylesheets')
    @yield('head')
</head>
<body class="@yield('body_class') {{$body_class ?? ''}}">

<div class="main-content_wrapper">
    @yield('body')
</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-159921455-1"></script>
<!-- Hotjar Tracking Code for migoda.com -->
<script>
    (function (h, o, t, j, a, r) {
        h.hj = h.hj || function () {
            (h.hj.q = h.hj.q || []).push(arguments);
        };
        h._hjSettings = {hjid: 1718532, hjsv: 6};
        a = o.getElementsByTagName('head')[0];
        r = o.createElement('script');
        r.async = 1;
        r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
        a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');

    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-159921455-1');
</script>
@yield('javascripts')
</body>
</html>
