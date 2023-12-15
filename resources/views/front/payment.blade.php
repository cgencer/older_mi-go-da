@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_payment')}} @parent @endsection
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
    <div class="booking-details-outer mg-section mg-group">
        <form class="needs-validation" action="{{ route('f.charge') }}" method="post" id="paymentform"
              data-secret="{{ $intentSecret }}">
            @csrf
            <input type="hidden" name="reservation_id" id="reservation_id" value="{{ $reservation->id }}"/>
            <input type="hidden" name="reservation_uuid" id="reservation_uuid" value="{{ $reservation->uuid }}"/>
            <input type="hidden" name="customer_id" id="customer_id" value="{{ $stripper['customer_id'] }}"/>
            <input type="hidden" name="customer_sid" id="customer_sid" value="{{ $stripper['customer_sid'] }}"/>
            <input type="hidden" name="intent_id" id="intent_id" value="{{ $intentid }}"/>
            <input type="hidden" name="hotel_id" id="hotel_id" value="{{ $hotel->id }}"/>
            <input type="hidden" name="country_id" id="country_id" value="{{ $hotel->country_id }}"/>
            <input type="hidden" name="connected_id" id="connected_id" value="{{ $connAccountId }}"/>
            <input type="hidden" name="checkin" id="checkin" value="{{ $checkin }}"/>
            <input type="hidden" name="currency" id="currency" value="{{ $currency }}"/>
            <input type="hidden" name="billing_email" id="billing_email" value="{{ $customer->email }}"/>
            @include('front.partials.alert')
            <h1>{{ trans('txt.payment_details_title') }}</h1>
            <div class="booking-details page-two-column">
                <div class="page-two-column-inner">
                    <div class="two-column-left generic-form">

                        <div class="section-header">
                            <strong class="payments-card-title">{{ trans('txt.card_info_title') }}</strong>
                        </div>

                        <div class="form-input">
                            <input class="my-input" id="card-name" placeholder="Name on card" value="" required>
                        </div>
                        <div id="card-element" class="form-input"></div>

                        <div id="card-element1" class="form-input"></div>
                        <div id="card-element2" class="form-input"></div>
                        <div id="card-element3" class="form-input"></div>

                        <div class="section-header">
                            <strong class="payments-card-title">{{ trans('txt.billing_address_title') }}</strong>
                        </div>

                        <div class="form-input form-country">
                            <div class="select-style">
                                <select name="country" id="country">
                                    <option value="0">{{ trans('txt.field_country') }}</option>
                                    @php
                                        $countries = \App\Models\Countries::orderby('name','asc')->get();
                                    @endphp
                                    @foreach($countries as $key => $country)
                                        @php
                                            // $sele = ($country->name == $adrset['state']) ? 'selected' : 'none';
                                            $sele = '';
                                        @endphp
                                        @if ($key > 0)
                                    <option value="{{ $country->code }}" selected="{{ $sele }}">{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-input">
                            <input class="@error('city') is-invalid @enderror" id="city" type="text"
                                   name="city" placeholder="{{trans('txt.field_city')}}" value="{{ $adrset['city'] }}" required>
                        </div>
                        <div class="form-input">
                            <input type="text" name="street_line1" id="street_line1"
                                   placeholder="{{ trans('txt.field_street1') }} " value="{{ $adrset['line1'] }}"/>
                        </div>
                        <div class="form-input">
                            <input type="text" name="street_line2" id="street_line2"
                                   placeholder="{{ trans('txt.field_street2') }}" value="{{ $adrset['line2'] }}"/>
                        </div>
                        <div class="form-input">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="state" id="state"
                                           placeholder="{{ trans('txt.field_state') }}" value="{{ $adrset['state'] }}"/>
                                </div>
                                <div class="col-md-4">
                                    <input class=" @error('zip_code') is-invalid @enderror" id="zip_code"
                                           type="text" placeholder="{{trans('txt.field_zipcode')}}" name="zip_code"
                                           value="{{ $adrset['postal_code'] }}" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-input">
                            <input type="checkbox" name="savecard" id="savecard" checked="checked"/> <label>{{trans('txt.field_savecart')}}</label>
                        </div>

                        <div id="card-errors" role="alert"></div>

                        <div class="form-input">
                            <label> <input type="checkbox" name="terms" id="terms"/>
                                <a data-toggle="modal" data-target="#termsAndConditionsModalCenter" href="#"
                                   id="terms_link">{{ trans('txt.terms_conditions_accept') }}</a></label>
                            <br /><small>{{trans('txt.terms_small_text')}}</small>
                        </div>
                        <button class="mg-primary-button handButton payment-button" id="bookingRequestButton">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">{{trans('txt.payment_save_button')}}</span>
                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}">
                        </button>

                        <div class="sr-field-error" id="card-errors" role="alert"></div>
                    </div>

                    <div class="two-column-right">
                        <div class="two-column-right-inner">
                            <div class="hotel-info clearfix">
                                <div id="book-image">
                                    <img
                                        src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/260x180 @endif"
                                        class="img-desktop desktop-only" width="260" height="180"/>
                                    <img
                                        src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif"
                                        class="img-mobile mobile-only"/>
                                </div>
                                {!! $hotel->getStarHtml() !!}
                                <h2>{{ $hotel->name }}</h2>
                                <h3>{{ $hotel->city }} {{ $hotel->getCountryName() }}</h3>
                                <ul class="listing-icons">
                                    @foreach($hotel->getPropertyTypes() as $property_type)
                                        @if (!is_null($property_type[0]->getCategoryRedIconWebPath()))
                                            <li>
                                                <img src="{{ $property_type[0]->getCategoryRedIconWebPath() }}"
                                                     title="{{ str_replace(' Hotel','',$property_type[0]->name) }}"/>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="calendar-wrapper">
                                <div class="blocks-wrapper">
                                    <div class="blocks-left">
                                        <h5>{{ trans('txt.det_checkin_title') }}</h5><h4>{{ $dtIn }}</h4>
                                    </div>
                                    <div class="blocks-right">
                                        <h5>{{ trans('txt.det_checkout_title') }}</h5><h4>{{ $dtOu }}</h4>
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
                                <div class="extras extras-active_color clearfix">
                                    <div class="extra">
									<span class="extra_title">
										{{ trans('txt.room_price') }}
										<span class="extra_subtitle">
											@php
                                                $number_coupons = trans('txt.number-coupons', ['number' => '<span id="calculated_days">1</span>']);
                                            @endphp
                                            {!! trans('txt.you-need-number-coupons-for-these-dates', ['number_coupons' => $number_coupons]) !!}
										</span>
									</span> <span class="extra_price">
										{{ trans('txt.text_free') }}
									</span>
                                    </div>
                                </div>
                                <div class="extras clearfix">
                                    <div class="extra">
										<span class="extra_title_payment">
											  @php
                                                  $boardFoodExp = explode(' (', $hotel->getBoardFoodAllowance());
                                              @endphp
                                            @if (count($boardFoodExp) > 0)
                                                {{$boardFoodExp[0]}}
                                            @else
                                                {{$hotel->getBoardFoodAllowance()}}
                                            @endif
											<span class="extra_subtitle">
												{{ trans('txt.per_person_per_day') }}
											</span>
										</span> <span class="extra_price">
											{{ \App\Helpers::localizedCurrency($hotel->price) }}
										</span>
                                    </div>
                                </div>
                                <div class="extras clearfix" id="total_price"
                                     data-price-per-person="{{ \App\Helpers::localizedCurrency(0) }}">
                                    <div class="extra">
										<span class="extra_title_payment">
								{{ trans('txt.total') }}
											<span class="extra_subtitle">
									      {{ trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%
											</span>
										</span> <span class="extra_price">
											<span
                                                id="calculated_price">{{ \App\Helpers::localizedCurrency($price) }}</span>
										</span>
                                    </div>
                                </div>
                                {{-- <div class="extras clearfix" id="total_price_sub">
                                    <div class="sr-legal-text">
                                        <div class="extra">
                                            {!! trans('txt.payment_extra_text1') !!} <span
                                                class="order-total">{{ \App\Helpers::localizedCurrency($price) }}</span>
                                            {{trans('txt.payment_extra_text2')}}
                                        </div>
                                    </div>
                                </div> --}}


                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
@endsection
@section('javascripts')
    <script>
    (function($) {
    'use strict';

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '1.8rem',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        $('select').select2();

        var stripe = Stripe("{{$apiKey}}");
        var elements = stripe.elements();

        var cardElement = elements.create('card', {'style': style, 'hidePostalCode': true});
        cardElement.mount('#card-element1');

        var clientSecret = $('#paymentform').data('secret');;


        $('#paymentform').on('submit', function(evt){
            evt.preventDefault();

            stripe.confirmCardSetup(clientSecret, {
                'return_url': "{{ route('f.reservation', ['uuid' => $reservation->uuid ?? '']) }}",
                'receipt_email': $('#billing_email').val(),
//                'setup_future_usage': 'off_session',
                'payment_method': {
                    'card': cardElement,
                    'billing_details': {
                        'name': $('#card-name').val(),
                        'email': $('#billing_email').val(),
                        'address': {
                            'city': $('#city').val(),
                            'line1': $('#street_line1').val(),
                            'line2': $('#street_line2').val(),
                            'postal_code': $('#zip_code').val(),
                            'state': $('#state').val(),
                            'country': $('#country').val()
                        },
                    },
                }
            }).then(function(result) {
                if (result.error) {
                    console.log(result);
                    switch(result.error.type){
                        case 'api_connection_error':
                        break;
                        case 'api_error':
                        break;
                        case 'authentication_error':
                        break;
                        case 'idempotency_error':
                        break;
                        case 'invalid_request_error':
                        break;
                        case 'rate_limit_error':
                        break;
                    }
                    alert(result.error.message);
                } else {
                    // The setup has succeeded. Display a success message.
                    if(result.setupIntent.status === 'succeeded'){
                        console.dir(result.setupIntent.result);
//                        console.log("{{ route('f.reservation', ['uuid' => $reservation->uuid ?? '']) }}");
                        window.location.href = "{{ route('f.reservation', ['uuid' => $reservation->uuid ?? '']) }}";
                    }
                }
            });


        });
    })(jQuery);

        /*
            var orderComplete = function(clientSecret) {
                stripe.retrievePaymentIntent(clientSecret).then(function(result) {
                    var paymentIntent = result.paymentIntent;
                    var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);
                    document.querySelectorAll(".payment-view").forEach(function(view) {
                        view.classList.add("hidden");
                    });
                    document.querySelectorAll(".completed-view").forEach(function(view) {
                        view.classList.remove("hidden");
                    });
                    document.querySelector(".hold-status").textContent =
                        paymentIntent.status === "requires_capture"
                        ? "successfully placed" : "did not place";
                    document.querySelector("pre").textContent = paymentIntentJson;
                });
            };

            var changeLoadingState = function(isLoading) {
                if (isLoading) {
                    $("button").disabled = true;
                    $("#spinner").classList.remove("hidden");
                    $("#button-text").classList.add("hidden");
                } else {
                    $("button").disabled = false;
                    $("#spinner").classList.add("hidden");
                    $("#button-text").classList.remove("hidden");
                }
            };
        */
    </script>
@endsection
