@extends('admin.layouts.master')
@section('title')
    Contact Form Show (ID: {{$data->id}}) | @parent
@endsection
@section('page_styles')
@endsection
@section('scripts')
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Contact Form Show (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <a class="breadcrumb-item" href="{{route('admin.contact.index')}}">Contact Form</a>
                        <span class="breadcrumb-item active">Contact Form Show (ID: {{$data->id}})</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-show">
                        <tbody>
                        <tr>
                            <th>Fullname</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->fullname}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->email}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->phone}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->created_at}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->subject}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>
                                <p class="form-control-plaintext">
                                    {{$data->message}}
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="text-sm-left">
                                    <a href="{{route('admin.contact.remove',['id'=>$data->id])}}" onclick="return confirm('Are you sure you want to delete it?');" class="btn btn-danger" title="Remove">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
