@extends('errors.error_layout')
@section('title')404 - Whoops! Looks like you got lost | @parent @endsection
@section('body')
    <div class="custom-not-found-page">
        <div class="layout">
            <div class="container">
                <div class="row full-height align-items-center">

                    <div class="col-12">
                        <div class="text-center">
                            <div class="custom-not-found-image">
                                <img src="{{asset('front/assets/images/pages/404-door.png')}}" alt="">
                                <div class="custom-not-found-image-content">
                                    <div class="custom-not-found-page-title">
                                        <span>Ooops!</span>
                                        No one <br>
                                        inside here
                                    </div>
                                    <div class="custom-not-found-page-desc">
                                        Either something went
                                        wrong or the page
                                        doesn’t exist anymore.
                                    </div>
                                    <div class="custom-not-found-actions">
                                        <a href="/">
                                            Home Page
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
