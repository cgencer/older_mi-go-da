@extends('front.layouts.master')
@section('title') {{ trans('txt.data_privacy_title') }} @parent @endsection
@section('styles')
    <style>
        .panel-body p {
            line-height: 1.5em !important;
        }


    </style>
@endsection
@section('body')
    <div class="content-page  middle-wrapper">
        <div class="content-header">
            <div class="content-header-inner mg-section   mg-group p-10">
                <div class="mg-col mg-span_12_of_12 pages-title">
                    <h1>{{ trans('txt.data_privacy_title') }}</h1>
                </div>
            </div>
        </div>
        <div class="content mg-section mg-group">
            <div class="mg-col mg-span_12_of_12">
                &nbsp;<div class="faq-panel2 panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($faqs as $faq)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#faq_{{$faq->id}}" class="collapsed" aria-expanded="false">
                                        <span>{{$faq->title}}</span> </a>
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
