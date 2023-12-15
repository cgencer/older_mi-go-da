@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
    <!DOCTYPE html>
<html lang="{{$app_locale}}">
<head>
    <meta charset=" utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@section('title')Migoda Hotels @show</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('admin/assets/images/logo/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/logo/favicon.png')}}">
    <!-- core dependcies css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/dist/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/PACE/themes/blue/pace-theme-minimal.css')}}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css')}}"/>
    <!-- page css -->
@yield('page_styles')
<!-- core css -->
    <link href="{{ asset('admin/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/materialdesignicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/sweetalert/lib/sweet-alert.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{ mix('admin/assets/css/app.css')}}" rel="stylesheet">
    @yield('styles')
</head>
<body class="hotel-admin-panel-body">
<div class="app header-default side-nav-light">
    <div class="layout">
        <!-- Header START -->
    @include('hotel_admin.partials.header')
    <!-- Header END -->
        <!-- Side Nav START -->
    @include('hotel_admin.partials.sidebar')
    <!-- Side Nav END -->
        <!-- Page Container START -->
        <div class="page-container">
            <!-- Content Wrapper START -->
        @yield('content')
        <!-- Content Wrapper END -->
            <!-- Footer START -->
            <footer class="content-footer">
                <div class="footer">
                    <div class="copyright ">
                        <span>Copyright © {{date('Y')}}<b class="text-dark"> {{config('app.name')}}</b>. {{trans('txt.all_rights_reserved')}}</span>
                        <ul>
                            <li>
                                <a target="_blank" href="https://www.migodahotels.com/terms-and-conditions/ ">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="{{route('hotel_admin.data-privacy.index')}}">Data Protection</a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.migodahotels.com/cookie-policy/">Cookie Policy</a>
                            </li>
                        </ul>
                        <span class="go-right">{!! trans('txt.developed') !!}</span>
                    </div>
                </div>
            </footer>
            <!-- Footer END -->
        </div>
        <!-- Page Container END -->
    </div>
</div>
<!-- build:js assets/js/vendor.js -->
<!-- core dependcies js -->
<script src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/PACE/pace.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/d3/d3.min.js') }}"></script>
<!-- endbuild -->
<!-- build:js assets/js/app.min.js -->
<!-- core js -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<!-- endbuild -->
<script src="{{ asset('admin/assets/vendor/sweetalert/lib/sweet-alert.js') }}"></script>
<script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
    });
</script>
<script src="{{asset('admin/assets/vendor/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('admin/assets/vendor/ckeditor/adapters/jquery.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.selectize').selectize({
            create: false,
            sortField: 'text'
        });
        var config = CKEDITOR.config;
        var ckeditor = $('.mg-ckeditor').ckeditor({
            customConfig: '',
            language: '{{$app_locale}}',
            height: 300,
            extraPlugins: 'wordcount',
            removePlugins: 'exportpdf,image,image2',
            toolbarGroups: [
                {name: 'paragraph', groups: ['list', 'indent', 'align', 'bidi', 'paragraph']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'links', groups: ['links']},
            ],
            contentsCss: '{{asset('admin/assets/css/_fonts.css')}}',
            font_names: 'Futura ND Demibold;Futura ND Book;' + config.font_names,
            removeButtons: 'Save,NewPage,ExportPdf,Print,Templates,About,Flash,PageBreak,Language,CreateDiv,SelectAll,Scayt,Preview,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField',
        });
    });
</script>
<!-- page js -->
@yield('scripts')
</body>
</html>
