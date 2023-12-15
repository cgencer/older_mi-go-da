@extends('admin.layouts.master')@php
    $admin = Auth::guard('admin')->user();
    $profile_image = $admin->getMedia('profile_image')->first();
      $Hour = date('G');
      if ( $Hour >= 5 && $Hour <= 11 ) {
          $welcomeMessage = "Good Morning";
      } else if ( $Hour >= 12 && $Hour <= 18 ) {
          $welcomeMessage = "Good Afternoon";
      } else if ( $Hour >= 19 || $Hour <= 4 ) {
          $welcomeMessage =  "Good Evening";
      }
@endphp
@section('title')Dashboard | @parent @endsection
@section('scripts')
    <script src="{{ asset('admin/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/analytical.js') }}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            $(".approveButton").click(function () {
                var actionUrl = '{{route('admin.reservations.setReservationStatus')}}?reservationId=' + $(this).attr('data-id') + '&status=1'
                $(".approveLink").attr('href', actionUrl);
                $("#reservationCheckinDate").text($(this).attr('data-checkin'));
                $("#reservationCheckoutDate").text($(this).attr('data-checkout'));
                $("#couponHolder").text($(this).attr('data-coupon'));
                $("#numberOfGuests").text($(this).attr('data-guests'));
            });
            $(".declineLink").click(function (e) {
                var rejectDesc = $(".rejectDesc").val();
                var rejectVal = $('input[name=rejectReason]:checked', '.rejectForm').val()
                var actionUrl = '{{route('admin.reservations.setReservationStatus')}}?reservationId=' + $(this).attr('data-id') + '&status=2&rejectVal=' + rejectVal + '&rejectDesc=' + rejectDesc;
                if (rejectDesc == "" || rejectVal == "") {
                    swal({
                        title: 'Hata',
                        text: 'Lütfen uygun bir onaylanmama sebebi seçiniz.',
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
    $allReservations = \App\Models\Reservation::all()->take(20);
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
                                <p class="lead">{{ trans('txt.dear') }} {{mb_strtoupper($admin->name)}}!</p>
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
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="col-md-3">
                        <div class="userProfileImageBack">
                            <img class="userProfileImage"
                                 src="{{$profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')}}"
                                 alt="">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h1 class="welcomeMessage">{{ trans($welcomeMessage) }} {{$admin->firstname}}.</h1>
                        <h3 class="welcomeMessage2">{{ trans("txt.heres_whats_happening") }}</h3>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12" style="margin-bottom: 30px; ">
                    <div class="col-md-3 floatedLeft boxItemContainer" style="padding-left: 0px;">
                        <a href="{{route('admin.reservations.index')}}" class="boxHover1">
                            <div class="boxItem  activeBox ">
                                <span class="boxTitleSpan">{{trans('txt.all_reservations')}}</span> <span class="count">
                        {{\App\Models\Reservation::all()->count()}}
                    </span> <img class="boxIcon1" src="{{asset('admin/assets/images/admin/reservationsIcon1.png')}}">
                                <img class="boxIcon" src="{{asset('admin/assets/images/admin/reservationsIcon2.png')}}">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('admin.reservations.index')}}?status={{\App\Models\Reservation::STATUS_WAITING}}"
                           class="boxHover1">
                            <div class="boxItem ">
                                <span class="boxTitleSpan">{{trans('txt.pending')}}</span> <span class="count">
                                    {{\App\Models\Reservation::where('status',\App\Models\Reservation::STATUS_WAITING)->get()->count()}}
                    </span>
                                <img class="boxIcon1"
                                     src="{{asset('admin/assets/images/admin/pendingReservationsIcon1.png')}}">
                                <img class="boxIcon"
                                     src="{{asset('admin/assets/images/admin/pendingReservationsIcon.png')}}">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('admin.reservations.index')}}?status={{\App\Models\Reservation::STATUS_APPROVED}}"
                           class="boxHover1">
                            <div class="boxItem ">
                                <span class="boxTitleSpan">{{trans('txt.confirmed')}}</span> <span class="count">
                        {{\App\Models\Reservation::where('status',\App\Models\Reservation::STATUS_APPROVED)->get()->count()}}
                    </span>
                                <img class="boxIcon1"
                                     src="{{asset('admin/assets/images/admin/confirmedReservationsIcon1.png')}}">
                                <img class="boxIcon"
                                     src="{{asset('admin/assets/images/admin/confirmedReservationsIcon.png')}}">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 floatedLeft boxItemContainer">
                        <a href="{{route('admin.reservations.index')}}?status={{\App\Models\Reservation::STATUS_CANCELED}}"
                           class="boxHover1">
                            <div class="boxItem ">
                                <span class="boxTitleSpan">{{trans('txt.cancelled')}}</span> <span class="count">
                                {{\App\Models\Reservation::where('status',\App\Models\Reservation::STATUS_CANCELED)->get()->count()}}
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
                                {{trans('txt.all_reservations')}} </h1>
                            <div class="table-overflow table-responsive" style="margin-top: 40px;">
                                <table id="dt-opt" class="table table-hover table-xl">
                                    <thead class="dataTableHead">
                                    <tr>
                                        <th style="width: 18%">
                                            Res No
                                        </th>
                                        <th>{{ trans('txt.check_in') }}</th>
                                        <th>{{ trans('txt.check_out') }}</th>
                                        <th>{{ trans('txt.customer') }}</th>
                                        <th>{{ trans('txt.status') }}</th>
                                        <th>{{ trans('txt.action_time') }}</th>
                                        <th style="min-width: 145px"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="dataTableBody">
                                    @foreach($allReservations as $reservation)
                                        @php
                                            $customer = $reservation->customer()->get()->first();
$resStatus = \App\Helpers::hoursRemaining($reservation->created_at->format('h:m:s'));
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.reservations.show',['id'=>$reservation->id])}}"
                                                   class="resLink">Res {{$reservation->id}}</a>
                                            </td>
                                            <td>{{$reservation->checkin_date->format('d-m-Y')}}</td>
                                            <td>{{$reservation->checkout_date->format('d-m-Y')}}</td>
                                            <td>
                                                <div class="list-media">
                                                    <div class="list-item">
                                                        <div class="info p-l-0">
                                                            <span
                                                                class="title">{{$customer->firstname.' '. \Illuminate\Support\Str::substr($customer->lastname,0,1).'.'}}</span>
                                                            @hasrole('SuperAdmin', 'admin')
                                                            <a href="mailto:{{ $customer->email }}">
                                                                <span class="sub-title">{{ $customer->email }}</span>
                                                            </a> @endhasrole
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($resStatus == -1)
                                                    <span class="dot cancelledStatus"></span>
                                                    <span class="cancelledText">{{ trans('txt.passive') }}</span>
                                                @else
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
                                                        <span
                                                            class="cancelledText">{{ trans('txt.payment_error') }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($reservation->status == 0 && $resStatus != -1)
                                                    <div class="actionTime" style="float: left">
                                                        <span data-date="{{$reservation->created_at->add(2, 'day')->valueOf()}}" class="reservation-timer">

                                                        </span>
                                                    </div>
                                                @else
                                                    {{ $reservation->created_at->format('d.m.Y') }}
                                                @endif
                                            </td>
                                            <td class="text-center font-size-18">
                                                @if ($resStatus !=  -1&& $reservation->status == 0)
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
                                                    <a href="{{route('admin.reservations.show',['id'=>$reservation->id])}}"
                                                       class="text-gray m-r-15">
                                                        <img src="{{asset('admin/assets/images/admin/details.png')}}"/>
                                                        <span class="detailsLink">{{ trans('txt.details') }}</span> </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="reservationExplanation">
                                    <p>*Cancelled: Customer cancelled in the free cancellation period.</p>
                                    <p>**Cancelled: Hotel free cancellation period.</p>
                                    <p>***Cancelled: Hotel cancelled reservation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-info">
                The following are sample data. It is for demonstration purposes only.
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Monthly Revenue</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h2 class="font-size-30 m-b-0 text-success m-t-15">38.6%</h2>
                                    <h5 class="m-b-0 font-size-16 text-semibold">Profit Margin</h5>
                                    <p>from sales in this segment</p>
                                    <div class="m-t-30">
                                        <p class="width-85">European minnow priapumfish mosshead warbonnet shrimpfish
                                            bigscale. Cutlassfish porbeagle shark ricefish walking catfish glassfish
                                            Black swallower.</p>
                                        <p class="width-85">Efficiently unleash cross-media information without
                                            cross-media value. Quickly maximize timely deliverables for real-time
                                            schemas. Dramatically maintain clicks-and-mortar.</p>
                                        <button class="btn btn-default m-t-30">Download Report
                                            <i class="ti-angle-right font-size-10 p-l-5"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="text-right">
                                        <ul class="list-inline">
                                            <li class="m-r-20">
                                                <a href="" class="text-semibold text-gray">Today</a>
                                            </li>
                                            <li class="m-r-20">
                                                <a href="" class="text-semibold text-gray">7 days</a>
                                            </li>
                                            <li class="m-r-20">
                                                <a href="" class="text-semibold text-gray">14 days</a>
                                            </li>
                                            <li class="m-r-20">
                                                <a href="" class="text-semibold text-gray active">1 Month</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="m-t-30">
                                        <canvas class="chart" id="segment-chart" style="height: 320px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media justify-content-between">
                                <div>
                                    <p class="">Total Revenue</p>
                                    <h2 class="font-size-28 font-weight-light">$23,495</h2>
                                    <span class="text-semibold text-success font-size-15">
                                                    <i class="ti-arrow-up font-size-11"></i>
                                                    <span>12%</span>
                                                </span>
                                </div>
                                <div class="align-self-end">
                                    <i class="ti-credit-card font-size-70 text-success opacity-01"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media justify-content-between">
                                <div>
                                    <p class="">Daily Product</p>
                                    <h2 class="font-size-28 font-weight-light">3,758</h2>
                                    <span class="text-semibold text-danger font-size-15">
                                                    <i class="ti-arrow-down font-size-11"></i>
                                                    <span>7%</span>
                                                </span>
                                </div>
                                <div class="align-self-end">
                                    <i class="ti-pie-chart font-size-70 text-info opacity-01"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media justify-content-between">
                                <div>
                                    <p class="">Growth Rate</p>
                                    <h2 class="font-size-28 font-weight-light">28%</h2>
                                    <span class=" font-size-13 opacity-04">
                                                    from last month
                                                </span>
                                </div>
                                <div class="align-self-end">
                                    <i class="ti-bar-chart font-size-70 text-danger opacity-01"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media justify-content-between">
                                <div>
                                    <p class="">New Customers</p>
                                    <h2 class="font-size-28 font-weight-light">178</h2>
                                    <span class="text-semibold text-success font-size-15">
                                                    <i class="ti-arrow-up font-size-11"></i>
                                                    <span>18%</span>
                                                </span>
                                </div>
                                <div class="align-self-end">
                                    <i class="ti-user font-size-70 text-primary opacity-01"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent Payments</h4>
                        </div>
                        <div class="table-overflow table-responsive">
                            <table class="table table-lg">
                                <thead>
                                <tr>
                                    <td class="text-dark text-semibold">Customer</td>
                                    <td class="text-dark text-semibold">Payment Date</td>
                                    <td class="text-dark text-semibold">Amount</td>
                                    <td class="text-dark text-semibold">Status</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="list-media">
                                            <div class="list-item">
                                                <div class="media-img">
                                                    <img src="assets/images/avatars/thumb-1.jpg" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title p-t-10 text-semibold">Marshall Nichols</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>08 May 2018</td>
                                    <td> $168.00</td>
                                    <td>
                                        <span class="status success"></span>
                                        <span class="text-success text-semibold m-l-5">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-media">
                                            <div class="list-item">
                                                <div class="media-img">
                                                    <img src="assets/images/avatars/thumb-2.jpg" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title p-t-10 text-semibold">Susie Willis</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>05 May 2018</td>
                                    <td>$433.00</td>
                                    <td>
                                        <span class="status success"></span>
                                        <span class="text-success text-semibold m-l-5">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-media">
                                            <div class="list-item">
                                                <div class="media-img">
                                                    <img src="assets/images/avatars/thumb-3.jpg" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title p-t-10 text-semibold">Debra Stewart</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>09 May 2018</td>
                                    <td>$2488.00</td>
                                    <td>
                                        <span class="status warning"></span>
                                        <span class="text-warning text-semibold m-l-5">Inactive</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-media">
                                            <div class="list-item">
                                                <div class="media-img">
                                                    <img src="assets/images/avatars/thumb-8.jpg" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title p-t-10 text-semibold">Erin Gonzales</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>16 May 2018</td>
                                    <td>$762.00</td>
                                    <td>
                                        <span class="status danger"></span>
                                        <span class="text-danger text-semibold m-l-5">Disabled</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-media">
                                            <div class="list-item">
                                                <div class="media-img">
                                                    <img src="assets/images/avatars/thumb-11.jpg" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title p-t-10 text-semibold">Darryl Day</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>16 May 2018</td>
                                    <td>$762.00</td>
                                    <td>
                                        <span class="status success"></span>
                                        <span class="text-success text-semibold m-l-5">Active</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Best Hotels</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center m-t-20">
                                <h2 class="font-weight-light font-size-30 m-b-0">{{\App\Models\Hotels::all()->count()}}</h2>
                                <p class="opacity-07">Total Hotels</p>
                            </div>
                            <div class="m-t-60">
                                <canvas class="chart" id="statistic-chart" style="height: 320px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function startTimer(display) {
        var countDownDate = parseInt(display.attr('data-date'));
        var x = setInterval(function () {
            var now = new Date().getTime(),
                distance = countDownDate - now,
                days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                display.html((hours + (days * 24))+':'+minutes);
                if (distance <= 0) {
                    if(clearInterval(x)>0)
                    location.reload();
                    display.html('00:00');
                }
        }, 1000);
    }

    window.onload = function () {
        var timer = $('[data-date]');
        startTimer(timer);
    };
</script>
@endsection
