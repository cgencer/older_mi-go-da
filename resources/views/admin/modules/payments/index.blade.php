@extends('admin.layouts.master')
@section('title')
    Payments | @parent
@endsection
@section('page_styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/datatables/media/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"/>
    <link href="{{asset('admin/assets/vendor/air-datepicker/dist/css/datepicker.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-control{
            height: 40px!important;
        }
        .select2{
            height: 40px!important;

        }

        .filter-card{
            display: flex;
            align-items: center;
            align-content: center;
            padding: 10px 20px !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
            position: absolute;
            top: -61px;
            right: 50px;
        }

        .select2-selection__rendered {
              line-height: 31px !important;
              vertical-align: middle!important;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
            vertical-align: middle!important;

        }
        .select2-selection__arrow {
            height: 34px !important;
            vertical-align: middle!important;

        }

        .select2-search__field{
            vertical-align: middle!important;

        }

        .dataTables_length {
            float: left;
            padding-right: 30px;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            text-align: right;
            display: inline-block;
            float: right;
        }

    </style>

@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/air-datepicker/dist/js/datepicker.min.js')}}"></script>
    <script src="{{ asset('admin/assets/vendor/air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        $(document).ready(function () {
            var table = $('#dt-opt').DataTable({
                "processing": false,
                "serverSide": true,
                // "ajax": "{{route('admin.payments.index.ajax')}}",
                "ajax":
                    {
                    "url": "{{route('admin.payments.index.ajax')}}",
                    "data": function (d) {
                        d.start_date = $('#start_date').val(),
                        d.end_date = $('#due_date').val(),
                        d.country = $('#country').val(),
                        d.status = $('#status').val(),
                        d.platform = $('#platform').val(),
                        d.searchBox = $('#searchBox').val(),
                        d.filter = $('#filter').val()
                    }
                },
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "width": 120, "targets": 10},
                ],
                "order": [[10, 'desc']],
                "displayLength": 10,
                "dom": '<"top">rt<"bottom"pli><"clear">',
                "columns": [
                    {"data": "id", 'name': 'id'},
                    {"data": "reservation_id", 'name': 'reservation_id'},
                    {"data": "customer_id", 'name': 'customer_id'},
                    {"data": "number_of_guests", 'name': 'number_of_guests'},
                    {"data": "payment_date", 'name': 'payment_date'},
                    {"data": "hotel_id", 'name': 'hotel_id'},
                    {"data": "status", 'name': 'status'},
                    {"data": "platform", 'name': 'platform'},
                    {"data": "payment_amount", 'name': 'payment_amount'},
                    {"data": "payment_type", 'name': 'payment_type'},
                    {"data": "card_type", 'name': 'card_type'},
                    {"data": "actions", 'name': 'actions'},


                ]
            });
        });
        $('.select2').select2();

        $("#start_date").datepicker({
                firstDay: 1,
                language: 'en'
        });

        $("#due_date").datepicker({
            firstDay: 1,
            language: 'en',
            onSelect: function(dateText) {

            }
        });

        function drawDataTable() {

            $('#filter').val("1")

            $('#dt-opt').DataTable().draw(true);

        }


    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Payments</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Finance Management</span>
                        <span class="breadcrumb-item active">Payments</span>
                        <input type="hidden" name="" value="0" id="filter">
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="custom-filter">
                    <div class="form-row">
                        <div class="col">
                            <div class="icon-input">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('start_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd', 'placeholder' => 'Starting Date', 'id' => 'start_date'])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="icon-input">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('due_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd', 'placeholder' => 'End Date','id' => 'due_date'])}}
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                @php
                                    $set = \App\Models\Countries::whereRaw('name <> ""')->whereRaw('id <> ""')->orderBy('name')->pluck('name', 'id');
                                    $set = json_decode(json_encode($set), true);
                                    // $set = collect( $set);
                                @endphp
                                {!! Form::select('country', $set,null, ['class' => 'select2 form-control', 'required'=>'required','data-dropdownCssClass'=>'country-select2','multiple', 'id' => "country",'data-placeholder'=>trans('txt.please_select_a_country')]) !!}
                            </div>
                        </div>
                        <div class="col">
                            <select name="" id="platform" class="form-control select2" placeholder="Please Select a Platform" >
                                <option value="" disabled selected>Select A Platform</option>
                                <option value="web">Web</option>
                                <option value="mobile">Mobil</option>
                                <option value="tablet">Tablet</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="" id="status" class="form-control select2" multiple data-placeholder="Please Select a status" >
                                <option value="succeeded">Succeeded</option>
                                <option value="holded">Holded</option>
                                <option value="authed">Authed</option>
                                <option value="charged">Charged</option>
                                <option value="paid">Paid</option>
                                <option value="proceed">Proceed</option>
                                <option value="stated">Stated</option>
                                <option value="archived">Archived</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col">
                            {{Form::text('',null,['class'=>'form-control', 'placeholder' => "Search", 'id' => "searchBox"])}}
                        </div>
                        <div class="col">
                            <button class="btn btn-info btn-block" onclick="drawDataTable()"  name="filter"> <i class="fa fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
                <div class="card-header filter-card">

                </div>
                <div class="card-body">
                    <div class="table-overflow table-responsive">
                        <table id="dt-opt" class="table table-hover table-xl">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox p-0">
                                        <input id="selectable1" type="checkbox" class="checkAll" name="checkAll">
                                        <label for="selectable1"></label>
                                    </div>
                                </th>
                                <th>Reservation</th>
                                <th>Customer</th>
                                <th>Number Of Guest</th>
                                <th>Payment Date</th>
                                <th>Hotel</th>
                                <th>Status</th>
                                <th>Platform</th>
                                <th>Payment Amount</th>
                                <th>Payment Type</th>
                                <th>Card Type</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
