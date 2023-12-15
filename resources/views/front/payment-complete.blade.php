@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_payment_complete')}} @parent @endsection
@section('top_nav')
    <ul class="header-navigation desktop-only steps">
        <li><a class="active" href="#">{{ trans('txt.title_booking_details') }}</a></li>
        <li><a class="active" href="#">{{ trans('txt.title_confirm') }}</a></li>
        <li><a class="active" href="#">{{ trans('txt.title_payment') }}</a></li>
    </ul>
@endsection
@section('body')
    <div class="booking-complete-outer mg-section mg-group">
        <div class="booking-complete-check">
            <i class="fa fa-check-circle-o"></i>
        </div>
        <h1>{{ trans('txt.enjoy_your_trip') }}</h1>
        <p>
            {{ trans('txt.payment_complete1') }} <br/>
            {{ trans('txt.payment_complete2') }} <br/>
            {{ trans('txt.payment_complete3') }}
        </p>
        <div class="booking-complete">
            @open(['route' => 'f.customerPortal', 'layout' => 'inline', 'method' => 'POST'])
            @hidden('uuid', $reservation->uuid)
            @submit('Manage billing', ['class' =>'success', 'id' => 'submit-button']) 
            @close
        </div>
    </div>
@endsection
