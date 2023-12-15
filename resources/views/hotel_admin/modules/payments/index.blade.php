@extends('hotel_admin.layouts.master')
@section('title')
{{trans('txt.admin_menu_payments')}} | @parent
@endsection
@section('page_styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/datatables/media/css/dataTables.bootstrap4.min.css')}}"/>
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>

        $(document).ready(function () {
            var table = $('#dt-opt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('hotel_admin.payments.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "width": 120, "targets": 7},
                ],
                "order": [[5, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id", 'name': 'id'},
                    {"data": "customer_id", 'name': 'customer_id'},
                    {"data": "reservation_id", 'name': 'reservation_id'},
                    {"data": "checkin_date", 'name': 'checkin_date'},
                    {"data": "nights", 'name': 'nights'},
                    {"data": "status", 'name': 'status'},
                    {"data": "payout_date", 'name': 'payout_date'},
                    {"data": "meal_offer", 'name': 'meal_offer'},
                    {"data": "charge_collection_fees", 'name': 'charge_collection_fees'},
                    {"data": "migoda_comission_fees", 'name': 'migoda_comission_fees'},
                    {"data": "VAT", 'name': 'VAT'},
                    {"data": "payout_amount", 'name': 'payout_amount'},
                    {"data": "stripe_payout_id", 'name': 'stripe_payout_id'},
                    {"data": "receipt", 'name': 'receipt'},
                ]
            });
        });
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">{{trans('txt.admin_menu_payments')}}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <span class="breadcrumb-item active">{{trans('txt.admin_menu_payments')}}</span>
                    </nav>
                </div>
            </div>
            @include('hotel_admin.partials.notifications')
            <div class="card">
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
                                <th>{{trans('txt.payments_table_customer')}}</th>
                                <th>{{trans('txt.payments_table_reservation')}}</th>
                                <th>{{trans('txt.payments_table_checkin_date')}}</th>
                                <th>{{trans('txt.payments_table_nights')}}</th>
                                <th>{{trans('txt.payments_table_status')}}</th>
                                <th>{{trans('txt.payments_table_payout_date')}}</th>
                                <th>{{trans('txt.payments_table_meal_offer')}}</th>
                                <th>{{trans('txt.payments_table_ccf')}}</th>
                                <th>{{trans('txt.payments_table_mcf')}}</th>
                                <th>{{trans('txt.payments_table_vat')}}</th>
                                <th>{{trans('txt.payments_table_payout_amount')}}</th>
                                <th>{{trans('txt.payments_table_spi')}}</th>
                                <th>{{trans('txt.payments_table_receipt')}}</th>
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
