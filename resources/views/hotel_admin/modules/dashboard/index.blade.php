@extends('hotel_admin.layouts.master')
@php

    date_default_timezone_set(date_default_timezone_get());
        $hotelUser = Auth::guard('user')->user();
        $profile_image = $hotelUser->getMedia('profile_image')->first();
          $Hour = date('G:i');

          if ( $Hour >= 02 && $Hour <= 11 ) {
              $welcomeMessage = trans('txt.good_morning');
              $welcomeMessage2 = trans('txt.good_morning_welcome_message');
          } else if ( $Hour >= 12 && $Hour <= 17 ) {
              $welcomeMessage = trans('txt.good_afternoon');
              $welcomeMessage2 = trans('txt.good_afternoon_welcome_message');
          } else if ( $Hour >= 18 || $Hour <= 01 ) {
              $welcomeMessage =  trans('txt.good_evening');
              $welcomeMessage2 =  trans('txt.good_evening_welcome_message');
          }
@endphp
@section('title'){{trans('txt.dashboard')}} | @parent @endsection
@section('scripts')
    <script src="{{ asset('admin/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/analytical.js') }}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            $(".approveButton").click(function () {
                var actionUrl = '{{route('hotel_admin.reservations.setReservationStatus')}}?reservationId=' + $(this).attr('data-id') + '&status=1'
                $(".approveLink").attr('href', actionUrl);
                $("#reservationCheckinDate").text($(this).attr('data-checkin'));
                $("#reservationCheckoutDate").text($(this).attr('data-checkout'));
                $("#couponHolder").text($(this).attr('data-coupon'));
                $("#numberOfGuests").text($(this).attr('data-guests'));
            });
            $(".declineLink").click(function (e) {
                var rejectDesc = $(".rejectDesc").val();
                var rejectVal = $('input[name=rejectReason]:checked', '.rejectForm').val()
                var actionUrl = '{{route('hotel_admin.reservations.setReservationStatus')}}?reservationId=' + $(this).attr('data-id') + '&status=2&rejectVal=' + rejectVal + '&rejectDesc=' + rejectDesc;
                if ( rejectVal == "") {
                    swal({
                        title: '{{trans('txt.error')}}',
                        text: "{{  trans('txt.reservation_cancel_error') }}",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    });
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                $(".declineLink").attr('href', actionUrl);
            });

            $(".declineButton").click(function () {
                $(".declineLink").attr('data-id', $(this).attr('data-id'));
                $(".rejectDesc").val($(this).attr('data-otherreason'));
            });
        });
    </script>
@endsection
@php
    $allReservations = $hotelUser->hotel_reservations();
