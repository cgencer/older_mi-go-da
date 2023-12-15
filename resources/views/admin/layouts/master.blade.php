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
    <title>@section('title'){{config('app.name')}} @show</title>
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
    <style>
        table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
            bottom: 10px;
        }
    </style>
</head>
<body class="admin-panel-body">
<div class="app header-default side-nav-light">
    <div class="layout">
        <!-- Header START -->
    @include('admin.partials.header')
    <!-- Header END -->
        <!-- Side Nav START -->
    @include('admin.partials.sidebar')
    <!-- Side Nav END -->
        <!-- Page Container START -->
        <div class="page-container">
            <!-- Content Wrapper START -->
        @yield('content')
        <!-- Content Wrapper END -->
            <!-- Footer START -->
            <footer class="content-footer">
                <div class="footer">
                    <div class="copyright">
                        <span>Copyright © {{date('Y')}}<b class="text-dark"> {{config('app.name')}}</b>. All rights reserved.</span>
                        <span class="go-right">Developed by <a href="https://parsdesign.me" target="_blank">Pars Design</a></span>
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
@env('local')
    <script src="http://localhost:35729/livereload.js"></script>
@endenv
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
            extraPlugins: 'wordcount,lineheight',
            removePlugins: 'exportpdf',
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'styles', groups: ['styles']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'colors', groups: ['colors']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ],
            contentsCss: '{{asset('admin/assets/css/_fonts.css')}}',
            font_names: 'Futura ND Demibold;Futura ND Book;' + config.font_names,
            removeButtons: 'Save,NewPage,ExportPdf,Print,Templates,About,Flash,PageBreak,Language,CreateDiv,SelectAll,Scayt,Preview,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField',
            @if(\Illuminate\Support\Facades\Request::is('admin/hotels/*/edit'))
            filebrowserImageBrowseUrl: '{{url('admin/filemanager')}}?type=Images&hotel={{\Illuminate\Support\Facades\Request::offsetGet('id')}}',
            filebrowserImageUploadUrl: '{{url('admin/filemanager')}}/upload?type=Images&hotel={{\Illuminate\Support\Facades\Request::offsetGet('id')}}&_token=' + $('meta[name="csrf-token"]').attr('content'),
            filebrowserBrowseUrl: '{{url('admin/filemanager')}}?type=Files&hotel={{\Illuminate\Support\Facades\Request::offsetGet('id')}}',
            filebrowserUploadUrl: '{{url('admin/filemanager')}}/upload?type=Files&hotel={{\Illuminate\Support\Facades\Request::offsetGet('id')}}&_token=' + $('meta[name="csrf-token"]').attr('content'),
            @else
            filebrowserImageBrowseUrl: '{{url('admin/filemanager')}}?type=Images',
            filebrowserImageUploadUrl: '{{url('admin/filemanager')}}/upload?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
            filebrowserBrowseUrl: '{{url('admin/filemanager')}}?type=Files',
            filebrowserUploadUrl: '{{url('admin/filemanager')}}/upload?type=Files&_token=' + $('meta[name="csrf-token"]').attr('content'),
            @endif
            filebrowserWindowWidth: '640',
            filebrowserWindowHeight: '480',
            filebrowserUploadMethod: 'xhr'
        });
    });
</script>
<!-- page js -->
@yield('scripts')
</body>
</html>
