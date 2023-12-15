@extends('admin.layouts.master')
@section('title')
    Feature Categories | @parent
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
                "ajax": "{{route('admin.feature_categories.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "width": 120, "targets": 4},
                ],
                "order": [[0, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id"},
                    {"data": "icon"},
                    {"data": "name"},
                    {"data": "updated_at"},
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
                <h2 class="header-title">Feature Categories</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Hotel Management</span>
                        <span class="breadcrumb-item active">Feature Categories</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
            {{--    <div class="card-header p-b-0">
                    <div class="text-right">
                        <a href="{{route('admin.feature_categories.add')}}" class="btn btn-success">Add New Category</a>
                    </div>
                </div>--}}
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
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Updated At</th>
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
