@extends('front.layouts.master')
@section('title') {{$data->title}} @parent @endsection
@section('styles')
<style>
    .content-page p {
        line-height: 1.5em !important;
        margin-bottom: 0.6em !important;
    }


</style>
@endsection
@section('body')
    <div class="content-page  middle-wrapper">
        <div class="content-header">
            <div class="content-header-inner mg-section   mg-group p-10">
                <div class="mg-col mg-span_12_of_12 pages-title">
                    <h1>{{$data->title}}</h1>
                </div>
            </div>
        </div>
        <div class="content mg-group mg-section pages-content">
            <div class="mg-col mg-span_12_of_12 ">
                {!! $data->content !!}
            </div>
        </div>
    </div>
@endsection
