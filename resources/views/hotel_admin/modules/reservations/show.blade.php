@extends('hotel_admin.layouts.master')
@section('title')
    {{trans('txt.payments_reservation_show')}} (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
@endsection
@section('scripts')
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
                if (rejectVal == "") {
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
                <h2 class="header-title">{{trans('txt.payments_reservation_show')}} (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <a class="breadcrumb-item" href="{{route('hotel_admin.reservations.index')}}">{{trans('txt.reservations')}}</a>
                        <span class="breadcrumb-item active">{{trans('txt.payments_reservation_show')}} (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-show">
                        <tbody>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_hotel')}}</th>
                            <td>
                                <p class="form-control-plaintext">
                                    @php
                                        $hotel = $data->hotel()->get()->first();
                                    @endphp
                                    <a href="{{route('hotel_admin.hotels.edit',['id'=>$hotel->id])}}">{{$hotel->name}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_customer')}}</th>
                            <td>
                                @php
                                    $customer = $data->customer()->get()->first();
                                @endphp
                                <p class="form-control-plaintext">
                                    {{$customer->firstname .' '.$customer->lastname}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_checkin')}}</th>
                            <td><p class="form-control-plaintext">{{$data->checkin_date->format('d-m-Y')}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_checkout')}}</th>
                            <td><p class="form-control-plaintext">{{$data->checkout_date->format('d-m-Y')}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_guest_adult')}}</th>
                            <td><p class="form-control-plaintext">{{$data->guest_adult}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_guest_child')}}</th>
                            <td><p class="form-control-plaintext">{{$data->guest_child}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_main_guest')}}</th>
                            <td><p class="form-control-plaintext">{{$data->main_guest}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_email')}}</th>
                            <td><p class="form-control-plaintext">{{$data->email}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_dob')}}</th>
                            <td><p class="form-control-plaintext">{{date("d-m-Y", strtotime($data->dob))}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_phone')}}</th>
                            <td><p class="form-control-plaintext">{{$data->phone}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_gender')}}</th>
                            <td><p class="form-control-plaintext">{{$data->getGenderText()}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_status')}}</th>
                            <td><p class="form-control-plaintext">{{$data->getStatusByCode($data->reason_id)}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_o_reason')}}</th>
                            <td><p class="form-control-plaintext">{{$data->other_reason}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_payments')}}</th>
                            <td>
                                {{--<p class="form-control-plaintext">
                                @php
                                    $payments = $data->payments()->get();
                                @endphp
                                <ul>
                                    @foreach($payments as $payment)
                                        <li>
                                            <a href="{{route('hotel_admin.payments.show',['id'=>$payment->id])}}">{{$payment->id}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                </p>--}}
                            </td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_price')}}</th>
                            <td><p class="form-control-plaintext">{{$data->formatted_price}}</p></td>
                        </tr>
                        </tbody>
                    </table>
                    @if ($data->status == 0)
                        <hr>
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="text-sm-left">
                                        <a  href="" data-id="{{ $data->id }}" data-otherreason="{{ $data->other_reason }}" data-toggle="modal" data-target="#modal-decline" class="declineButton btn btn-danger m-r-15 {{($data->getStatusShortcode($data->reason_id) != "waiting")?'disabled':''}}" title="{{trans('txt.reservation_reject')}}">{{trans('txt.reservation_reject')}}</a>
                                        <a  href="" data-id="{{ $data->id }}" data-checkin="{{$data->checkin_date->format('d F Y')}}" data-checkout="{{$data->checkout_date->format("d F Y") }}" data-coupon="{{ \Illuminate\Support\Str::upper($customer->firstname.' '.$customer->lastname) }}" data-guests="{{ $data->guest_adult + $data->guest_child}}" data-toggle="modal" data-target="#modal-approve" class="approveButton btn btn-success {{($data->getStatusShortcode($data->reason_id) != "waiting")?'disabled':''}}" title="{{trans('txt.reservation_approve')}}">{{trans('txt.reservation_approve')}}</a>
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
                                                    <p class="lead">{{ trans('txt.dear') }} {{mb_strtoupper(\Illuminate\Support\Facades\Auth::guard('user')->user()->name)}}!</p>
                                                    <p class="m-b-25">
                                                        {!! trans('txt.reservation_text') !!}
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
