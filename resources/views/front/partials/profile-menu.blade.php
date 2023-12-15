@php
    $currentPage = "";
        if (Illuminate\Support\Facades\Route::current()) {
           $currentPage = Illuminate\Support\Facades\Route::current()->getName();
       }
       $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
       $payCount= $user->getReservations()->whereIn('status', [4,1])->count();
@endphp
<div class="two-column-left">
    <ul class="profile-menu">
        <li @if ($currentPage == 'auth.profile') class="selected" @endif>
            <a href="{{ route('auth.profile') }}">{{ trans('txt.link_profile') }}</a>
        </li>
        <li>
            <li class="@if ($currentPage == 'auth.password') selected  @endif @if ($currentPage == 'auth.security' || $currentPage == 'auth.subscriptions' || $currentPage == 'auth.language') bold @endif">
                <a href="{{route('auth.password')}}">{{ trans('txt.link_account') }}</a>
                <ul class="profile-sub-menu">
                    <li @if ($currentPage == 'auth.security') class="selected futura-bolder" @endif>
                        <a href="{{ route('auth.security') }}"> {{ trans('txt.profile_security_title') }}</a>
                    </li>
                    <li @if ($currentPage == 'auth.subscriptions') class="selected futura-bolder" @endif>
                        <a href="{{ route('auth.subscriptions') }}"> {{ trans('txt.profile_subscriptions_title') }}</a>
                    </li>
                    <li @if ($currentPage == 'auth.language') class="selected futura-bolder" @endif>
                        <a href="{{ route('auth.language') }}"> {{ trans('txt.profile_language_title') }}</a>
                    </li>
                </ul>
            </li>
        </li>
        <li >
            <a class="@if ($currentPage == 'auth.reservation-status' || $currentPage == 'auth.pay-now' || $currentPage == 'f.reservation' || $currentPage == 'auth.bookings' || $currentPage == 'auth.wishlist') bold @endif" href="#">{{ trans('txt.link_journey_information') }}</a>
            <ul class="profile-sub-menu">
                <li @if ($currentPage == 'auth.reservation-status') class="selected futura-bolder" @endif>
                    <a href="{{ route('auth.reservation-status') }}">{{  trans('txt.link_waiting_confirmation') }}</a>
                </li>

                <li @if ($currentPage == 'auth.pay-now' ) class="selected futura-bolder" @endif>
                    <a href="{{ route('auth.pay-now') }}">{{ trans('txt.link_pay_now') }} ({{ $payCount }})</a>
                </li>
                <li @if ($currentPage == 'auth.bookings' || $currentPage == "f.reservation") class="selected futura-bolder" @endif>
                    <a href="{{ route('auth.bookings') }}">{{ trans('txt.link_travel_history') }}</a>
                </li>
                <li @if ($currentPage == 'auth.wishlist') class="selected futura-bolder" @endif>
                    <a href="{{ route('auth.wishlist') }}">{{ trans('txt.link_wishlist') }}</a>
                </li>
            <!--                <li @if ($currentPage == 'auth.sheets') class="selected" @endif>
                    <a href="{{ route('auth.sheets') }}">sheets</a>
                </li>
-->
            </ul>
        </li>
        <li>
            <a href="{{route('auth.logout')}}">{{ trans('txt.link_logout') }}</a>
        </li>
    </ul>
    <div class="profile-menu-bottom">
        <div class="existing-coupons coupons-box">
            <div class="coupon-box-inner">
                <div class="inner coupons_valid"></div>
            </div>
            <div class="left">
                <h5>{{ trans('txt.title_existing_coupon') }}</h5>
                <a href="#" data-toggle="modal"
                   data-target="#addCouponsModalCenter">{{ trans('txt.link_add_coupon') }}</a>
            </div>
        </div>
        <div class="used-coupons coupons-box">
            <div class="coupon-box-inner">
                <div class="inner coupons_used"></div>
            </div>
            <div class="left">
                <h5>{{ trans('txt.title_used_coupons') }}</h5>
                <a href="{{ route('auth.bookings') }}">{{ trans('txt.link_history') }}</a>
            </div>
        </div>
    </div>
</div>
