@extends('admin.layouts.master')
@section('title')
    Add Admin | @parent
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
    <script>
        jQuery(document).ready(function ($) {
            //$('.phone-mask').mask('+99(999) 999 9999');
            $("#security-form").validate({
                ignore: ':hidden:not(:checkbox)',
                errorElement: 'label',
                errorClass: 'error',
                rules: {
                    password: {
                        required: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#password'
                    },
                }
            });
        });
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Add Admin</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">System</span>
                        <a class="breadcrumb-item" href="{{route('admin.admin_users.index')}}">Admins</a>
                        <span class="breadcrumb-item active">Add Admin</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('admin.admin_users.add.post'), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="p-h-15 p-v-20">
                                {{--                                   <div class="form-row">
                                                                       <div class="col-md-12">
                                                                           <div class="form-group">
                                                                               {{Form::label('profile_image', 'Profile Image', array('class' => 'control-label'))}}
                                                                               <div class="custom-file">
                                                                                   <label class="custom-file-label" for="profile_image">Select</label>
                                                                               </div>
                                                                               <div class="input-group">
                                                                                  <span class="input-group-btn">
                                                                                    <a data-input="profile_image" data-preview="image_holder" class="btn btn-default openFilemanager">
                                                                                      <i class="fa fa-picture-o"></i> Select
                                                                                    </a>
                                                                                  </span>
                                                                                   {!! Form::text('profile_image','profile_image',['id'=>'profile_image','class' => 'form-control' ])!!}
                                                                               </div>
                                                                               <div id="image_holder" style="margin-top:15px;max-height:100px;"></div>
                                                                           </div>
                                                                       </div>
                                                                   </div>--}}
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('username', 'Username', array('class' => 'control-label'))}}
                                            {{Form::text('username', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('firstname', 'First Name', array('class' => 'control-label'))}}
                                            {{Form::text('firstname', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('lastname', 'Last Name', array('class' => 'control-label'))}}
                                            {{Form::text('lastname', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('email', 'Email', array('class' => 'control-label'))}}
                                    {{Form::email('email', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                                </div>
                                <div class="form-group">
                                    <div class="m-b-10">
                                        {{Form::label('Gender', 'Gender', array('class' => 'control-label'))}}
                                    </div>
                                    <div class="radio d-inline m-r-15">
                                        {{Form::radio('gender', 'm', false, array('id'=>'gender1','class' => ''))}}
                                        {{Form::label('gender1', 'Male', array('class' => ''))}}
                                    </div>
                                    <div class="radio d-inline m-r-15">
                                        {{Form::radio('gender', 'f', false, array('id'=>'gender2','class' => ''))}}
                                        {{Form::label('gender2', 'Female', array('class' => ''))}}
                                    </div>
                                    <div class="radio d-inline m-r-15">
                                        {{Form::radio('gender', 'o', false, array('id'=>'gender3','class' => ''))}}
                                        {{Form::label('gender3', 'Other', array('class' => ''))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-h-15 p-v-20">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('phone', 'Phone', array('class' => 'control-label'))}}
                                            {{Form::text('phone', null,array('class'=>'form-control phone-mask'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('website', 'Website', array('class' => 'control-label'))}}
                                            {{Form::text('website', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        {{Form::label('date_of_birth', 'Birthday', array('class' => 'control-label'))}}
                                        {{Form::text('date_of_birth', null,array('rows'=>5,'class'=>'form-control','data-provide'=>'datepicker','data-orientation'=>'bottom'))}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        {{Form::label('biography', 'Biography', array('class' => 'control-label'))}}
                                        {{Form::textarea('biography', null,array('rows'=>5,'class'=>'form-control'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('password', 'New Password', array('class' => 'control-label'))}}
                                {{Form::password('password', array('id'=>'password','class'=>'form-control'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('password_confirmation', 'New Password Confirmation', array('class' => 'control-label'))}}
                                {{Form::password('password_confirmation', array('class'=>'form-control', 'equalTo'=>'#password'))}}
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
