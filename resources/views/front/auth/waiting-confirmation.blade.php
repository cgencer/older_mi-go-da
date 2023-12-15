@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_waiting_confirmation')}} @parent @endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <h1 class="d-inline ">{{ trans('txt.pending_reservations_title') }}</h1>
                <div class="waiting-filter d-inline float-right">
                    <form  action="{{ route('auth.reservation-status') }}" method="POST" >
                        <select name="status" class="select2 form-control " data-dropdownCssClass="country-select2" onchange="this.form.submit()">
                            <option value="" {{ $status == "all" ? "selected": "" }} >{{ trans('txt.travel-filter-all') }}</option>
                            <option value="1" {{ $status == 1 ? "selected": "" }} >{{ trans('txt.travel-filter-accepted') }}</option>
                            <option value="0" {{ $status == "0" ? "selected": "" }} >{{ trans('txt.travel-filter-waiting') }}</option>
                            <option value="2" {{ $status == 2 ? "selected": "" }} >{{ trans('txt.travel-filter-rejected') }}</option>
                        </select>
                    </form>
                </div>

                <h3 class="submessage mt-2">{{ trans('txt.pending_reservations_note') }}

                </h3>
                @foreach($reservations as $reservation)
                    @php
                        $statusShortcode = $reservation->getStatusShortcode();
                            $hotel = $reservation->hotel()->get();
                    @endphp
                    @if ($hotel->count())
                        @php
                            $hotel = $hotel->first();
                        @endphp
                        <div class="listing-item listing-item_small clearfix listing-item_small_{{ $statusShortcode }}">
                            <div class="listing-item_left">
                                <img
                                    src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/200x170 @endif"
                                    class="img-desktop" width="170" height="140"/>
                                <img
                                    src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif"
                                    class="img-mobile"/>
                            </div>
                            <div class="listing-item_middle">
                                <h2> {{ $hotel->name }}</h2>
                                <h3 class="waiting-time-history">
                                    {{ trans('txt.det_checkin_title') }}:
                                    <strong>{{ $reservation->checkin_date->format('M d, Y') }}</strong><br>
                                    {{ trans('txt.det_checkout_title') }}:
                                    <strong>{{ $reservation->checkout_date->format('M d, Y') }}</strong>
                                </h3>
                                <h3>
                                    <strong>{{ trans('txt.status') }} :
                                    <span class="{{ $statusShortcode }}">{{ trans('txt.'.\Illuminate\Support\Str::slug($reservation->getStatusByCode(),'-')) }}</span>&nbsp;</strong>
                                    @if ($statusShortcode == 'waiting')
                                        <img width="20" src="{{ asset('front/assets/images/svg/wait.svg') }}"  alt="">
                                    @elseif ($statusShortcode == 'declined' || $statusShortcode == 'error')
                                        <img width="20" src="{{ asset('front/assets/images/svg/wrong.svg') }}" alt="">
                                    @elseif($statusShortcode == 'ready'  )
                                        <img width="20" src="{{ asset('front/assets/images/svg/correct.svg') }}"   alt="">
                                    @endif
                                </h3>

                            </div>
                            <div class="listing-item_right">
                                <div class="right-bottom-wrapper">
                                    @if ($statusShortcode == 'waiting')
                                        <a href="#" class="mg-tertiary-button status_waiting"
                                           disabled="disabled">{{ trans('txt.pay_and_finish_button') }}
                                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
                                    @elseif ($statusShortcode == 'ready' || $statusShortcode == 'error')
                                        {{-- @open(['route' => 'f.payment', 'layout' => 'inline', 'method' => 'POST'])
                                        @hidden('uuid', $reservation->uuid) --}}
                                        {{-- @submit(trans('txt.pay_and_finish_button'), 'pay-finish-button mg-tertiary-button status_ready
                                        success') --}}
                                        <form style="width: 100%;height: 100%;" action="{{ route('f.payment') }}" method="POST">
                                            @hidden('uuid', $reservation->uuid)
                                             <a onclick="$(this).closest('form').submit();" href="#" class="pay-finish-button mg-tertiary-button" style="display:block">{{ trans('txt.title_pay_and_finish') }}
                                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
                                        {{-- @close --}}
                                    </form>
                                    @elseif ($statusShortcode == 'declined')
                                        <a href="{{ route('f.destinations') }}"
                                           class="mg-tertiary-button status_declined">{{ trans('txt.search_destinations_button') }}
                                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
                                    @elseif ($statusShortcode == 'error')
                                        @open(['route' => 'f.payment', 'layout' => 'inline', 'method' => 'POST'])
                                        @hidden('uuid', $reservation->uuid)
                                        @submit(trans('txt.pay_and_finish_button'), 'mg-tertiary-button status_ready
                                        success')
                                        @close
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="pagination float-right">
                    {!! $reservations->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection



@section('javascripts')

<script>
     $('.select2').select2();
</script>

@endsection
