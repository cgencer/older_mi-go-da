@extends('admin.layouts.master')
@section('title')
Payment Edit (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Payment Edit (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Finance Management</span>
                        <a class="breadcrumb-item" href="{{route('admin.payments.index')}}">Payments</a>
                        <span class="breadcrumb-item active">Payment Edit (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Payment ID:</label>
                        <div class="col-sm-10">
                          <input type="text" readonly class="form-control-plaintext" id="" value="{{ $data->id }}">
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Reservation ID:</label>
                        <div class="col-sm-10">
                         <a target="_blank" href="{{ (route('admin.reservations.edit', ['id' => $data->reservation_id])) }}"> {{  $data->reservation_id }}</a>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Customer:</label>
                        <div class="col-sm-10">
                         <a target="_blank" href="{{ (route('admin.customers.edit', ['id' => $data->customer_id])) }}"> {{  $data->customer()->get()->first()->firstname }} {{ $data->customer()->get()->first()->lastname  }}</a>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Number of Guests:</label>
                        <div class="col-sm-10">
                            Adult: {{  $data->reservation()->get()->first()->guest_adult }} /  Child: {{ $data->reservation()->get()->first()->guest_child }}
                        </div>
                      </div>
                      @php
                             $details = $data->packet;
                            //  $packet = json_decode($details, true)
                        @endphp
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Customer City: </label>
                        <div class="col-sm-10">
                           {{  $details['charges']['data']['billing_details']['address']['city'] }}
                        </div>
                      </div>
                      <div class="mb-3 row">
                          @php
                               $hotels = \App\Models\Hotels::where('id', $data->hotel_id)->get()->first();
                          @endphp
                        <label for="staticEmail" class="col-sm-2 col-form-label">Hotel:</label>
                        <div class="col-sm-10">
                         <a target="_blank" href="{{ (route('admin.hotels.edit', ['id' =>  $hotels->id ])) }}">{{  $hotels->name }}</a>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Hotel City: </label>
                        <div class="col-sm-10">
                            {{ $hotels->city  }}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Status: </label>
                        <div class="col-sm-10 text-capitalize" >
                           {{  str_replace('_', ' ', $data->proccess_status)  }} <br>
                           <small>{{  str_replace('_', ' ', $details['status'])  }} </small>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Cancellation Reason: </label>
                        <div class="col-sm-10">
                           {{  $details['cancellation_reason'] != null ? $details['cancellation_reason'] : "-" }}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Order Date: </label>
                        <div class="col-sm-10">
                           {{  $data->created_at->format("d-m-Y H:i:s") }}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Collection Date: </label>
                        <div class="col-sm-10">
                           {{   date('d-m-Y',strtotime($details['metadata']['checkin'])) }}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Stripe ID: </label>
                        <div class="col-sm-10">

                           <a target="_blank" href="https://dashboard.stripe.com/{{ $details['application'] }}/test/payments{{ $details['id'] }}"> {{ $details['id']}}</a>
                           {{-- https://dashboard.stripe.com/acct_1Ht8oj2RBzhAR7oQ/test/payments/py_1Hx8GF2RBzhAR7oQDhUoxKty @cemg verdiği örnek --}}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Payment Platform: </label>
                        <div class="col-sm-10">
                               <strong class="text-capitalize">{{ $details['metadata']['platform']  }}</strong>
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Payment Type: </label>
                        <div class="col-sm-10 text-capitalize">
                           {{ $details['charges']['data']['payment_method_details']['type']}}
                        </div>
                      </div>
                      @if ($details['charges']['data']['payment_method_details']['type'] == "card")
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Card Type: </label>
                        <div class="col-sm-10 text-capitalize">
                           {{ $details['charges']['data']['payment_method_details']['card']['network'] }}
                        </div>
                      </div>
                      @endif
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Payment Amount: </label>
                        <div class="col-sm-10">
                           {{ \App\Helpers::localizedCurrency($details['charges']['data']['amount'] /100)}}
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Migoda Application Fee: </label>
                        <div class="col-sm-10">
                           {{ \App\Helpers::localizedCurrency($details['charges']['data']['application_fee'] /100)}}
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Stripe Fee: </label>
                        <div class="col-sm-10">
                           {{ \App\Helpers::localizedCurrency($details['metadata']['fees']['stripe']  /100)}}

                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Penalty Fee: </label>
                        <div class="col-sm-10">
                          -
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">VAT: </label>
                        <div class="col-sm-10">
                          -
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Payout Amount: </label>
                        <div class="col-sm-10">
                            {{ \App\Helpers::localizedCurrency($details['metadata']['fees']['hotel']  /100)}}

                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection
