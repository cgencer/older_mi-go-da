@extends('hotel_admin.layouts.master')
@section('title')
    Documents | @parent
@endsection
@section('page_styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/datatables/media/css/dataTables.bootstrap4.min.css')}}"/>

    <style>


    </style>
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#dt-opt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('hotel_admin.documents.index.ajax')}}",
                "fixedColumns": false,
                "autoWidth": false,
                "columnDefs": [
                    {"orderable": false, "width": 120, "targets": 5},
                ],
                "order": [[3, 'desc']],
                "displayLength": 10,
                "dom": 'Blfrtip',
                "columns": [
                    {"data": "id"},
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
                <h2 class="header-title">{{trans('txt.admin_menu_documents')}}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <span class="breadcrumb-item">{{trans('txt.link_document_management')}}</span>
                        <span class="breadcrumb-item active">{{trans('txt.admin_menu_documents')}}</span>
                    </nav>
                </div>
                <div class="header-action float-right">
                    <a class="btn btn-gradient-success" href="{{route('hotel_admin.documents.add.document')}}"> <i class="fa fa-plus"></i> {{ trans('txt.link_add_document') }}</a>
                </div>
                @php
                      $user = Auth::guard('user')->user();
                      $hotel = \App\Models\Hotels::where('user_id', $user->id)->get()->first();


                @endphp
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    @include('hotel_admin.modules.documents.alert-documents')
                    <div class="table-overflow table-responsive">
                        <table id="dt-opt" class="table table-hover table-xl">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('txt.table_document_name')}}</th>
                                <th>{{trans('txt.table_document_description')}}</th>
                                <th>{{trans('txt.table_document_creator')}}</th>
                                <th>{{trans('txt.table_document_status')}}</th>
                                <th>{{trans('txt.add_document_field_type')}}</th>
                                <th>{{trans('txt.table_document_created_at')}}</th>
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



