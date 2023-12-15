@extends('admin.layouts.master')
@section('title')
    Faq Data Edit (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            $('.lfm_image_button').filemanager('Images', {
                'prefix': '/admin/filemanager',
                'rq': 'admin',
            });
        })(jQuery);
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Faq Data Edit (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Pages</span>
                        <a class="breadcrumb-item" href="{{route('admin.faq.index')}}">Faq</a>
                        <span class="breadcrumb-item active">Faq Data Edit (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('admin.faq.save',['id'=>$data->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('title', 'Title', array('class' => 'control-label'))}}
                                {{Form::text('title', $data->title,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    {{Form::label('icon', 'Icon White', array('class' => 'control-label'))}}
                                    <div class="input-group">
   <span class="input-group-btn">
     <a data-input="icon" data-preview="icon_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="icon" class="form-control" type="text" name="icon" value="{{$data->icon}}">
                                    </div>
                                    <div id="icon_holder" class="lfm-image-holder">
                                        <img src="{{$data->icon}}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('icon2', 'Icon Colored', array('class' => 'control-label'))}}
                                    <div class="input-group">
   <span class="input-group-btn">
     <a data-input="icon2" data-preview="icon2_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="icon2" class="form-control" type="text" name="icon2" value="{{$data->icon2}}">
                                    </div>
                                    <div id="icon2_holder" class="lfm-image-holder">
                                        <img src="{{$data->icon2}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('content', 'Content', array('class' => 'control-label'))}}
                                {!! Form::textarea('content', $data->content, ['class' => 'form-control mg-ckeditor']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('type', 'Type', array('class' => 'control-label'))}}
                                {!! Form::select('type', ['USER'=>'Migoda User Faq','HOTEL' => 'Migoda Hotels Faq','PRIVACY' => 'Migoda Privacy Policy','HOTEL_PRIVACY' => 'MigodaHotel Privacy Policy'] , $data->type, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('position', 'Position', array('class' => 'control-label'))}}
                                {{Form::input('number','position', $data->position,array('class'=>'form-control','autocomplete'=>'off'))}}
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
