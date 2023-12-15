@extends('hotel_admin.layouts.account')
@section('title'){{trans('txt.link_login')}} | @parent @endsection
@section('styles')
    <style>

    </style>
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="app hotel-auth" style="height: 100vh !important;">
        <section class="mgd-signup">

            <div class="mgd-signup-section">

                <div class="container-fluid">

                    <div class="row">

                        <div class="mgd-signup-section__title-wrap col-lg-6"
                             style='background-image: url("{{asset('admin/assets/images/admin/hotelBanner.png')}}")'>
                            <div class="mgd-signup-section__title">
                                <h1 class="mgd-text--size-50 mgd-text--700 mgd-text--white">  {{ trans('txt.hello') }}
                                    <br> {{ trans('txt.welcome_back') }}</h1>
                            </div>
                        </div>

                        <div class="col-lg-6 padding-left-none padding-right-none">
                            <div
                                class="mgd-form-wrapper mgd-form-wrapper--padding-md mgd-form-wrapper--padding-sm clearfix"
                                style="height: 100% !important;">
                                <div class="mgd-login-nav">
                                    <ul class="mgd-login-nav__ul list-style-none">
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
                                <form class="mgd-form margin-top--75" method="post"
                                      action="{{ route('hotel_admin.auth.login') }}">
                                    @include('front.partials.alert')
                                    <div class="form-row margin-top--20">
                                        <div class="col padding-right--30">
                                            <input type="text" id="username" name="email"
                                                   class="mgd-form__input mgd-placeholder--gray2"
                                                   placeholder="{{ trans('txt.field_email') }}">
                                        </div>
                                        <div class="col padding-left--30">
                                            <input type="password" id="password" name="password"
                                                   class="mgd-form__input mgd-placeholder--gray2"
                                                   placeholder="{{ trans('txt.field_password') }}">
                                        </div>
                                    </div>

                                    <div class="form-row form-row-align-items margin-top--45">
                                        <div class="mgd-form__checkbox-wrapper">
                                            <input type="checkbox" id="agreement" name="_remember_me"
                                                   class="mgd-form__checkbox"/>
                                            <label for="agreement"><a href="#"
                                                                      class="mgd-form__link2 mgd-text--gray3 mgd-text--size-14">{{ trans('txt.link_remember_me') }}</a></label>
                                        </div>
                                        <a href="{{ route('hotel_admin.auth.forgot-password') }}"
                                           class="mgd-form__link3 mgd-text--gray3 mgd-text--size-14 float-right">{{ trans('txt.forget_password') }}</a>
                                    </div>


                                    <button type="submit"
                                            class="mgd-btn mgd-btn--default mgd-btn--medium mgd-btn--shadow margin-top--45">{{ trans('txt.link_login') }}</button>
                                </form>


                            </div>
                        </div>

                    </div> <!-- end .row -->

                </div> <!-- end .container-fluid -->

            </div>

        </section>
    </div>
@endsection
