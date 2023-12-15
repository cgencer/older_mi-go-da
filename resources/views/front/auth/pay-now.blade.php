@extends('front.layouts.master')
@section('title') {{trans('txt.link_pay_now')}} @parent @endsection

@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <h1>{{ trans('txt.title_confirmed_booking') }}</h1>
                <h3 class="submessage">{{ trans('txt.pay_now_note') }}</h3>
                @foreach($reservations as $reservation)
                    @php
                        $hotel = $reservation->hotel()->get()->first();
                    @endphp
                    <div class="listing-item listing-item_small clearfix">
                        <div class="listing-item_left">
                            <img src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/200x170 @endif" class="img-desktop" width="170" height="140"/>
                            <img src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif" class="img-mobile"/>
                        </div>
                        <div class="listing-item_middle">
                            <h2> {{ $hotel->name }}</h2>
                            <h3  class="waiting-time">
                                {{ trans('txt.det_checkin_title') }}:
                                <strong>{{ $reservation->checkin_date->format('M d, Y') }}</strong><br>
                                {{ trans('txt.det_checkout_title') }}:
                                <strong>{{ $reservation->checkout_date->format('M d, Y') }}</strong>
                            </h3>
                            <h3>
                                <strong>{{ trans('txt.status') }}: </strong>
                                <strong class="ready-text text-bold"> {{ trans('txt.ready_for_payment_text') }}
                                    <img width="20" src="{{ asset('front/assets/images/svg/correct.svg') }}" alt="">
                                </strong>
                            </h3>
                        </div>
                        <div class="listing-item_right listing-item_right">
                            <div class="right-bottom-wrapper">
                                {{-- <a href="{{ route('f.invoice', ['uuid'=> $reservation->uuid ]) }}" class="pay-finish-button mg-tertiary-button status_declined">{{ trans('txt.title_pay_and_finish') }}
                                    <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a> --}}

                                    <form style="width: 100%;height: 100%;" action="{{ route('f.payment') }}" method="POST">
                                        @hidden('uuid', $reservation->uuid)
                                         <a onclick="$(this).closest('form').submit();" href="#" class="pay-finish-button mg-tertiary-button">{{ trans('txt.title_pay_and_finish') }}
                                        <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
                                    {{-- @close --}}
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

