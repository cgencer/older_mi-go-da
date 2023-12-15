@extends('front.layouts.master')@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title') {{trans('txt.link_about')}} @parent @endsection
@section('body')
    <style>
        .about-us-hero {
            background-size: cover;
        }
    </style>
    <div class="about-us-hero">
        <div class="mg-section mg-group middle-banner">
            <div class="col-6 mg-span_8_of_12">
                <h2>{{ trans('txt.about_us') }}</h2>
                {!! trans('txt.about_page_content') !!}
            </div>
            <div class="mg-col mg-span_2_of_12 empty-mg-col">
                &nbsp;
            </div>
        </div>
    </div>

    <div class="about-us-title col-7">
        <h2>“{{ trans('txt.about_spot') }}“</h2>
        <p class="middle-hiw_desc">
            - Kurt Tucholsky </p>
    </div>

    <div class="about-us-desc">
        <div class="col-6 ">
            <img  src="{{asset('front/assets/images/pages/about-us-desc.png')}}">
        </div>
        <div class="col-6 hide-mobile">
            {!! trans('txt.about_page_second_content') !!}
        </div>
        <div class="col-6 hide-desktop">
            {!! trans('txt.about_page_second_content') !!}
        </div>
    </div>
    <div class="about-us-desc about-us-third hide-desktop">
        <div class="col-12">
            {!! trans('txt.about_page_third_content') !!}
        </div>
    </div>
@endsection
