@extends('admin.layouts.master')
@section('title')
    Hotels | @parent
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
                "ajax": "{{route('admin.hotels.index.ajax')}}",
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
                    {"data": "hotel", 'name': 'hotel'},
                    {"data": "user", 'name': 'user'},
                    {"data": "address", 'name': 'address'},
                    {"data": "country_id", 'name': 'country_id'},
                    {"data": "created_at", 'name': 'created_at'},
                    {"data": "updated_at", 'name': 'updated_at'},
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
                <h2 class="header-title">Hotels</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Hotel Management</span>
                        <span class="breadcrumb-item active">Hotels</span>
                    </nav>
                </div>
                <div class="header-action float-right">
                    <a class="btn btn-gradient-success " href="{{route('admin.hotels.add')}}"> <i
                            class="fa fa-plus"></i> Add New Hotel</a>
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
                                <th>Hotel</th>
                                <th>User</th>
                                <th>Address</th>
                                <th>Country</th>
                                <th>Created At</th>
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
