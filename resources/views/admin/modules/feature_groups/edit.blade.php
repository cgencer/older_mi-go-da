@extends('admin.layouts.master')
@section('title')
    Feature Group Edit (ID: {{$data->id}}) | @parent
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
                <h2 class="header-title">Feature Group Edit (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Hotel Management</span>
                        <a class="breadcrumb-item" href="{{route('admin.feature_groups.index')}}">Feature Groups</a>
                        <span class="breadcrumb-item active">Feature Group Edit (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('admin.feature_groups.save',['id'=>$data->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('name', 'Name', array('class' => 'control-label'))}}
                                {{Form::text('name', $data->name,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    $categories = \App\Models\FeatureCategories::all()->pluck('name','id')->toArray();
                                @endphp
                                {{Form::label('category_id', 'Category', array('class' => 'control-label'))}}
                                {!! Form::select('category_id', $categories, $data->category_id , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('filter', 'Filter', array('class' => 'control-label'))}}
                                {!! Form::select('filter', [1=>'Yes',0=>'No'] , $data->filter , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('position', 'Position', array('class' => 'control-label'))}}
                                {{Form::text('position', $data->position,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('admin_position', 'Admin Panel Position', array('class' => 'control-label'))}}
                                {{Form::text('admin_position', $data->admin_position,array('class'=>'form-control','autocomplete'=>'off'))}}
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
