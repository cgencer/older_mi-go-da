@extends('hotel_admin.layouts.master')
@section('title')
{{trans('txt.reservations')}} | @parent
@endsection
@section('page_styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/datatables/media/css/dataTables.bootstrap4.min.css')}}"/>
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    @php
        $status = @$_GET['status'];
    @endphp
    <script>
        $(document).ready(function () {
            var table = $('#dt-opt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('hotel_admin.reservations.index.ajax').(($status != null) ? '?status='.$status:'')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"width": 120, "targets": 1},
                    {"orderable": false, "width": 120, "targets": 7},
                ],
                "order": [[7, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id"},
                    {"data": "user"},
                    {"data": "checkin_date"},
                    {"data": "checkout_date"},
                    {"data": "status"},
                    {"data": "guest_adult"},
                    {"data": "guest_child"},
                    {"data": "action"},
                ]
            });
        });
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">{{trans('txt.reservations')}}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <span class="breadcrumb-item">{{trans('txt.finance_management')}}</span>
                        <span class="breadcrumb-item active">{{trans('txt.reservations')}}</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
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
                                <th class="text-capitalize">{{trans('txt.guest')}}</th>
                                <th>{{trans('txt.payment_edit_field_checkin')}}</th>
                                <th>{{trans('txt.payment_edit_field_checkout')}}</th>
                                <th>{{trans('txt.payment_edit_field_status')}}</th>
                                <th>{{trans('txt.payment_edit_field_guest_adult')}}</th>
                                <th>{{trans('txt.payment_edit_field_guest_child')}}</th>
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
