@extends('hotel_admin.layouts.master')
@section('title')
    {{trans('txt.file_manager_title')}} {{$_GET['type']}} | @parent
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">{{trans('txt.file_manager')}}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.admin_menu_dashboard')}}</a>
                        <a class="breadcrumb-item" href="#">{{trans('txt.file_manager')}}</a>
                        <span class="breadcrumb-item active">Type: {{$_GET['type']}}</span>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-block">
                                <iframe src="/filemanager?type={{$_GET['type']}}" frameborder="0" style="width: 100%; height: calc(100vh - 220px);overflow: hidden; border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

