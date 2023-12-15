@extends('front.layouts.master')@php
    $logged = \Illuminate\Support\Facades\Auth::check();
    if($logged){
        $user = \Illuminate\Support\Facades\Auth::user();
    }
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title') {{trans('txt.link_faq')}} @parent @endsection
<style>
    .logo_wrapper {
        height: 99px;
        display: flex !important;
        align-items: center;
        justify-content: left;
        flex-direction: row;
        flex-wrap: wrap;
        flex-flow: row wrap;
        align-content: center;
    }

    .main-content_wrapper .content .panel-body {
        padding: 0 20px;
    }

    .main-content_wrapper .content ul {
        margin-bottom: 0;
        padding-left: 0;
    }
</style>
@section('body')
    <div class="content-page  middle-wrapper">
        <div class="content-header">
            <div class="content-header-inner mg-section  mg-group">
                <div class="mg-col mg-span_12_of_12">
                    &nbsp;<h1>{{trans('txt.link_faq')}}</h1>
                    <h2>{{trans('txt.link_faq_desc')}}</h2>
                </div>
            </div>
        </div>
        <div class="content mg-section mg-group">
            <div class="mg-col mg-span_12_of_12">
                &nbsp;<div class="faq-panel panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($faqs as $faq)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#faq_{{$faq->id}}" class="collapsed" aria-expanded="false">
                                        <span class="icon">
                                            <img src="{{$faq->icon2}}" class="white" alt="">
                                            <img src="{{$faq->icon}}" class="colored" alt="">
                                        </span> <span>{{$faq->title}}</span> </a>
                                </h2>
                            </div>
                            <div id="faq_{{$faq->id}}" class="panel-collapse collapse" role="tabpanel" style="height: 0px;">
                                <div class="panel-body">
                                    {!! str_replace('&nbsp;','',$faq->content) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
