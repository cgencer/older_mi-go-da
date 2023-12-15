@extends('errors.error_layout')
@section('title')403 - {{ $exception->getMessage() }} | @parent @endsection
@section('content')
    <div class="app">
        <div class="layout">
            <div class="container">
                <div class="row full-height align-items-center">
                    <div class="col-12">
                        <div class="text-center p-t-50">
                            <h1 class="font-size-170 text-secondary font-weight-light text-opacity ls-2">403</h1>
                            <h2 class="font-weight-light font-size-30">{{ $exception->getMessage() }}</h2>
                            <a href="{{route('f.index')}}" class="btn btn-gradient-success btn-lg m-t-30">Go Homepage</a>
                        </div>
                    </div>
                    <div class="col-12 align-self-end ">
                        <div class="text-center p-b-20 font-size-13">
                            <span>Copyright © {{date('Y')}}<b class="text-dark"> {{config('app.name')}}</b>. All rights reserved.</span>
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
