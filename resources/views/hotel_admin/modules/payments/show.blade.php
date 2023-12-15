@extends('admin.layouts.master')
@section('title')
    {{trans('txt.payments_reservation_show')}} (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
@endsection
@section('scripts')
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">{{trans('txt.payments_reservation_show')}} (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <a class="breadcrumb-item" href="{{route('admin.reservations.index')}}">{{trans('txt.admin_menu_reservations')}}</a>
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
                                    <a href="{{route('admin.hotels.edit',['id'=>$hotel->id])}}">{{$hotel->name}}</a>
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
                                    <a href="{{route('admin.customers.edit',['id'=>$customer->id])}}">{{$customer->firstname .' '.$customer->lastname}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_checkin')}}</th>
                            <td><p class="form-control-plaintext">{{$data->checkin_date}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_field_checkout')}}</th>
                            <td><p class="form-control-plaintext">{{$data->checkout_date}}</p></td>
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
                            <td><p class="form-control-plaintext">{{$data->dob}}</p></td>
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
                            <th>{{trans('txt.payment_edit_field_c_codes')}}</th>
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
                            <th>{{trans('txt.payment_edit_field_price')}}</th>
                            <td><p class="form-control-plaintext">{{$data->formatted_price}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_c_date')}}</th>
                            <td><p class="form-control-plaintext">{{$data->created_at}}</p></td>
                        </tr>
                        <tr>
                            <th>{{trans('txt.payment_edit_u_date')}}</th>
                            <td><p class="form-control-plaintext">{{$data->updated_at}}</p></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="text-sm-left">
                                    <a href="{{route('admin.reservations.edit',['id'=>$data->id])}}" class="btn btn-warning m-r-15" title="{{trans('txt.link_payment_edit')}}">{{trans('txt.link_payment_edit')}}</a>
                                    <a href="{{route('admin.reservations.remove',['id'=>$data->id])}}" onclick="return confirm('{{trans('txt.payment_remove')}}');" class="btn btn-danger" title="{{trans('txt.link_payment_remove')}}">{{trans('txt.link_payment_remove')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
