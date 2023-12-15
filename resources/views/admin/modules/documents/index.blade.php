@extends('admin.layouts.master')
@section('title')
    Documents Managament | @parent
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
                "ajax": "{{route('admin.documents.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "width": 120, "targets": 7},
                ],
                "order": [[0, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id"},
                    {"data": "hotel_name"},
                    {"data": "name"},
                    {"data": "description"},
                    {"data": "creator"},
                    {"data": "status"},
                    {"data": "type"},
                    {"data": "created_at"},
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
                <h2 class="header-title">Documents Managament</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Document Management</span>
                    </nav>
                </div>
                <div class="header-action float-right">
                    <a class="btn btn-gradient-success" href="{{route('admin.documents.add.document')}}"> <i class="fa fa-plus"></i> Create New Document</a>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    <div class="table-overflow table-responsive">
                        <table id="dt-opt" class="table table-hover table-xl">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Hotel Name</th>
                                <th>Document Name</th>
                                <th>Document Description</th>
                                <th>Creator</th>
                                <th>Document Status</th>
                                <th>Type</th>
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

@endsection

