@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_travel_history')}} @parent @endsection
@section('body')
@csrf
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <h1>{{ trans('txt.current_trips_title') }}</h1>
                @if ($reservationsCurrent->count() < 1)
                <span >

                        {{ trans('txt.current_trips_description') }}
                </span>
                @endif
                @foreach($reservationsCurrent as $reservation)
                    @php
                        $hotel = $reservation->hotel()->get()->first();
                    @endphp
                    <div class="listing-item listing-item_small clearfix">
                        <div class="listing-item_left">
                            <img src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/200x170 @endif" class="img-desktop" width="170" height="120"/>
                            <img src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif" class="img-mobile"/>
                        </div>
                        <div class="listing-item_middle">
                            <h2> {{ $hotel->name }}</h2>
                            <h3 class="waiting-time-history">
                                {{ trans('txt.det_checkin_title') }}:
                                <strong>{{ $reservation->checkin_date->format('M d, Y') }}</strong><br/>
                                {{ trans('txt.det_checkout_title') }}:
                                <strong>{{ $reservation->checkout_date->format('M d, Y') }}</strong>
                            </h3>
                        </div>
                        <div class="listing-item_right listing-item_right">
                            <div class="right-bottom-wrapper">
                                <a href="{{ route('f.reservation', ['uuid'=> $reservation->uuid ]) }}" class="pay-finish-button mg-tertiary-button status_declined">{{ trans('txt.details') }}
                                    <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <br>
                <h1>{{ trans('txt.past_trips_title') }}</h1>
                @if ($reservationsPast->count() < 1)
                    <span >
                        {{ trans('txt.past_trips_description') }}
                    </span>
                 @endif
                    @foreach($reservationsPast as $reservation)
                        @php
                            $hotel = $reservation->hotel()->get()->first();
                        @endphp
                        <div class="listing-item listing-item_small clearfix">
                            <div class="listing-item_left">
                                <img src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/200x170 @endif" class="img-desktop" width="170" height="120"/>
                                <img src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif" class="img-mobile"/>
                            </div>
                            <div class="listing-item_middle">
                                <h2> {{ $hotel->name }}</h2>
                                <h3 class="waiting-time-history">
                                    {{ trans('txt.det_checkin_title') }}:
                                    <strong>{{ $reservation->checkin_date->format('M d, Y') }}</strong><br/>
                                    {{ trans('txt.det_checkout_title') }}:
                                    <strong>{{ $reservation->checkout_date->format('M d, Y') }}</strong>
                                </h3>
                            </div>
                            <div class="listing-item_right listing-item_right">
                                <div class="right-bottom-wrapper">
                                    <a href="{{ route('f.invoice', ['uuid'=> $reservation->uuid ]) }}" class="mg-tertiary-button status_declined">{{ trans('txt.title_view_receipt') }}
                                        <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="pagination float-right">
                        {!! $reservationsPast->render() !!}
                    </div>
            </div>
        </div>
        </div>
    </div>
@endsection
