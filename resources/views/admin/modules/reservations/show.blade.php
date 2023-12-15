@extends('admin.layouts.master')
@section('title')
    Reservation Show (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
@endsection
@section('scripts')
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
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Reservation Show (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <a class="breadcrumb-item" href="{{route('admin.reservations.index')}}">Reservations</a>
                        <span class="breadcrumb-item active">Reservation Show (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-show">
                        <tbody>
                        <tr>
                            <th>Hotel</th>
                            <td>
                                <p class="form-control-plaintext">
                                    @php
                                        $hotel = $data->hotel()->get()->first();
                                    @endphp
                                    <a href="{{route('admin.hotels.edit',['id'=>$hotel->id])}}">{{$hotel->name}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>
                                @php
                                    $customer = $data->customer()->get()->first();
                                @endphp
                                <p class="form-control-plaintext">
                                    <a href="{{route('admin.customers.edit',['id'=>$customer->id])}}">{{$customer->firstname .' '.$customer->lastname}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Checkin Date</th>
                            <td><p class="form-control-plaintext">{{$data->checkin_date}}</p></td>
                        </tr>
                        <tr>
                            <th>Checkout Date</th>
                            <td><p class="form-control-plaintext">{{$data->checkout_date}}</p></td>
                        </tr>
                        <tr>
                            <th>Guest Adult</th>
                            <td><p class="form-control-plaintext">{{$data->guest_adult}}</p></td>
                        </tr>
                        <tr>
                            <th>Guest Child</th>
                            <td><p class="form-control-plaintext">{{$data->guest_child}}</p></td>
                        </tr>
                        <tr>
                            <th>Main Guest</th>
                            <td><p class="form-control-plaintext">{{$data->main_guest}}</p></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><p class="form-control-plaintext">{{$data->email}}</p></td>
                        </tr>
                        <tr>
                            <th>Dob</th>
                            <td><p class="form-control-plaintext">{{$data->dob}}</p></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><p class="form-control-plaintext">{{$data->phone}}</p></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><p class="form-control-plaintext">{{$data->getGenderText()}}</p></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><p class="form-control-plaintext">{{$data->getStatusByCode($data->reason_id)}}</p></td>
                        </tr>
                        <tr>
                            <th>Other Reason</th>
                            <td><p class="form-control-plaintext">{{$data->other_reason}}</p></td>
                        </tr>
                        <tr>
                            <th>Payments</th>
                            <td>
                                <p class="form-control-plaintext">
                                @php
                                    $payments = $data->payments()->get();
                                @endphp
                                <ul>
                                    @foreach($payments as $payment)
                                        <li>
                                            <a href="{{route('admin.payments.show',['id'=>$payment->id])}}">{{$payment->id}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Coupon Codes</th>
                            <td>
                                <p class="form-control-plaintext">
                                @php
                                    $coupons = $data->getCoupons()->get();
                                @endphp
                                <ul>
                                    @foreach($coupons as $coupon)
                                        <li><a href="{{route('admin.coupon-rules.index')}}">{{$coupon->code}}</a></li>
                                    @endforeach
                                </ul>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><p class="form-control-plaintext">{{$data->formatted_price}}</p></td>
                        </tr>
                        <tr>
                            <th>Created Date</th>
                            <td><p class="form-control-plaintext">{{$data->created_at}}</p></td>
                        </tr>
                        <tr>
                            <th>Updated Date</th>
                            <td><p class="form-control-plaintext">{{$data->updated_at}}</p></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="text-sm-left">
                                    <a href="{{ route('admin.reservations.testing') }}?id={{  $data->id }}&status=3"  class="btn btn-info m-r-15 " title="Reject">Payment Success Test</a>
                                    <a href="{{ route('admin.reservations.testing') }}?id={{  $data->id }}&status=4"  class="btn btn-primary m-r-15 " title="Reject">Payment Failed Test</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($data->status == 0)
                        <hr>
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="text-sm-left">
                                        <a href="" data-id="{{ $data->id }}" data-otherreason="{{ $data->other_reason }}" data-toggle="modal" data-target="#modal-decline" class="declineButton btn btn-danger m-r-15 {{($data->getStatusShortcode($data->reason_id) != "waiting")?'disabled':''}}" title="Reject">Reject</a>
                                        <a href="" data-id="{{ $data->id }}" data-checkin="{{$data->checkin_date->format('d F Y')}}" data-checkout="{{$data->checkout_date->format("d F Y") }}" data-coupon="{{ \Illuminate\Support\Str::upper($customer->firstname.' '.$customer->lastname) }}" data-guests="{{ $data->guest_adult + $data->guest_child}}" data-toggle="modal" data-target="#modal-approve" class="approveButton btn btn-success {{($data->getStatusShortcode($data->reason_id) != "waiting")?'disabled':''}}" title="Approve">Approve</a>
                                    </div>
                                </div>
                            </div>
                        </div>


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
                                                    <p class="lead">{{ trans('txt.dear') }} {{mb_strtoupper(\Illuminate\Support\Facades\Auth::guard('admin')->user()->name)}}!</p>
                                                    <p class="m-b-25">
                                                        Migoda Coupon Holder Mr(s)
                                                        <span id="couponHolder">XX.XX.XXXX</span> would be delighted to stay with you wilth
                                                        <span id="numberOfGuests">XX.XX.XXXX</span> guests from
                                                        <span id="reservationCheckinDate">XX.XX.XXXX</span> to
                                                        <span id="reservationCheckoutDate">XX.XX.XXXX</span> in your hotel. According to your calendar you show these dates available. Please accept or decline this booking request.
                                                    </p>
                                                    <a href="#" class="btn btn-gradient-success approveLink" role="button" aria-pressed="true">
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
                                                                <input id="radio_{{ $reasonId }}" name="rejectReason" type="radio" value="{{ $reasonId }}"/>
                                                                <label for="radio_{{ $reasonId }}">{{ $reason }}</label>
                                                            </div>
                                                        @endforeach
                                                        <div class="form-group" style="padding-left:20px">
                                                            <input type="text" class="form-control rejectDesc" name="rejectDesc" placeholder="{{ trans('txt.your_description') }}">
                                                        </div>
                                                        <a href="#" class="btn btn-gradient-success declineLink" role="button" aria-pressed="true" style="margin-left:20px">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
