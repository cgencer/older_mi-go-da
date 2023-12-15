@extends('admin.layouts.master')
@section('title')
    Coupon Rules | @parent
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
                "ajax": "{{route('admin.coupon-rules.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "targets": 4},
                    {"orderable": false, "width": 120, "targets": 12},
                ],
                "order": [[0, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "is_active"},
                    {"data": "generate"},
                    {"data": "coupons"},
                    {"data": "start_date"},
                    {"data": "end_date"},
                    {"data": "prefix"},
                    {"data": "suffix"},
                    {"data": "length"},
                    {"data": "quantity"},
                    {"data": "created_at"},
                    {"data": "action"},
                ]
            });
        });

        function getCoupons(btn, rule_id) {
            //$('#modal-rule-main-coupons').modal('show');

            // AJAX request
            $.ajax({
                url: '{{route('admin.coupon-rules.index.getCoupons')}}',
                type: 'post',
                data: {rule_id: rule_id},
                beforeSend:function(x){
                    btn.find('i').show();
                    $(".show-coupons").each(function(index, element) {
                        $(this).addClass('pace');
                    });
                },
                success: function(response){
                    $('.list-inline').html(response);
                    $('#modal-rule-main-coupons').modal('show');

                    btn.find('i').hide();
                    $(".show-coupons").each(function(index, element) {
                        $(this).removeClass('pace');
                    });
                },
            });
        }
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Coupon Rules</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Coupon Management</span>
                        <span class="breadcrumb-item active">Coupon Rules</span>
                    </nav>
                </div>
                <div class="header-action float-right">
                    <a class="btn btn-gradient-success " href="{{route('admin.coupon-rules.add')}}"> <i
                            class="fa fa-plus"></i> Add New Coupon Rule</a>
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
                                <th>Name</th>
                                <th>Is Active?</th>
                                <th>Is Generated?</th>
                                <th>Coupons</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Prefix</th>
                                <th>Suffix</th>
                                <th>Length</th>
                                <th>Quantity</th>
                                <th>Created At</th>
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

    <div class="modal fade" id="modal-rule-main-coupons">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="m-b-15">{{trans('txt.coupons')}}</h4>
                    <ul class="list-media-horizon list-inline">

                    </ul>
                    <div class="m-t-20 text-right">
                        <button class="btn btn-default" data-dismiss="modal">{{ trans('lfm.btn-close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
