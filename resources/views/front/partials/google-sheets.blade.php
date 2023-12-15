@extends('front.layouts.master')
@section('title') Google Sheets @endsection
@section('body_class') google-sheets @endsection
@section('body')
    <div class="page-header">
        <h1 class="title">{{trans('txt.google_sheets_title')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}">{{trans('txt.google_sheets_dashboard_link')}}</a></li>
            <li class="active"> Oteller Arşivi</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-sm">
            <form action="{{ route('post.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">{{trans('txt.google_sheets_name_field')}}</label>
                    <input name="name" type="text" class="form-control" id="name" required>
                </div>

                <div class="form-group">
                    <label for="message">{{trans('txt.google_sheets_message_field')}}</label>
                    <input name="message" type="text" class="form-control" id="message" required>
                </div>

                <button type="submit" class="btn btn-primary">{{trans('txt.google_sheets_submit')}}</button>
            </form>
        </div>

        <div class="col-sm">
            <div class="list-group mt-3">
                @foreach($posts as $post)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ data_get($post, 'name') }}</h5>
                        </div>
                        <p class="mb-1">
                            {{ data_get($post, 'message') }}
                        </p>
                        <small>
                            {{ data_get($post, 'created_at') }} {{ config('app.timezone') }}
                        </small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

