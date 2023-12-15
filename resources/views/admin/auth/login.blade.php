@extends('admin.layouts.account')
@section('title')Login | @parent @endsection
@section('styles')
    <style>
        .img-logo {
            display: table;
            margin: 0 auto;
            width: 250px;
        }

        .btn-gradient-success {
            background: linear-gradient(120deg, #ffd359 0%, #ef32c6 100%) !important;
            border-color: #fff;
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="app">
        <div class="layout bg-gradient-info">
            <div class="container">
                <div class="row full-height align-items-center">
                    <div class="col-md-5 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-15">
                                    <div class="m-b-30">
                                        <img class="img-responsive img-logo" src="{{asset('admin/assets/images/logo/logo.png')}}" alt="">
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <div> {{ $error }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <p class="m-t-15 font-size-13">Please enter your user name and password to login</p>
                                    <form action="{{route('admin.auth.login.post')}}" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                        <div class="checkbox font-size-13 d-inline-block p-v-0 m-v-0">
                                            <input id="agreement" name="remember_token" type="checkbox">
                                            <label for="agreement">Remember me</label>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#">Forgot Password?</a>
                                        </div>
                                        <div class="m-t-20 text-right">
                                            {{csrf_field()}}
                                            <button class="btn btn-gradient-success">Log in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
