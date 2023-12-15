@extends('hotel_admin.layouts.master')
@section('title')
    {{trans('txt.reservation_edit_title')}} (ID: {{$data->id}}) | @parent
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
                <h2 class="header-title">{{trans('txt.reservation_edit_title')}} (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <span class="breadcrumb-item">{{trans('txt.finance_management')}}</span>
                        <a class="breadcrumb-item" href="{{route('hotel_admin.reservations.index')}}">{{trans('txt.reservations')}}</a>
                        <span class="breadcrumb-item active">{{trans('txt.reservation_edit_title')}} (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('url' => route('hotel_admin.reservations.save',['id'=>$data->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    $hotels = \App\Models\Hotels::all()->pluck('name','id')->toArray();
                                @endphp
                                {{Form::label('hotel_id', trans('txt.payment_edit_field_hotel'), array('class' => 'control-label'))}}
                                {!! Form::select('hotel_id', $hotels, $data->hotel_id , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    $customers = \App\Models\Customers::all()->pluck('name','id')->toArray();
                                @endphp
                                {{Form::label('customer_id', trans('txt.payment_edit_field_customer'), array('class' => 'control-label'))}}
                                {!! Form::select('customer_id', $customers, $data->customer_id , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('checkin_date', trans('txt.payment_edit_field_checkin'), array('class' => 'control-label'))}}
                                {{Form::text('checkin_date', $data->checkin_date,array('class'=>'form-control','data-provide'=>'datepicker','data-orientation'=>'bottom',"data-date-format"=>"yyyy-mm-dd"))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('checkout_date', trans('txt.payment_edit_field_checkout'), array('class' => 'control-label'))}}
                                {{Form::text('checkout_date', $data->checkout_date,array('class'=>'form-control','data-provide'=>'datepicker','data-orientation'=>'bottom',"data-date-format"=>"yyyy-mm-dd"))}}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('status', trans('txt.payment_edit_field_status'), array('class' => 'control-label'))}}
                                {{Form::select('status', $data->getStatusList() ,$data->status, array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('guest_adult', trans('txt.payment_edit_field_guest_adult'), array('class' => 'control-label'))}}
                                {{Form::text('guest_adult', $data->guest_adult,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('guest_child', trans('txt.payment_edit_field_guest_child'), array('class' => 'control-label'))}}
                                {{Form::text('guest_child', $data->guest_child,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('main_guest', trans('txt.payment_edit_field_main_guest'), array('class' => 'control-label'))}}
                                {{Form::text('main_guest', $data->main_guest,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('email', trans('txt.payment_edit_field_email'), array('class' => 'control-label'))}}
                                {{Form::text('email', $data->email,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('phone', trans('txt.payment_edit_field_phone'), array('class' => 'control-label'))}}
                                {{Form::text('phone', $data->phone,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('dob', trans('txt.payment_edit_field_dob'), array('class' => 'control-label'))}}
                                {{Form::text('dob', $data->dob,array('class'=>'form-control','data-provide'=>'datepicker','data-orientation'=>'bottom',"data-date-format"=>"yyyy-mm-dd"))}}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('gender', trans('txt.payment_edit_field_gender'), array('class' => 'control-label'))}}
                                {{Form::select('gender', ["m" => trans('txt.Male'), "f" => trans('txt.Female'), "o" => "Other"],$data->gender,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    $reasons = \App\Models\Features::where('type','reason')->get()->pluck('name','id')->toArray();
                                    $reasons[null] = 'Select';
                                    $reasons = array_merge(array_splice($reasons, -1), $reasons);
                                @endphp
                                {{Form::label('reason_id', trans('txt.payment_edit_field_r_reasons'), array('class' => 'control-label'))}}
                                {!! Form::select('reason_id', $reasons , $data->other_reason, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('other_reason', trans('txt.payment_edit_field_o_reason'), array('class' => 'control-label'))}}
                                {!! Form::textarea('other_reason', $data->other_reason, ['rows'=>5,'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('comments', trans('txt.payment_edit_field_comments'), array('class' => 'control-label'))}}
                                {!! Form::textarea('comments', $data->comments, ['rows'=>5,'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        <button type="submit" class="btn btn-gradient-success">{{trans('txt.link_submit')}}</button>
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
