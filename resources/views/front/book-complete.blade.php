@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
@endphp
@section('title') {{ trans('txt.page_title_booking_complete') }} @parent @endsection
@section('top_nav')
    <ul class="header-navigation desktop-only steps">
        <li><a class="active" href="#">{{ trans('txt.title_booking_details') }}</a></li>
        <li><a href="#">{{ trans('txt.title_confirm') }}</a></li>
        <li><a href="#">{{ trans('txt.title_payment') }}</a></li>
    </ul>
@endsection

@if ($user)
    @php
        $firstname  = $user->firstname;
        $lastname   = $user->lastname;
        $email      = $user->email;
        $phone      = $user->phone;
        $dob        = $user->date_of_birth;
    @endphp
@endif
@section('body')
    <div class="booking-complete-outer mg-section mg-group">
        <div class="booking-complete-check">
            <i class="fa fa-check-circle"></i>
        </div>
        <h1>{{ trans('txt.request_sent') }}</h1>
        <h2>{{ trans('txt.status_waiting') }}</h2>
        <p >{!! trans('txt.booking_complete1') !!} <br/>
            {!! trans('txt.check-your-confirmation-status-on-your-profile-link',['reservation_link'=>'<a class="booking-complete-a" href="'.route('auth.reservation-status') .'">'.trans('txt.link_waiting_confirmation').'</a>']) !!}
        </p>
        <div class="booking-complete"></div>
    </div>
@endsection
@section('javascripts')
    <script>
        localStorage.clear("guests_child");
        localStorage.clear("guests_adult");
        localStorage.clear("storageCheckin");
        localStorage.clear("storageCheckout");
    </script>
@endsection
