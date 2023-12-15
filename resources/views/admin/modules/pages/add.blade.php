@extends('admin.layouts.master')
@section('title')
    Page Add | @parent
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
                <h2 class="header-title">Page Add</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <a class="breadcrumb-item" href="{{route('admin.pages.index')}}">Pages</a>
                        <span class="breadcrumb-item active">Page Add</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('admin.pages.add.post'), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('title', 'Title', array('class' => 'control-label'))}}
                                {{Form::text('title', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('slug', 'Slug', array('class' => 'control-label'))}}
                                {{Form::text('slug', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('content', 'Content', array('class' => 'control-label'))}}
                                {!! Form::textarea('content', null, ['class' => 'form-control mg-ckeditor']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        {!! Form::hidden('submitted', '1') !!}
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
