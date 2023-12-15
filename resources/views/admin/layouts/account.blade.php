<!DOCTYPE html>
<html lang="{{\Illuminate\Support\Facades\App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@section('title'){{config('app.name')}} @show</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('admin/assets/images/logo/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/logo/favicon.png')}}">
    <!-- core dependcies css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/dist/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/PACE/themes/blue/pace-theme-minimal.css')}}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css')}}"/>
    <!-- page css -->
    <!-- core css -->
    <link href="{{ asset('admin/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/materialdesignicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{ mix('admin/assets/css/app.css')}}" rel="stylesheet">
    @yield('styles')
</head>
<body>
@yield('content')
@yield('scripts')
<!-- build:js assets/js/vendor.js -->
<!-- core dependcies js -->
<script src="{{asset('admin/assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{asset('admin/assets/vendor/PACE/pace.min.js')}}"></script>
<script src="{{asset('admin/assets/vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
<script src="{{asset('admin/assets/vendor/d3/d3.min.js')}}"></script>
<!-- endbuild -->
<!-- build:js assets/js/app.min.js -->
<!-- core js -->
<script src="{{asset('admin/assets/js/app.js')}}"></script>
<!-- configurator js -->
<script src="{{asset('admin/assets/js/configurator.js')}}"></script>
<!-- endbuild -->
<!-- page js -->
</body>
</html>
