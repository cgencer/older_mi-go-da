@extends('admin.layouts.master')
@section('title')
    Rule Add | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Rule Add</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Coupon Management</span>
                        <a class="breadcrumb-item" href="{{route('admin.coupon-rules.index')}}">Coupon Rules</a>
                        <span class="breadcrumb-item active">Rule Add</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('admin.coupon-rules.add.post'), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('is_active', 'Is Active?', array('class' => 'control-label'))}}
                                <div class="switch">
                                    {!! Form::checkbox('is_active', '1', null,  ['id' => 'is_active']) !!}
                                    <Label for="is_active"></Label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('name', 'Name', array('class' => 'control-label'))}}
                                {{Form::text('name', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('start_date', 'Start Date', array('class' => 'control-label'))}}
                                {{Form::text('start_date', null,array('class'=>'form-control','data-provide'=>'datepicker','data-plugin'=>'timepicker'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('end_date', 'End Date', array('class' => 'control-label'))}}
                                {{Form::text('end_date', null,array('class'=>'form-control','data-provide'=>'datepicker','data-plugin'=>'timepicker'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('prefix', 'Prefix', array('class' => 'control-label'))}}
                                {{Form::text('prefix', null,array('class'=>'form-control','minlength'=>1,'maxlength'=>3))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('suffix', 'Suffix', array('class' => 'control-label'))}}
                                {{Form::text('suffix', null,array('class'=>'form-control','minlength'=>1,'maxlength'=>3))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('length', 'Length', array('class' => 'control-label'))}}
                                {{Form::input('number','length', null,array('class'=>'form-control','min'=>12,'max'=>18))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('quantity', 'Quantity', array('class' => 'control-label'))}}
                                {{Form::input('number','quantity', null,array('class'=>'form-control','min'=>1))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('generate', 'Generate', array('class' => 'control-label'))}}
                                <div class="switch">
                                    {!! Form::checkbox('generate', '1', null,  ['id' => 'generate']) !!}
                                    <Label for="generate"></Label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        {!! Form::hidden('submitted', '1', ['id' => 'id']) !!}
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
