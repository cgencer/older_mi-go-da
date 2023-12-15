@extends('admin.layouts.master')
@section('title')
    File Manager > Type: {{$_GET['type']}} | @parent
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">File Manager</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Dashboard</a>
                        <a class="breadcrumb-item" href="#">File Manager</a>
                        <span class="breadcrumb-item active">Type: {{$_GET['type']}}</span>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-block">
                                <iframe src="/admin/filemanager?type={{$_GET['type']}}" frameborder="0"
                                        style="width: 100%; height: calc(100vh - 220px);overflow: hidden; border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