@endphp
@section('content')
    <div class="modal fade" id="modal-approve">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="p-15 m-v-40">
                        <div class="row ">
                            <div class="col-md-12">
                                <p class="lead">{{ trans('txt.dear') }} {{mb_strtoupper($hotelUser->name)}}!</p>
                                <p class="m-b-25">
                                    Migoda Coupon Holder Mr(s)
                                    <span id="couponHolder">XX.XX.XXXX</span> would be delighted to stay with you wilth
                                    <span id="numberOfGuests">XX.XX.XXXX</span> guests from
                                    <span id="reservationCheckinDate">XX.XX.XXXX</span> to
                                    <span id="reservationCheckoutDate">XX.XX.XXXX</span> in your hotel. According to
                                    your calendar you show these dates available. Please accept or decline this booking
                                    request.
                                </p>
                                <a href="#" class="btn btn-gradient-success approveLink" role="button"
                                   aria-pressed="true">
                                    <i class="mdi mdi-approval m-r-5"></i>{{ trans('txt.accept') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-decline">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="p-15 m-v-40">
                        <div class="row ">
                            <div class="col-md-12">
                                <p class="lead" style="padding-left: 28px;">{{ trans('txt.reason_of_rejection') }}</p>
                                <form class="rejectForm">
                                    @php
                                        $reasons = \App\Models\Features::where('type','reason')->get()->pluck('name','id')->toArray();
                                    @endphp
                                    @foreach($reasons as $reasonId => $reason)
                                        <div class="radio">
                                            <input id="radio_{{ $reasonId }}" name="rejectReason" type="radio"
                                                   value="{{ $reasonId }}"/>
                                            <label for="radio_{{ $reasonId }}">{{ $reason }}</label>
                                        </div>
                                    @endforeach
                                    <div class="form-group" style="padding-left:20px">
                                        <input type="text" class="form-control rejectDesc" name="rejectDesc"
                                               placeholder="{{ trans('txt.your_description') }}">
                                    </div>
                                    <a href="#" class="btn btn-gradient-success declineLink" role="button"
                                       aria-pressed="true" style="margin-left:20px">
                                        <i class="mdi mdi-approval m-r-5"></i>{{ trans('txt.decline') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">

        <div class="container-fluid">
            @include('admin.partials.notifications')

            @if ($hotelUser->hotels[0]->is_verified == 0)
            <div class="row reminder-content " >
                <div class="block right-block">
                    <h2 class="reminder-title mb-0 ">
                        {!! trans('txt.register_bar_title') !!}
                    </h2>
                </div>
                <div class="block d-flex left-block">
                    <div>
                        <div class="reminder-subtitle">
                            <div>1</div>
                            {!! trans('txt.upload_contract_text') !!}
                        </div>
                        <div class="reminder-button">
                            <img width="25" class="tick" src="{{ asset('front/assets/images/pasive_tick.png') }}" alt="">
                            <a href="{{ url('hotel/documents/add/document') }}" class="contract-button">
                                {!! trans('txt.upload_contract_button') !!}
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="reminder-subtitle">
                            <div>2</div>
                            {!! trans('txt.add_stripe_account_text') !!}
                        </div>
                        <div class="reminder-button">
                            <img width="25" class="tick" src="{{ asset('front/assets/images/pasive_tick.png') }}" alt="">
                            <a href="#" class="">
                                 {!! trans('txt.add_stripe_account_button') !!}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="col-md-9">
                        <h1 class="welcomeMessage">{{ $welcomeMessage }} {{ $hotelName }}.</h1>
                        <h3 class="welcomeMessage2">{{ $welcomeMessage2 }}</h3>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12" style="margin-bottom: 30px; ">
                    <div class="col-md-3 floatedLeft boxItemContainer" style="padding-left: 0px;">
                        <a href="{{route('hotel_admin.dashboard')}}" class="boxHover1">
                            <div class="boxItem  {{ Request::get('status') == "" ? "activeBox": "" }} ">
                                <span class="boxTitleSpan">{{trans('txt.all_reservations')}}</span> <span class="count">
                        {{$allReservations->get()->count()}}
                    </span> <img class="boxIcon1" src="{{asset('admin/assets/images/admin/reservationsIcon1.png')}}">
                                <img class="boxIcon" src="{{asset('admin/assets/images/admin/reservationsIcon2.png')}}">
                            </div>
                        </a>
                    </div>
                    @php
                        $newQuery = clone $allReservations;
                    @endphp
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('hotel_admin.dashboard')}}?status={{\App\Models\Reservation::STATUS_WAITING}}"
                           class="boxHover1">
                            <div class="boxItem {{ Request::get('status') == "0" ? "activeBox": "" }} ">
                                <span class="boxTitleSpan">{{trans('txt.pending')}}</span> <span class="count">
                                    {{$newQuery->where('status', \App\Models\Reservation::STATUS_WAITING)->get()->count()}}
                    </span>
                                <img class="boxIcon1"
                                     src="{{asset('admin/assets/images/admin/pendingReservationsIcon1.png')}}">
                                <img class="boxIcon"
                                     src="{{asset('admin/assets/images/admin/pendingReservationsIcon.png')}}">
                            </div>
                        </a>
                    </div>
                    @php
                        $newQuery = clone $allReservations;
                    @endphp
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('hotel_admin.dashboard')}}?status={{\App\Models\Reservation::STATUS_APPROVED}}"
                           class="boxHover1">
                            <div class="boxItem {{ Request::get('status') == 1 ? "activeBox": "" }} ">
                                <span class="boxTitleSpan">{{trans('txt.confirmed')}}</span> <span class="count">
                            {{$newQuery->whereIn('status', [1, 3])->get()->count()}}
                        </span>
                                <img class="boxIcon1"
                                     src="{{asset('admin/assets/images/admin/confirmedReservationsIcon1.png')}}">
                                <img class="boxIcon"
                                     src="{{asset('admin/assets/images/admin/confirmedReservationsIcon.png')}}">
                            </div>
                        </a>
                    </div>
                    @php
                        $newQuery = clone $allReservations;
                    @endphp
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('hotel_admin.dashboard')}}?status={{\App\Models\Reservation::STATUS_CANCELED}}"
                           class="boxHover1">
                            <div class="boxItem {{ Request::get('status') == 2 ? "activeBox": "" }} ">
                                <span class="boxTitleSpan">{{trans('txt.cancelled')}}</span> <span class="count">
                                {{$newQuery->whereIn('status', [5, 6, 7, 8])->get()->count()}}
                    </span>
                                <img class="boxIcon1"
                                     src="{{asset('admin/assets/images/admin/cancelledReservationsIcon1.png')}}">
                                <img class="boxIcon"
                                     src="{{asset('admin/assets/images/admin/cancelledReservationsIcon.png')}}">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="dataTableHeader">
                                @switch(Request::get('status'))
                                    @case("0")
                                    {{trans('txt.pending_reservations')}}
                                        @break
                                    @case(1)
                                    {{trans('txt.confirmed_reservations')}}
                                        @break
                                    @case(2)
                                    {{trans('txt.cancelled_reservations')}}
                                        @break
                                    @default
                                    {{trans('txt.all_reservations')}}
                                @endswitch
                            </h1>
                            <div class="table-overflow table-responsive" style="margin-top: 40px;">
                                <table id="dt-opt" class="table table-hover table-xl">
                                    <thead class="dataTableHead">
                                    <tr>
                                        <th style="width: 18%">
                                            Res No
                                        </th>
                                        <th>{{ trans('txt.check_in') }}</th>
                                        <th>{{ trans('txt.check_out') }}</th>
                                        <th class="text-capitalize">{{ trans('txt.guest') }}</th>
                                        <th>{{ trans('txt.status') }}</th>
                                        <th>{{ trans('txt.action_time') }}</th>
                                        <th style="min-width: 145px"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="dataTableBody">
                                    @php

                                      $status = Request::get('status');
                                      $newQuery = clone $allReservations;
                                        if (isset($status)) {
                                            if ($status == "0") {
                                                $allReservationsData = $newQuery->where('status', $status)->orderBy('checkin_date', 'desc')->get()->paginate(20);
                                            }else if($status == 1){
                                                $allReservationsData = $newQuery->whereIn('status', [1, 3])->orderBy('checkin_date', 'desc')->get()->paginate(20);
                                            }else if($status == 2){
                                                $allReservationsData = $newQuery->whereIn('status', [2, 5, 6, 7, 8])->orderBy('created_at', 'desc')->get()->paginate(20);
                                            }
                                        }else{
                                            $allReservationsData = $newQuery->whereIn('status', ['0', '1', '2','3', '4', '5', '6' , '7' , '8'])->orderByRaw(\DB::raw("FIELD(status , '0', '1', '2','3', '4', '5', '6' , '7' , '8')"))->orderBy('checkin_date', 'desc')->get()->paginate(20);
                                        }

                                    @endphp
                                    @foreach($allReservationsData as $reservation)
                                        @php
                                            $customer = $reservation->customer()->get()->first();
                                            $resStatus = \App\Helpers::hoursRemaining($reservation->created_at->format('Y/m/d h:m:s'));
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{route('hotel_admin.reservations.show',['id'=>$reservation->id])}}"
                                                   class="resLink">Res {{$reservation->id}}</a>
                                            </td>
                                            <td>{{$reservation->checkin_date->format('d-m-Y')}}</td>
                                            <td>{{$reservation->checkout_date->format('d-m-Y')}}</td>
                                            <td>
                                                <div class="list-media">
                                                    <div class="list-item">
                                                        <div class="info p-l-0 min-vh-0">
                                                            <span
                                                                class="title">{{$customer->firstname.' '. \Illuminate\Support\Str::substr($customer->lastname,0,1).'.'}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                    @if ($reservation->status == 0)
                                                        <span class="dot waitingStatus"></span>
                                                        <span class="waitingText">{{ trans('txt.waiting') }}</span>
                                                    @elseif ($reservation->status == 1)
                                                        <span class="dot approvedStatus"></span>
                                                        <span class="approvedText">{{ trans('txt.approved') }}</span>
                                                    @elseif ($reservation->status == 2)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span class="cancelledText">{{ trans('txt.declined') }}</span>
                                                    @elseif ($reservation->status == 3)
                                                        <span class="dot approvedStatus"></span>
                                                        <span class="approvedText">{{ trans('txt.paid') }}</span>
                                                    @elseif ($reservation->status == 4)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span    class="cancelledText">{{ trans('txt.payment_error') }}</span>
                                                    @elseif ($reservation->status == 5)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span class="cancelledText">{{ trans('txt.user-canceled-after-expiration') }}</span>
                                                    @elseif ($reservation->status == 6)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span class="cancelledText">{{ trans('txt.user-canceled-before-expiration') }}</span>
                                                    @elseif ($reservation->status == 7)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span class="cancelledText">{{ trans('txt.res_expired_customer') }}</span>
                                                    @elseif ($reservation->status == 8)
                                                        <span class="dot cancelledStatus"></span>
                                                        <span class="cancelledText">{{ trans('txt.res_expired_hotel') }}</span>
                                                    @elseif ($reservation->status == 9)
                                                        <span class="dot approvedStatus"></span>
                                                        <span class="approvedText">{{ trans('txt.res_finished') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($reservation->status == 0 && $resStatus != -1)
                                                    <div class="actionTime">
                                                        <span>
                                                                {{ $resStatus }}
                                                        </span>
                                                    </div>
                                                @else
                                                    {{ $reservation->created_at->format('d-m-Y') }}
                                                @endif
                                            </td>
                                            <td class="text-center font-size-18">
                                                @if ($resStatus != -1 && $reservation->status == 0)
                                                    <a href="" class="text-gray m-r-15 approveButton"
                                                       data-id="{{ $reservation->id }}"
                                                       data-checkin="{{$reservation->checkin_date->format('d F Y')}}"
                                                       data-checkout="{{$reservation->checkout_date->format("d F Y") }}"
                                                       data-coupon="{{ \Illuminate\Support\Str::upper($customer->firstname.' '.$customer->lastname) }}"
                                                       data-guests="{{ $reservation->guest_adult + $reservation->guest_child}}"
                                                       data-toggle="modal" data-target="#modal-approve">
                                                        <img
                                                            src="{{asset('admin/assets/images/admin/approveButton.png')}}"/>
                                                    </a>
                                                    <a href="" class="text-gray declineButton"
                                                       data-id="{{ $reservation->id }}"
                                                       data-otherreason="{{ $reservation->other_reason }}"
                                                       data-toggle="modal" data-target="#modal-decline">
                                                        <img
                                                            src="{{asset('admin/assets/images/admin/declineButton.png')}}"/>
                                                    </a>
                                                @else
                                                    <a href="{{route('hotel_admin.reservations.show',['id'=>$reservation->id])}}"
                                                       class="text-gray m-r-15">
                                                        <img src="{{asset('admin/assets/images/admin/details.png')}}"/>
                                                        <span class="detailsLink">{{ trans('txt.details') }}</span> </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div class="paginate-hotel float-right">
                                        {!! $allReservationsData->appends(request()->except('page'))->links() !!}
                                    </div>
                                <div class="reservationExplanation">
                                    <p>{{ trans('txt.admin_cancelled_text1') }}</p>
                                    <p>{{ trans('txt.admin_cancelled_text2') }}</p>
                                    <p>{{ trans('txt.admin_cancelled_text3') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade {{ $isRegister == 0 && $isVerified == 0 ? "show": "" }}" style="display:{{ $isRegister == 0 && $isVerified == 0 ? "block" : "none" }}"  data-backdrop="static" id="hotelWelcomeModal" tabindex="-1" role="dialog"    aria-labelledby="hotelWelcomeTitle" aria-hidden="true" >

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                {{-- <h3>{{ trans("txt.popup_enter_coupon_code_title") }}</h3> --}}
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12  modal-content-left">
                        </div>
                        <div class="col-lg-6 col-md-12   modal-content-right">

                            <h1 class="modal-title">{{ trans('txt.register_modal_title') }}</h1>
                            <h2 class="modal-subtitle">{{ trans('txt.register_modal_subtitle') }}</h2>
                                @if ($errors->any())
                                <div class="alert alert-danger migoda-alert alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <div class="mg-section mg-group">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('hotel_admin.hotels.create-new-password') }}" method="POST">
                                @csrf
                                <div class="password-form">
                                    <div class="form-input">
                                        {!! Form::hidden('hotel_id', Auth::guard('user')->user()->id) !!}
                                        {!! Form::password('password', ['placeholder'=>  trans('txt.field_create_password'), 'id' => 'password' ], null) !!}
                                        <br>
                                        <span class="minimum-pass-length">({{ trans('txt.minimum_password_length') }})</span>
                                    </div>
                                    <div class="form-input">
                                        {!! Form::password('password_repeat', ['placeholder'=>trans('txt.field_repeat_password') , 'id' => 'password_repeat' ], null) !!}
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline settings-check">
                                            <input type="checkbox" id="newsletter"  name="terms_conditions" class="faChkSqr">
                                            <label for="newsletter"> </label>
                                                <span>{!! trans('txt.hotel_signup_terms_conditions_accept', ['terms' => "https://www.migodahotels.com/terms-and-conditions/"]) !!}, {!! trans('txt.hotel_signup_privacy_conditions_accept', ['terms' => " https://www.migodahotels.com/data-protection/"]) !!},  {!! trans('txt.hotel_signup_cookie_conditions_accept', ['terms' => "https://www.migodahotels.com/cookie-policy/"]) !!},
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit">{{ trans('txt.create_your_account_title') }}</button>
                                    </div>
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="mg-primary-button__disabled handButton addCouponsModalButton"  disabled="disabled">{{ trans("txt.password") }}</button>
            </div> --}}
        </div>
    </div>
</div>


@endsection

@section('styles')

<style>


    #hotelWelcomeModal .modal-body,.container{
        padding: unset!important;
}
    .modal-title{
        color: #858890;
        font-family: "Futura ND Demibold";
        font-size: 29px;
        font-weight: 500;
        line-height: 37px;
        text-align: left;

    }
    .modal-content-right{
        padding: 90px 70px 0px 50px;
    }
    .modal-subtitle{
        color: #858890;
        font-family: "Futura ND Book";
        font-size: 16px;
        font-weight: 300;
        font-style: normal;
        letter-spacing: normal;
        line-height: 26px;
        text-align: left;
        margin-top: 20px

    }

    .password-form{
        margin-top: 50px;
    }

    .password-form .form-input input {
    width: 90%;
    border: 0;
    border-bottom: 1px solid #ededed;
    font-size: 0.9rem;
    font-family: "Futura ND Light", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}

    .password-form input {
        background: none;
        margin: 10px 0
    }

    #password{
        margin-bottom: 0!important;
    }

    .minimum-pass-length{
        font-family: "Futura ND Light", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 13px;
    }

    .settings-check:nth-child(2){
    margin-left: 100px;
    }
    .settings-check span{
        color: #afafaf;
        font-size: 12px;
        padding-left: 10px;
        font-family: "Futura ND Light", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        margin: 20px 0
    }
    .settings-check  input[type=checkbox] {
        display: none;
    }

    .settings-check  input[type=checkbox] + label {
        display: block;
        padding-left: 0;
        min-width: 30px;
        padding: 10px;
        min-height: 18px;
        margin-bottom: 5px;
        cursor: pointer;
    }
    .settings-check input[type=checkbox] + label {
        background: url(../images/checkbox.png) right bottom no-repeat;
    }

    .settings-check input[type=checkbox] + label:hover {
        background: url(../images/checkbox.png) right top no-repeat;
    }

    .settings-check input[type=checkbox] + label:active {
        background: url(../images/checkbox.png) right top no-repeat;
    }

    .settings-check input[type=checkbox]:checked + label {
        background: url(../images/checkbox.png) right top no-repeat;
    }

    .settings-checkinput[type=checkbox]:checked + label:active {
        background: url(../images/checkbox.png) right top no-repeat;
    }

    .settings-checkinput[type=checkbox]:disabled + label {
        background: none left top no-repeat;
    }

    .settings-check input[type=checkbox]:disabled:checked + label {
        background: none left top no-repeat;
    }

     .settings-check .terms-check input[type=checkbox] + label {
        display: inline-block;
        padding-left: 0;
        min-width: 30px;
        padding: 10px;
        min-height: 18px;
        cursor: pointer;
    }
    .settings-check a {
        vertical-align: top;
        color: #bababa!important;
        font-size: 12px;
        text-decoration: underline
    }

    .password-form button{
        width: 100%;
        height: 40px;
        color: #fff;
        border: unset;
        border-radius: 10px;
        background-image: linear-gradient(63deg, #fdbe67 0%, #fa9d7e 0%, #fdbe67 0%, #fdbe67 0%, #f67b95 36%, #ef32c6 100%);
        box-shadow: 0px 2px 8px 0px #ccc;
    }

    #hotelWelcomeModal {
        background-color: rgb(0 0 0 / 58%);
    }

    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }

    .reminder-content{

        display: flex;
        justify-content: space-between;
        overflow: hidden;
        position: relative;
        padding: 1rem 2rem 1rem 2rem;
        margin: 5px 5px 30px 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
        border-radius: 10px;
        background-image: linear-gradient(84deg, #ffd359 -14%, #ffd359 -8%, #fba777 6%, #f67b95 31%, #ef32c6 103%);

    }

    .reminder-content:before {
        position: absolute;
        z-index: 0;
        right: 0;
        top: 0;
        left: 0;
        content: url("data:image/svg+xml,%0A%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='120' viewBox='0 0 78 44'%3E%3Cg%3E%3Cg clip-path='url(%23clip-88136a3f-a1a4-47bd-a8a5-2f284002f925)' opacity='.2'%3E%3Cpath fill='%23fff' d='M14.006 15.579a6.98 6.98 0 0 1-3.915-9.068 6.984 6.984 0 1 1 3.915 9.068zm46.703 8.515c-3.57-1.417-5.333-5.497-3.915-9.067l13.731-34.62c1.417-3.567 5.497-5.333 9.068-3.916 3.57 1.418 5.332 5.498 3.915 9.068L69.776 20.176c-1.085 2.735-3.73 4.407-6.511 4.407a6.928 6.928 0 0 1-2.556-.489zm-6.866 17.309a6.984 6.984 0 0 1-3.915-9.068 6.98 6.98 0 0 1 9.064-3.914 6.985 6.985 0 0 1-2.577 13.475 6.968 6.968 0 0 1-2.572-.493zM27.059 45.8c-3.57-1.414-5.332-5.494-3.915-9.065l13.731-34.62c1.414-3.57 5.494-5.332 9.068-3.915 3.57 1.418 5.328 5.498 3.914 9.064l-13.734 34.62c-1.085 2.733-3.727 4.406-6.507 4.406-.853 0-1.72-.158-2.557-.49zM-6.595 67.508c-3.57-1.417-5.329-5.497-3.915-9.067L3.222 23.824c1.418-3.57 5.494-5.333 9.068-3.915 3.57 1.414 5.332 5.494 3.914 9.064L2.473 63.593C1.388 66.325-1.253 68-4.035 68c-.854 0-1.72-.158-2.56-.49z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .reminder-title{
    color: #ffffff;
    font-family: "Futura ND Demibold";
    font-size: 29px;
    font-weight: 500;
    line-height: 28px;
    }

    .reminder-title span{
        font-size: 19px;
    }

    .reminder-subtitle{
        color: #ffffff;
        font-family: "Futura ND Demibold";
        font-size: 17px;
        font-weight: 500;
        font-style: normal;
        letter-spacing: normal;
        line-height: 33px;
    }


    .reminder-subtitle div{
        display: inline-block;
        text-align: center;
        width: 30px;
        height: 30px;
        color: #77848f;
        border-radius: 50%;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        margin-right: 5px;
        background-color: #ffffff;
    }

    .reminder-button img.tick{
        opacity: 0.5;
        margin-right: 10px;

    }

    .reminder-button img{
        padding-right: 10px;
    }

    .reminder-button a{
        display: inline-block;
        margin-top: 10px;
        margin-bottom: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
        background-color: #ffffff;
        padding: 10px 25px 8px 25px;
        color: #595e67;
        font-family: "Futura ND Demibold";
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.42px;
        line-height: 14px;

    }

    .block{
        z-index: 1;
    }

    .left-block{
        column-gap: 40px;
    }

    .right-block{
        display: flex;
        align-items: center;
        padding-top: 10px;
    }

    .reminder-button a {
    background-image: url('{{ asset('front/assets/images/svg/connect.svg') }}');
    background-repeat: no-repeat;
    background-position: 5px 10px;
    }


    .contract-button {
        background-image: url('{{ asset('front/assets/images/svg/upload.svg') }}')!important;
    }

    .modal-content-left{
        background-image: url('{{ asset('admin/assets/images/others/welcome-hotel.png ') }}');
        background-size: cover;
    }



    @media all and (max-width: 500px) {

        .left-block{
            flex-direction: column;
            row-gap: 20px;
        }

        h1.welcomeMessage{
            line-height: 50px;
        }

        .floatedLeft{
            padding: 20px 0;
        }

    }

    @media all and (max-width: 1300px) {

            .right-block{
                padding-top: 15px;
            }

            .reminder-content{
                row-gap: 25px!important;
            }

            .reminder-content:before {
                position: absolute;
                z-index: 0;
                right: 0;
                top: -60px;
                left: 10px;
                content: url("{{ asset('front/assets/images/lightgallery/migoda-bg.png') }}");
                opacity: .3;
            }

        }

        @media all and (max-width: 1350px) {

            .reminder-title{
                font-size: 25px!important;
            }
            .reminder-title span{
                font-size: 15px!important;
            }

            .reminder-content{
                row-gap: 25px!important;
                /* padding-left: 30px!important; */

            }


        }

        @media all and (max-width: 650px)
        {
            .reminder-button a {
                font-size: 12px;
            }

            .reminder-title {
            font-size: 25px;
            }

            .reminder-title span{
                font-size: 15px!important;
            }

            h1.welcomeMessage{
            line-height: 50px;
            }

            .floatedLeft{
                padding: 20px 0;
            }
        }

        @media all and  (max-width: 1024px){
                    .modal-content-left {
                    display:none;
                }
            }

/*
    @media all and (max-width: 768px) {

        .reminder-content{
            margin-bottom: 30px;
            height: 260px;
            display: block;
        }

        .reminder-content .col-md-6{
            display: block;
            max-width: 100%;
        }
        .reminder-content .col-md-3{
            display: inline-block;
            max-width: 50%;
        }




        .reminder-content:before {
        position: absolute;
        z-index: 0;

        right: 25%;
        left: 0%;
        content: url("data:image/svg+xml,%0A%3Csvg xmlns='http://www.w3.org/2000/svg' width='500' height='320' viewBox='0 0 78 44'%3E%3Cg%3E%3Cg clip-path='url(%23clip-88136a3f-a1a4-47bd-a8a5-2f284002f925)' opacity='.2'%3E%3Cpath fill='%23fff' d='M14.006 15.579a6.98 6.98 0 0 1-3.915-9.068 6.984 6.984 0 1 1 3.915 9.068zm46.703 8.515c-3.57-1.417-5.333-5.497-3.915-9.067l13.731-34.62c1.417-3.567 5.497-5.333 9.068-3.916 3.57 1.418 5.332 5.498 3.915 9.068L69.776 20.176c-1.085 2.735-3.73 4.407-6.511 4.407a6.928 6.928 0 0 1-2.556-.489zm-6.866 17.309a6.984 6.984 0 0 1-3.915-9.068 6.98 6.98 0 0 1 9.064-3.914 6.985 6.985 0 0 1-2.577 13.475 6.968 6.968 0 0 1-2.572-.493zM27.059 45.8c-3.57-1.414-5.332-5.494-3.915-9.065l13.731-34.62c1.414-3.57 5.494-5.332 9.068-3.915 3.57 1.418 5.328 5.498 3.914 9.064l-13.734 34.62c-1.085 2.733-3.727 4.406-6.507 4.406-.853 0-1.72-.158-2.557-.49zM-6.595 67.508c-3.57-1.417-5.329-5.497-3.915-9.067L3.222 23.824c1.418-3.57 5.494-5.333 9.068-3.915 3.57 1.414 5.332 5.494 3.914 9.064L2.473 63.593C1.388 66.325-1.253 68-4.035 68c-.854 0-1.72-.158-2.56-.49z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    }

    @media all and (max-width: 1520px) {

        .reminder-content{
            margin-bottom: 30px;
            height: 260px;
            display: block;
        }

        .reminder-content .col-md-6{
            display: block;
            max-width: 100%;
        }
        .reminder-content .col-md-3{
            display: inline-block;
            max-width: 50%;
        }


        .reminder-content:before {
        position: absolute;
        right: 25%;
        left: 0%;
        content: url("data:image/svg+xml,%0A%3Csvg xmlns='http://www.w3.org/2000/svg' width='500' height='320' viewBox='0 0 78 44'%3E%3Cg%3E%3Cg clip-path='url(%23clip-88136a3f-a1a4-47bd-a8a5-2f284002f925)' opacity='.2'%3E%3Cpath fill='%23fff' d='M14.006 15.579a6.98 6.98 0 0 1-3.915-9.068 6.984 6.984 0 1 1 3.915 9.068zm46.703 8.515c-3.57-1.417-5.333-5.497-3.915-9.067l13.731-34.62c1.417-3.567 5.497-5.333 9.068-3.916 3.57 1.418 5.332 5.498 3.915 9.068L69.776 20.176c-1.085 2.735-3.73 4.407-6.511 4.407a6.928 6.928 0 0 1-2.556-.489zm-6.866 17.309a6.984 6.984 0 0 1-3.915-9.068 6.98 6.98 0 0 1 9.064-3.914 6.985 6.985 0 0 1-2.577 13.475 6.968 6.968 0 0 1-2.572-.493zM27.059 45.8c-3.57-1.414-5.332-5.494-3.915-9.065l13.731-34.62c1.414-3.57 5.494-5.332 9.068-3.915 3.57 1.418 5.328 5.498 3.914 9.064l-13.734 34.62c-1.085 2.733-3.727 4.406-6.507 4.406-.853 0-1.72-.158-2.557-.49zM-6.595 67.508c-3.57-1.417-5.329-5.497-3.915-9.067L3.222 23.824c1.418-3.57 5.494-5.333 9.068-3.915 3.57 1.414 5.332 5.494 3.914 9.064L2.473 63.593C1.388 66.325-1.253 68-4.035 68c-.854 0-1.72-.158-2.56-.49z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
}

@media (max-width: 1024px){
            .modal-content-left {
            display:none;
        }
    }

    @media (min-width: 768px){
            .modal-lg {
            max-width: 920px!important;
        }
    }

    @media all and (max-width: 650px) {
            .reminder-subtitle{
                font-size: 13px;
            }

            .reminder-content{
                margin-bottom: 30px;
                height: 250px;
                display: block;
            }

            .reminder-content .col-md-6{
                display: block;
                max-width: 100%;
            }
            .reminder-content .col-md-3{
                max-width: 50%;
            }

            .reminder-button a {
                font-size: 12px;
            }
            .reminder-content:before {
            position: absolute;
            z-index: 0;
            right: 25%;
            left: 0%;
            content: url("data:image/svg+xml,%0A%3Csvg xmlns='http://www.w3.org/2000/svg' width='500' height='320' viewBox='0 0 78 44'%3E%3Cg%3E%3Cg clip-path='url(%23clip-88136a3f-a1a4-47bd-a8a5-2f284002f925)' opacity='.2'%3E%3Cpath fill='%23fff' d='M14.006 15.579a6.98 6.98 0 0 1-3.915-9.068 6.984 6.984 0 1 1 3.915 9.068zm46.703 8.515c-3.57-1.417-5.333-5.497-3.915-9.067l13.731-34.62c1.417-3.567 5.497-5.333 9.068-3.916 3.57 1.418 5.332 5.498 3.915 9.068L69.776 20.176c-1.085 2.735-3.73 4.407-6.511 4.407a6.928 6.928 0 0 1-2.556-.489zm-6.866 17.309a6.984 6.984 0 0 1-3.915-9.068 6.98 6.98 0 0 1 9.064-3.914 6.985 6.985 0 0 1-2.577 13.475 6.968 6.968 0 0 1-2.572-.493zM27.059 45.8c-3.57-1.414-5.332-5.494-3.915-9.065l13.731-34.62c1.414-3.57 5.494-5.332 9.068-3.915 3.57 1.418 5.328 5.498 3.914 9.064l-13.734 34.62c-1.085 2.733-3.727 4.406-6.507 4.406-.853 0-1.72-.158-2.557-.49zM-6.595 67.508c-3.57-1.417-5.329-5.497-3.915-9.067L3.222 23.824c1.418-3.57 5.494-5.333 9.068-3.915 3.57 1.414 5.332 5.494 3.914 9.064L2.473 63.593C1.388 66.325-1.253 68-4.035 68c-.854 0-1.72-.158-2.56-.49z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    }

    @media all and (max-width: 600px) {
            .reminder-subtitle{
                padding: 5px;
                font-size: 13px;
            }

            .col-md-3

            .reminder-content{
                margin-bottom: 30px;
                height: 250px;
                display: block;
            }

            .reminder-content .col-md-6{
                display: block;
                max-width: 100%;
            }
            .reminder-content .col-md-3{
                display: inline-block;
                max-width: 46%;
                padding: unset;
                margin: unset;
            }

            .reminder-title {
                 font-size: 24px;
            }
            .reminder-title span {
                 font-size: 15px;
            }

            .reminder-button{
                display: inline-block;
            }

            .reminder-button a {
                font-size: 9px;
            }
            .reminder-content:before {
            position: absolute;
            z-index: 0;
            right: 25%;
            left: 0%;
            content: url("data:image/svg+xml,%0A%3Csvg xmlns='http://www.w3.org/2000/svg' width='500' height='320' viewBox='0 0 78 44'%3E%3Cg%3E%3Cg clip-path='url(%23clip-88136a3f-a1a4-47bd-a8a5-2f284002f925)' opacity='.2'%3E%3Cpath fill='%23fff' d='M14.006 15.579a6.98 6.98 0 0 1-3.915-9.068 6.984 6.984 0 1 1 3.915 9.068zm46.703 8.515c-3.57-1.417-5.333-5.497-3.915-9.067l13.731-34.62c1.417-3.567 5.497-5.333 9.068-3.916 3.57 1.418 5.332 5.498 3.915 9.068L69.776 20.176c-1.085 2.735-3.73 4.407-6.511 4.407a6.928 6.928 0 0 1-2.556-.489zm-6.866 17.309a6.984 6.984 0 0 1-3.915-9.068 6.98 6.98 0 0 1 9.064-3.914 6.985 6.985 0 0 1-2.577 13.475 6.968 6.968 0 0 1-2.572-.493zM27.059 45.8c-3.57-1.414-5.332-5.494-3.915-9.065l13.731-34.62c1.414-3.57 5.494-5.332 9.068-3.915 3.57 1.418 5.328 5.498 3.914 9.064l-13.734 34.62c-1.085 2.733-3.727 4.406-6.507 4.406-.853 0-1.72-.158-2.557-.49zM-6.595 67.508c-3.57-1.417-5.329-5.497-3.915-9.067L3.222 23.824c1.418-3.57 5.494-5.333 9.068-3.915 3.57 1.414 5.332 5.494 3.914 9.064L2.473 63.593C1.388 66.325-1.253 68-4.035 68c-.854 0-1.72-.158-2.56-.49z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    } */
</style>

@endsection
