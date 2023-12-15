@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
    $hotel = $reservation->hotel()->get()->first();
@endphp
@section('title') {{trans('txt.page_title_reservation')}} @parent @endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <div class="profile-top clearfix">
                    <a href="{{ route('auth.bookings') }}" class="back-btn">
                        <img src="{{ asset('front/assets/images/svg/arrow-left-black.svg') }}"/> {{ trans('txt.link_back_to_history') }}
                    </a> <span class="action_buttons">
                        <a href="#" class="active-button">{{ trans('txt.link_pdf') }}</a>
                        <a href="#" class="active-button_second">{{ trans('txt.link_print') }}</a>
                    </span>
                </div>
                <h1>
                    {{trans('txt.confirmed-night-nights-in-hotel-name',['night'=>$reservation->getLength(),'hotel_name'=>$hotel->name])}}
                </h1>
                <div class="receipt-content">
                    <div class="top_left">
                        {{trans('txt.booking-by-main-guest',['main_guest'=>$reservation->main_guest])}} / {{ $reservation->created_at->format("l, d F Y") }}
                    </div>
                    <div class="top_right text-right">
                        {{trans('txt.res_receipt_number') }} MGD-{{ $reservation->id }}
                    </div>
                </div>
                <div class="receipt-content">
                    <div class="middle_left">
                        <div class="calendar-wrapper">
                            <div class="blocks-wrapper">
                                <div class="blocks-left">
                                    <h5>{{ trans('txt.det_checkin_title') }}</h5>
                                    <h4>{{ $reservation->checkinMdY }}</h4>
                                </div>
                                <div class="blocks-right">
                                    <h5>{{ trans('txt.det_checkout_title') }}</h5>
                                    <h4>{{ $reservation->checkoutMdY }}</h4>
                                </div>
                            </div>
                            <div class="blocks-wrapper">
                                <div class="blocks-left">
                                    <h4>{{ trans('txt.number-guests',['number'=>$reservation->guest_adult]) }}</h4>
                                </div>
                                <div class="blocks-right">
                                    <h4>
                                        @if ($reservation->guest_child > 1)
                                            {{trans('txt.number-children',['number'=>$reservation->guest_child])}}
                                        @else
                                            {{trans('txt.number-children',['number'=>$reservation->guest_child])}}
                                        @endif
                                    </h4>
                                </div>
                            </div>
                            @php
                            $FoodTextExplode = explode(' (', $hotel->getBoardFoodAllowance());
                            @endphp
                            <div class="extras clearfix">
                                <div class="extra">
                                        <span class="extra_title">
                                            @if (count($FoodTextExplode) > 1)
                                            {{$FoodTextExplode[0]}}
                                            <br>
                                            {{'(' . $FoodTextExplode[1]}}
                                            @endif
                                            <span class="extra_subtitle">
                                    {{ trans('txt.per_person_per_day') }}
                                            </span>
                                        </span> <span class="extra_price">
                                        {{ \App\Helpers::localizedCurrency($hotel->price) }}
                                        </span>
                                </div>
                            </div>
                            <div class="extras clearfix">
                                <div class="extra">
                                        <span class="extra_title d-block">
                                            {{ trans('txt.subtotal') }}
                                        </span> <span class="extra_price">
                                            {{ \App\Helpers::localizedCurrency($price) }}
                                        </span>
                                </div>
                            </div>
                            <div class="extras clearfix" id="total_price" data-price-per-person="{{ \App\Helpers::localizedCurrency($price) }}">
                                <div class="extra">
                                        <span class="extra_title d-block">
                                            {{ trans('txt.total') }}
                                            <span class="extra_subtitle">
                                                {{ trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%
                                            </span>
                                        </span> <span class="extra_price">
                                            {{ \App\Helpers::localizedCurrency($price) }}
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle_right_top total_blocks">
                        <h3>{{ trans('txt.charges_title') }}</h3>
                        <div class="total_row total_row_oneline clearfix">
                            <span class="right"> {{ \App\Helpers::localizedCurrency($hotel->price) }}</span>
                            <span class="top">{{ trans('txt.per_person_per_day') }}</span>
                        </div>
                        <div class="total_row total_row_oneline clearfix">
                            <span class="right"> {{ \App\Helpers::localizedCurrency($hotel->price) }}</span>
                            <span class="top">{{ $reservation->getLength() }} @if($reservation->getLength() > 1){{ trans('res_detail_nights') }} @else {{ trans('txt.res_detail_night') }} @endif</span>
                        </div>
                        <div class="total_row total_row_twolines clearfix">
                            <span class="right right_larger"> {{ \App\Helpers::localizedCurrency($price) }}</span>
                            <span class="top top_bolder">{{ trans('txt.total_paid') }}</span>
                            <span class="bottom">{{  trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%</span>
                        </div>
                    </div>
                    <div class="middle_right_bottom total_blocks">
                        <h3>{{ trans('txt.payment_title') }}</h3>
                        <div class="total_row total_row_twolines clearfix">
                            <span class="right">{{ \App\Helpers::localizedCurrency($price) }}</span>
                            @if ($reservation->payments)
                                <span class="top text-capitalize">{{ trans('txt.paid_with') }} {{ $reservation->payments->packet['charges']['data']['payment_method_details']['card']['network'] }} **** {{ $reservation->payments->packet['charges']['data']['payment_method_details']['card']['last4'] }}</span>
                                <span class="bottom">{{  $reservation->payments->created_at->toDayDateTimeString() }}</span>
                            @endif
                        </div>
                        <div class="total_row total_row_twolines clearfix">
                            <span class="right right_larger"> {{ \App\Helpers::localizedCurrency($price) }}</span>
                            <span class="top top_bolder">{{ trans('txt.total_paid') }}</span>
                            <span class="bottom">{{ trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%</span>
                        </div>
                    </div>
                </div>

                <div class="receipt-content">
                    <div class="bottom_left">
                    @if ($reservation->status == 0 || $reservation->status == 1 || $reservation->status == 3)
                        <span> {{ trans("txt.cancel_reservation_text") }} <a href="#" style="text-decoration: revert;" data-toggle="modal" data-target="#reservationCancelModal">{{ trans('txt.click_here_button') }}</a> </span>
                    @endif
                    </div>
                    <div class="bottom_right">
                        <img src="{{ asset('front/assets/images/logo-footer.png') }}" alt="Migoda"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reservationCancelModal" tabindex="-1" role="dialog"
     aria-labelledby="termsAndConditionsModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ trans("txt.title_cancel_reservation") }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                {!! trans('txt.reservation_cancel_text') !!}
            </div>
        </div>
    </div>
</div>
@endsection
