@extends('front.layouts.master')@php
    $logged = \Illuminate\Support\Facades\Auth::check();
    if($logged){
        $user = \Illuminate\Support\Facades\Auth::user();
    }
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title') {{trans('txt.link_how_it_works')}} @parent @endsection
@section('body')
    <div class="how-it-works">
        {{--<img class="desktop-only content-image" src="{{ asset('front/assets/images/pages/how-it-works.png') }}"/>
        <img class="mobile-only content-image" src="{{ asset('front/assets/images/pages/how-it-works_mobile.png') }}"/>--}}

        <div class="hiw-header">
            <h1>{{trans('txt.how_it_works_title')}}</h1>
            <h4>{{trans('txt.how_it_works_desc')}}</h4>
        </div>

        <div class="hiw-content">

            <div class="hiw-section block-left">

                <div class="number">1</div>

                <div class="left-block">
                    <div class="title">{{trans('txt.how_it_works_block_title1')}}</div>
                    <div class="content">
                        {{trans('txt.how_it_works_block_desc1')}}
                    </div>
                </div>
                <div class="right-block">
                    <img src="{{ asset('front/assets/images/pages/hiw1.png') }}"/>
                </div>

            </div>

            <div class="hiw-section block-right">

                <div class="number">2</div>

                <div class="right-block">
                    <img src="{{ asset('front/assets/images/pages/hiw2.png') }}"/>
                </div>

                <div class="left-block">
                    <div class="title">{{trans('txt.how_it_works_block_title2')}}</div>
                    <div class="content">
                        {!! trans('txt.how_it_works_block_desc2') !!}
                    </div>
                </div>

            </div>

            <div class="hiw-section block-left">

                <div class="number">3</div>

                <div class="left-block">
                    <div class="title">{{trans('txt.how_it_works_block_title3')}}</div>
                    <div class="content">
                        {!! trans('txt.how_it_works_block_desc3') !!}
                    </div>
                </div>

                <div class="right-block">
                    <img src="{{ asset('front/assets/images/pages/hiw3.png') }}"/>
                </div>

            </div>

            <div class="hiw-section block-right">

                <div class="number">4</div>

                <div class="right-block">
                    <img src="{{ asset('front/assets/images/pages/hiw4.png') }}"/>
                </div>

                <div class="left-block">
                    <div class="title">{{trans('txt.how_it_works_block_title4')}}</div>
                    <div class="content">
                        {!! trans('txt.how_it_works_block_desc4') !!}
                    </div>
                </div>

            </div>

            <div class="hiw-section block-left">

                <div class="number">5</div>

                <div class="left-block">
                    <div class="title">{{trans('txt.how_it_works_block_title5')}}</div>
                    <div class="content">
                        {{trans('txt.how_it_works_block_desc5')}}
                    </div>
                </div>

                <div class="right-block">
                    <img src="{{ asset('front/assets/images/pages/hiw5.png') }}"/>
                </div>

            </div>

        </div>
    </div>
@endsection
