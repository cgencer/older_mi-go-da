@extends('hotel_admin.layouts.master')
@section('title')
    Faq | @parent
@endsection
@section('page_styles')
@endsection
@section('scripts')
@endsection
@section('content')
    <div class="main-content no-padding">
        <div class="page_header">
            <div class="container">
                <div class="title">
                    <h1>{{trans('txt.link_faq')}}</h1>
                    <h3>{{trans('txt.link_faq_desc')}}</h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="faq-panel panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($faq as $faq_data)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <h2 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#faq_{{$faq_data->id}}" class="collapsed" aria-expanded="false">
                                    <span class="icon">
                                            <img src="{{$faq_data->icon2}}" class="white" alt="">
                                            <img src="{{$faq_data->icon}}" class="colored" alt="">
                                        </span> <span>{{$faq_data->title}}</span>
                                </a>
                            </h2>
                        </div>
                        <div id="faq_{{$faq_data->id}}" class="panel-collapse collapse" role="tabpanel" style="height: 0px;">
                            <div class="panel-body">
                                {!! str_replace('&nbsp;','',$faq_data->content) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
