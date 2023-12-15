@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
@endphp
@section('title') {{trans('txt.page_title_reservation')}} @parent @endsection
@section('top_nav')
    <ul class="header-navigation desktop-only steps">
        <li><a class="active" href="#">{{ trans('txt.title_booking_details') }}</a></li>
        <li><a class="active" href="#">{{ trans('txt.title_confirm') }}</a></li>
        <li><a class="active" href="#">{{ trans('txt.title_payment') }}</a></li>
    </ul>
@endsection
@section('head')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('body')
    <div class="content-page  middle-wrapper">
        <div class="content-header">
            <div class="content-header-inner mg-section  mg-group">
                <div class="mg-col mg-span_12_of_12">
                </div>
            </div>
        </div>
        <div class="content mg-section mg-group">
            <div class="mg-col mg-span_12_of_12">
                <h1>{{ trans('txt.enjoy_your_trip') }}</h1>
                <p>
                    {{ trans('txt.payment_complete1') }} <br/>
                    {{ trans('txt.payment_complete2') }} <br/>
                    {{ trans('txt.payment_complete3') }}
                </p>
                <div>
                <a href="{{ $invoice_url }}">{{trans('txt.your_invoice')}}</a>
                </div>
            </div>
        </div>
        <div class="booking-complete">
            @open(['route' => 'f.customerPortal', 'layout' => 'inline', 'method' => 'POST'])
            @hidden('uuid', $uuid)
            @submit('Manage billing', ['class' =>'success', 'id' => 'submit-button'])
            @close
        </div>
    </div>
@endsection
