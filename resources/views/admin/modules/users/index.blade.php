@extends('admin.layouts.master')
@section('title')
    Hotel Users | @parent
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
                "ajax": "{{route('admin.users.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "width": 120, "targets": 6},
                ],
                "order": [[4, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id", 'name': 'id'},
                    {"data": "user", 'name': 'user'},
                    {"data": "email", 'name': 'email'},
                    {"data": "enabled", 'name': 'enabled'},
                    {"data": "created_at", 'name': 'created_at'},
                    {"data": "last_login", 'name': 'last_login'},
                    {"data": "action", 'name': 'action'},
                ]
            });
        });
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">User Management</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">User Management</span>
                        <span class="breadcrumb-item active">Hotel Users</span>
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
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Last Login</th>
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
