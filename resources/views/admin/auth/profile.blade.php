@extends('admin.layouts.master')
@section('title')
    My Profile | @parent
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
            $('.phone-mask').mask('+99(999) 999 9999');
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
                <h2 class="header-title">My Profile</h2>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="tab-info">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#tab-Profile" class="nav-link active" role="tab" data-toggle="tab">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-Security" class="nav-link" role="tab" data-toggle="tab">Security</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-Profile">
                            {{ Form::open(array('url' => route('admin.auth.profile.save'), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
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
                                                    {{Form::text('username', $data->username,array('class'=>'form-control','autocomplete'=>'off'))}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('firstname', 'First Name', array('class' => 'control-label'))}}
                                                    {{Form::text('firstname', $data->firstname,array('class'=>'form-control','autocomplete'=>'off'))}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('lastname', 'Last Name', array('class' => 'control-label'))}}
                                                    {{Form::text('lastname', $data->lastname,array('class'=>'form-control','autocomplete'=>'off'))}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('email', 'Email', array('class' => 'control-label'))}}
                                            {{Form::email('email', $data->email,array('class'=>'form-control','autocomplete'=>'off'))}}
                                        </div>
                                        <div class="form-group">
                                            <div class="m-b-10">
                                                {{Form::label('Gender', 'Gender', array('class' => 'control-label'))}}
                                            </div>
                                            <div class="radio d-inline m-r-15">
                                                {{Form::radio('gender', 'm', (($data->gender == "m") ? true:false), array('id'=>'gender1','class' => ''))}}
                                                {{Form::label('gender1', 'Male', array('class' => ''))}}
                                            </div>
                                            <div class="radio d-inline m-r-15">
                                                {{Form::radio('gender', 'f', (($data->gender == "f") ? true:false), array('id'=>'gender2','class' => ''))}}
                                                {{Form::label('gender2', 'Female', array('class' => ''))}}
                                            </div>
                                            <div class="radio d-inline m-r-15">
                                                {{Form::radio('gender', 'o', (($data->gender == "o") ? true:false), array('id'=>'gender3','class' => ''))}}
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
                                                    {{Form::text('phone', str_replace(' ','',$data->phone),array('class'=>'form-control phone-mask'))}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('website', 'Website', array('class' => 'control-label'))}}
                                                    {{Form::text('website', $data->website,array('class'=>'form-control','autocomplete'=>'off'))}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                {{Form::label('date_of_birth', 'Birthday', array('class' => 'control-label'))}}
                                                {{Form::text('date_of_birth', $data->date_of_birth,array('rows'=>5,'class'=>'form-control','data-provide'=>'datepicker','data-orientation'=>'bottom'))}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                {{Form::label('biography', 'Biography', array('class' => 'control-label'))}}
                                                {{Form::textarea('biography', $data->biography,array('rows'=>5,'class'=>'form-control'))}}
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
                        <div role="tabpanel" class="tab-pane fade" id="tab-Security">
                            {{ Form::open(array('url' => route('admin.auth.profile.security.save'), 'id'=>'security-form', 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                            <div class="p-h-15 p-v-20">
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
                                                    <button type="submit" class="btn btn-gradient-success">Submit</button>
                                                </div>
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
        </div>
    </div>
@endsection
