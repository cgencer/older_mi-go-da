@extends('errors.error_layout')
@section('title')500 - Internal Server Error | @parent @endsection
@section('content')
    <div class="app">
        <div class="layout">
            <div class="container">
                <div class="row full-height align-items-center">
                    <div class="col-md-7">
                        <div class="m-t-15 m-l-20">
                            <h1 class="font-size-55 text-semibold">500</h1>
                            <h2 class="font-weight-light font-size-35">Internal Server Error</h2>
                            <p class="width-70 text-opacity m-t-25 font-size-16">{{ $exception->getMessage() }}</p>
                            <div class="m-t-15">
                                <a href="{{route('f.index')}}" class="btn btn-gradient-success btn-lg m-t-30">Go Homepage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-none d-md-block">
                        <img class="img-fluid" src="{{asset('admin/assets/images/others/img-33.png')}}" alt="">
                    </div>
                    <div class="col-12 align-self-end ">
                        <div class="text-center p-b-20 font-size-13">
                            <div class="copyright">
                                <span>Copyright © {{date('Y')}}<b class="text-dark"> {{config('app.name')}}</b>. All rights reserved.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')

@endsection
@section('scripts')

@endsection
