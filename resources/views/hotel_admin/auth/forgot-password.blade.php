@extends('hotel_admin.layouts.account')
@section('title'){{ trans('txt.forget_password') }} | @parent @endsection
@section('styles')
    <style>
        .img-logo {
            display: table;
            margin: 0 auto;
            width: auto;
            max-width: 250px;
        }

        .btn-gradient-success {
            background: linear-gradient(120deg, #ffd359 0%, #ef32c6 100%) !important;
            border-color: #fff;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="app hotel-auth sign-up-template" style="height: 100vh !important;">
        <section class="mgd-signup">
            <div class="mgd-signup-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="mgd-signup-section__title-wrap col-lg-6"
                             style='background-image: url("{{asset('admin/assets/images/admin/hotelBanner.png')}}")'>
                            <div class="mgd-signup-section__title">
                                <h1 class="mgd-text--size-62 mgd-text--700 mgd-text--white">{!! trans('txt.lets_get_started') !!}</h1>
                            </div>
                        </div>
                        <div class="mgd-form-wrapper-parent col-lg-6 padding-left-none padding-right-none">
                            <div
                                class="mgd-form-wrapper mgd-form-wrapper--padding-md mgd-form-wrapper--padding-sm clearfix"
                                style="height: 100%;">
                                <div class="mgd-login-nav">
                                    <ul class="mgd-login-nav__ul list-style-none">
                                        <li class="mgd-login-nav__item">
                                            <a href="{{route('hotel_admin.auth.login')}}"
                                               class="mgd-text--gray">{{trans('txt.link_login')}}</a>
                                        </li>
                                        <li class="mgd-login-nav__item">
                                            <a href="https://www.migodahotels.com/panel/signup.php?lang={{\Illuminate\Support\Facades\App::getLocale()}}"
                                               class="mgd-btn mgd-btn--default mgd-btn--small">{{trans('txt.join-for-free')}}</a>
                                        </li>
                                        <li class="mgd-login-nav__item">
                                            <div class="mgd-lang-select">
                                                <span class="mgd-lang-select__item mgd-text--gray text-uppercase">{{\Illuminate\Support\Facades\App::getLocale()}} <i
                                                        class="fa fa-caret-down"></i></span>
                                                <div class="mgd-lang-select__dropdown">
                                                    <ul>
                                                        @foreach (\Illuminate\Support\Facades\Config::get('languages') as $lang => $language)
                                                            @if ($lang !== \Illuminate\Support\Facades\App::getLocale())
                                                                <li><a href="{{ route('lang.switch', $lang) }}"
                                                                       class="mgd-text--gray">{{$language}}</a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mgd-close">
                                    <a href="https://www.migodahotels.com/"><i class="fa fa-times"></i></a>
                                </div>
                                <figure class="mgd-logo margin-top--100">
                                    <a href="{{route('hotel_admin.auth.login')}}">
                                        <img src="{{asset('admin/assets/images/admin/hotelLogo.png')}}"
                                             class="mgd-logo__img" alt=""></a>
                                </figure>
                                <div class="mgd-form-wrapper__info">
                                    <div class="row margin-top--45">
                                        <span
                                            class="mgd-form-wrapper__info-item mgd-text--small mgd-text--600 mgd-text--black2 col-12 text-capitalize">{{ trans('txt.reset_pass') }}</span>
                                    </div>
                                </div>
                                <form class="mgd-form" method="post"
                                      action="{{ route('hotel_admin.auth.forgot-password.submit') }}">
                                    @include('front.partials.alert')
                                    <div class="form-row margin-top--20">
                                        <div class="col">
                                            <input type="email" name="email"
                                                   class="mgd-form__input mgd-placeholder--gray2"
                                                   placeholder="{{ trans('txt.field_email') }}"
                                                   required>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="mgd-btn mgd-btn--default mgd-btn--medium mgd-btn--shadow margin-top--45 text-capitalize">{{ trans('txt.reset_pass') }}</button>
                                </form>
                                <div class="contact-output mgd-text--gray margin-top--20"></div>
                            </div>
                        </div>
                    </div> <!-- end .row -->
                </div> <!-- end .container-fluid -->
            </div>
        </section>
    </div>
@endsection
