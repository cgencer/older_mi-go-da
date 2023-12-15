@extends('front.layouts.master')
@section('title') {{trans('txt.contact_us_title')}} @parent @endsection
@section('body')
    <div class="middle-contact_wrapper middle-wrapper">
        <h2>{{ trans('txt.contact_us_title') }}</h2>
        {!! Form::open(['route' => 'f.contact.post', 'method' => 'post']) !!}
        <div class="container">
            @include('front.partials.alert')
        </div>
        <div class="mg-section mg-group middle-contact">
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
            <div class="mg-col mg-span_4_of_12 field_name">
                <div class="input-text">
                    <span>
                        <img src="{{ asset('front/assets/images/svg/user.svg') }}"/>
                    </span>
                    {!! Form::text('fullname', '', ['placeholder' => trans('txt.field_name'),'class'=>'validation-error', 'required' =>'required']) !!}
                </div>
            </div>
            <div class="mg-col mg-span_4_of_12 field_email">
                <div class="input-text">
                    <span>
                        <img src="{{ asset('front/assets/images/svg/email.svg') }}"/>
                    </span>
                    {!! Form::email('email', '', ['placeholder' => trans('txt.field_email'), 'required' =>'required']) !!}
                </div>
            </div>
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
        </div>
        <div class="mg-section mg-group middle-contact">
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
            <div class="mg-col mg-span_8_of_12 field_message">
                <div class="input-text">
                    <span>
                        <img src="{{ asset('front/assets/images/svg/message.svg') }}"/>
                    </span>
                    {!! Form::textarea('message', '', ['placeholder' => trans('txt.field_message'), 'required' =>'required']) !!}
                </div>
            </div>
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
        </div>
        @if(config('recaptcha.GOOGLE_RECAPTCHA_KEY'))
            <div class="mg-section mg-group middle-contact">
                <div class="mg-col mg-span_2_of_12 empty-mg-col">
                    &nbsp;
                </div>
                <div class="mg-col mg-span_8_of_12">
                    <div class="g-recaptcha" data-sitekey="{{config('recaptcha.GOOGLE_RECAPTCHA_KEY')}}"></div>
                </div>
                <div class="mg-col mg-span_2_of_12 empty-mg-col">
                    &nbsp;
                </div>
            </div>
        @endif
        <div class="mg-section mg-group middle-contact">
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
            <div class="mg-col mg-span_8_of_12">
                <button class="mg-primary-button handButton">{{ trans('txt.button_send') }}</button>
            </div>
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
        </div>
        <div class="mg-section mg-group middle-contact">
            <div class="mg-col mg-span_12_of_12 empty-mg-col">
                &nbsp;
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('javascripts')
    @if(config('recaptcha.GOOGLE_RECAPTCHA_KEY'))
        <script async defer src="https://www.google.com/recaptcha/api.js"></script>
    @endif
@endsection
