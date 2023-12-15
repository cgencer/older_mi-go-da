@extends('admin.layouts.master')
@section('title')
    Settings | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Settings</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item active">Settings</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')

            <div class="card">
                <div class="card-body settings">
                    {{ Form::open(array('url' => route('admin.settings.save'), 'method'=>'post','class'=>'m-t-15', 'autocomplete'=>'off')) }}

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="footer-pages-tab" data-toggle="tab" href="#footer-pages" role="tab" aria-controls="footer-pages" aria-selected="true">Footer Pages Settings</a>
                            <a class="nav-item nav-link" id="jjf-coupon-rule-tab" data-toggle="tab" href="#jff-coupon-rule" role="tab" aria-controls="jff-coupon-rule" aria-selected="true">Join For Free Auto Mail Settings</a>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="footer-pages" role="tabpanel" aria-labelledby="footer-pages-tab">
                            <div class="row form-row">
                                <h2>Footer Pages Settings</h2>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('terms', 'Terms and Conditions', array('class' => 'control-label'))}}
                                        {!! Form::select('terms', $pages, $selectedPages['terms'] , ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('data_protection', 'Data Protection', array('class' => 'control-label'))}}
                                        {!! Form::select('data_protection', $pages, $selectedPages['data_protection'] , ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('imprint', 'Imprint', array('class' => 'control-label'))}}
                                        {!! Form::select('imprint', $pages, $selectedPages['imprint'] , ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('cookie_policy', 'Cookie Policy', array('class' => 'control-label'))}}
                                        {!! Form::select('cookie_policy', $pages, $selectedPages['cookie_policy'] , ['class' => 'form-control']) !!}
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="tab-pane fade" id="jff-coupon-rule" role="tabpanel" aria-labelledby="jff-coupon-rule-tab">
                            <div class="row form-row">
                                <h2>Join For Free Auto Mail Settings</h2>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('jff_admin_email', 'Admin Email', array('class' => 'control-label'))}}
                                        {!! Form::text('jff_admin_email', $jffSettings['jff_admin_email'], ['placeholder' => 'Admin Email','class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('jff_coupon_rule', 'Coupon Rules', array('class' => 'control-label'))}}
                                        {!! Form::select('jff_coupon_rule', $couponRules, $jffSettings['jff_coupon_rule'] , ['class' => 'form-control']) !!}
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        <button type="submit" class="btn btn-gradient-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
