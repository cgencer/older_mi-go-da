@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
   $currentPage = "";
   if (Illuminate\Support\Facades\Route::current()) {
       $currentPage = Illuminate\Support\Facades\Route::current()->getName();
   }
   $logged = \Illuminate\Support\Facades\Auth::guard('customer')->check();
   if ($logged) {
       $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
   }
@endphp

<header>
    <a name="top"></a>
    <div class="mg-section mg-group">
        <div class="mg-col mg-span_3_of_12 logo_wrapper">
            <a href="/" title="{{\Illuminate\Support\Facades\Config::get('app.name')}}" class="header-logo"><img
                    src="{{ asset('front/assets/images/logo-header.png') }}"
                    alt="{{\Illuminate\Support\Facades\Config::get('app.name')}}"/></a>
            <a href="#" class="mobile-menu-toggle mobile-only"><i class="fa fa-bars"></i><i class="fa fa-times"></i></a>
        </div>
        <div class="mg-col mg-span_5_of_12 header-navigation_wrapper">
            @hasSection('top_nav')
                @yield('top_nav')
            @else
                <ul class="header-navigation desktop-only">
                    <li>
                        <a {{ ($currentPage == 'f.about') ? 'class=active':''}} href="{{ route('f.about') }}">{{ trans("txt.link_about") }}</a>
                    </li>
                    <li>
                        <a {{ ($currentPage == 'f.how-it-works') ? 'class=active':''}} href="{{ route('f.how-it-works') }}">{{ trans("txt.link_how_it_works") }}</a>
                    </li>
                    <li>
                        <a {{ ($currentPage == 'f.destinations' || $currentPage == 'f.detail') ? 'class=active':''}} href="{{ route('f.destinations') }}">{{ trans("txt.link_destinations") }}</a>
                    </li>
                </ul>
            @endif
        </div>
        <div class="mg-col mg-span_4_of_12 header-links_wrapper header-links_wrapper__desktop">
            <ul class="header-links desktop-only">
                <li class="menu-language submenu-trigger">
                    <a href="#">
                        <span>
                            <i class="fa fa-caret-down"></i>
                            <i class="fa fa-caret-up"></i>
                        </span>
                        {{ trans('txt.trans_'.\Illuminate\Support\Facades\App::getLocale()) }}
                    </a>
                    <div class="arrow_box language_box">
                        @foreach (\Illuminate\Support\Facades\Config::get('languages') as $lang_slug => $language)
                            @if ($lang_slug !== \Illuminate\Support\Facades\App::getLocale())
                                <a href="{{ route('lang.switch', $lang_slug) }}">{{ trans('txt.trans_'.$lang_slug) }}</a>
                            @endif
                        @endforeach
                    </div>
                </li>
                @if($logged === false)
                    <li class="menu-login">
                        <a href="{{route('auth.login')}}" class="">{{ trans("txt.link_login") }}</a>
                    </li>
                    <li class="menu-signup signup">
                        <a class="mg-secondary-button"
                           href="{{route('auth.register')}}">{{ trans("txt.link_signup") }}</a>
                    </li>
                @else
                    <li class="menu-addcoupon">
                        @if($currentPage == 'f.index')
                            <a class="mg-secondary-button" href="javascript:;"
                               onclick="$('.coupon-area').css({'display':'block'});closeProfileMenu();">{{ trans("txt.link_add_coupon") }}</a>
                        @else
                            <a class="mg-secondary-button" href="#" data-toggle="modal"
                               data-target="#addCouponsModalCenter">{{ trans("txt.link_add_coupon") }}</a>
                        @endif
                    </li>
                    <li class="menu-profile submenu-trigger">
                        <a href="#">
                            <span>
                                <i class="fa fa-caret-down"></i>
                                <i class="fa fa-caret-up"></i>
                            </span>
                            @if ($user->profile_image)
                                <img class="menu-avatar"
                                     src="{{ $user->profile_image->getUrl() }}"
                                     alt="">
                            @else
                                <img class="menu-avatar"
                                     src="{{ asset('front/assets/images/avatars/default_avatar.png') }}"
                                     alt="">
                            @endif
                        </a>
                        <div class="arrow_box profile_box">
                            <ul>
                                <li><a href="{{ route('auth.profile') }}">
                                        @if ($user->profile_image)
                                            <img class="small-avatar"
                                                 src="{{ $user->profile_image->getUrl() }}"
                                                 alt="">
                                        @else
                                            <img class="small-avatar"
                                                 src="{{ asset('front/assets/images/avatars/default_avatar.png') }}"
                                                 alt="">
                                        @endif
                                        <span
                                            class="text">{{ ($user->firstname != "") ? $user->firstname . ' ' . $user->lastname : $user->name }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.bookings') }}">
                                        <span class="icon">
                                            <img src="{{asset('front/assets/images/svg/route.svg')}}"
                                                 alt="">
                                        </span>
                                        <span class="text">{{ trans("txt.link_journey_information") }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.wishlist') }}">
                                            <span class="icon">
                                        <i class="fa fa-heart-o"></i>
                                            </span>
                                        <span class="text">{{ trans("txt.link_wishlist") }}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="profile-menu-bottom">
                                <div class="existing-coupons coupons-box">
                                    <div class="coupon-box-inner">
                                        <div class="inner coupons_valid"></div>
                                    </div>
                                    <div class="left">
                                        <h5>{{ trans("txt.header_your_coupons") }}</h5>

                                        @if($currentPage == 'f.index')
                                            <a href="javascript:;"
                                               onclick="$('.coupon-area').css({'display':'block'});closeProfileMenu();">{{ trans("txt.link_add_coupon") }}</a>
                                        @else
                                            <a href="#" data-toggle="modal"
                                               data-target="#addCouponsModalCenter">{{ trans("txt.link_add_coupon") }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</header>
@if (session('user_registered'))
    @php session('user_registered',''); @endphp
    <div class="registered">
        <div class="registered--content">
            <a href="#" class="trigger_registered--close"><i class="fa fa-times"></i></a>
            <img src="{{ asset('front/assets/images/svg/completed.svg') }}"/>
            <h1>{{trans('txt.header_cong')}}</h1>
            <p>{{trans('txt.header_cong_content')}}</p>
            <a href="{{ route('f.destinations') }}"
               class="mg-primary-button">{{ trans("txt.ind_discover_destinations_header") }}</a>
        </div>
    </div>
@endif

<div class="mobile-menu mobile-only">
    <ul class="header-navigation">
        <li>
            <a {{ $currentPage == 'f.about' ?  'class=active':'' }} href="{{ route('f.about') }}">{{ trans("txt.link_about") }}</a>
        </li>
        <li>
            <a {{ $currentPage == 'f.how-it-works' ?  'class=active':'' }} href="{{ route('f.how-it-works') }}">{{ trans("txt.link_how_it_works") }}</a>
        </li>
        <li>
            <a {{ $currentPage == 'f.destinations' || $currentPage == 'f.detail' ?  'class=active':'' }} href="{{ route('f.destinations') }}">{{ trans("txt.link_destinations") }}</a>
        </li>
    </ul>
    <ul class="header-links">
        @if($logged === false)
            <li class="menu-login">
                <a href="{{route('auth.login')}}" class="">{{ trans("txt.link_login") }}</a></li>
            <li class="menu-signup signup">
                <a class="mg-secondary-button" href="{{route('auth.register')}}">{{ trans("txt.link_signup") }}</a>
            </li>
        @else
            <li class="menu-profile">
                <a href="{{ route('auth.profile') }}" class="btn btn-default btn-flat"><i class="fa fa-user"></i>
                    {{ $user->username }}
                </a>
            </li>
            <li class="menu-logout">
                <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat"><i
                        class="fa fa-sign-out fa-fw"></i>
                    {{ trans("txt.link_logout") }}
                </a>
            </li>
        @endif
        <li class="menu-language">
            <a href="#"> {{ \Illuminate\Support\Facades\Config::get('languages')[\Illuminate\Support\Facades\App::getLocale()] }}
                <span><i class="fa fa-caret-down"></i></span></a>
            <div>
                @foreach (\Illuminate\Support\Facades\Config::get('languages') as $lang => $language)
                    @if ($lang !== \Illuminate\Support\Facades\App::getLocale())
                        <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                    @endif
                @endforeach
            </div>
        </li>
    </ul>
</div>
@if($logged === false && (Route::current()->getName() == "auth.register" || Route::current()->getName() == "auth.login" || Route::current()->getName() == "auth.forgot-password"))
    <div>
        <div class="signup-login">
            <div class="signup-login__left">
                <h3 class="login_message">{{ trans("txt.welcome_back") }}<br/>{{ trans("txt.lets_go") }}</h3>
                <h3 class="signup_message">{{ trans("txt.hello") }}<br/>{{ trans("txt.start_journey1") }}
                    <br/>{{ trans("txt.start_journey2") }}</h3>
            </div>
            <div class="signup-login__right mg-section mg-group">
                <div class="signup-login__right-empty">
                    &nbsp;
                </div>
                <div class="signup-login__right-content">
                    <a href="{{route('f.index')}}" class="signup-login_close signup-login_close_mobile"><i
                            class="fa fa-times"></i></a>
                    <div class="signup-login__form_wrapper">
                        <a href="/" title="Migoda" class="signup-login__logo"><img
                                src="{{ asset('front/assets/images/logo-header.png') }}" alt="Migoda"/></a>
                        @include('front.partials.alert')
                        {{ Form::open(array('route' => 'auth.login', 'method'=>'post','role'=>'form','class'=>'form-horizontal', 'id' => "login-form")) }}
                        <div class="login_form generic-form">
                            <div class="form-input">
                                {!! Form::text('username', null, ['placeholder' => trans("txt.field_email")]) !!}
                            </div>
                            <div class="form-input">
                                {!! Form::password('password', ['placeholder' => trans("txt.field_password")]) !!}
                            </div>
                            <div class="form-helpers clearfix">
                                <div class="left">
                                    <label>
                                        {!! Form::checkbox('remember_me', 'on', false) !!}
                                        {{ trans("txt.link_remember_me") }}
                                    </label>
                                </div>
                                <div class="right">
                                    <a href="#" class="switch_forgotten">{{ trans("txt.link_forgot_password") }}</a>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="mg-primary-button handButton">{{ trans("txt.link_login") }}</button>
                                <button
                                    class="mg-secondary-button switch_signup handButton">{{ trans("txt.link_signup") }}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        {{ Form::open(array('route' => 'auth.register', 'method'=>'post','role'=>'form','class'=>'form-horizontal','autocomplete'=>'off',  'id' => "register-form")) }}
                        <div class="signup_form generic-form">
                            <div class="form-input">
                                {{ Form::text('firstname', Session::get('signupInformations') != null ? Session::get('signupInformations')['firstname'] : null, array(
                                    'required' => 'required',
                                    'class' => '',
                                    'id' => '',
                                    'placeholder' => trans('txt.field_firstname'),
                                    'autocomplete' => 'off',
                                     "oninvalid"=>  trans('txt.custom_error_complete_area'),
                                    "onchange"=> "this.setCustomValidity('')"
                                )) }}
                            </div>
                            <div class="form-input">
                                {{ Form::text('lastname', Session::get('signupInformations') != null ? Session::get('signupInformations')['lastname'] : null, array(
                                    'required' => 'required',
                                    'class' => '',
                                    'id' => '',
                                    'placeholder' => trans('txt.field_lastname'),
                                    'autocomplete' => 'off',
                                    "oninvalid"=>  trans('txt.custom_error_complete_area'),
                                    "onchange"=> "this.setCustomValidity('')"
                                )) }}
                            </div>

                            <div class="form-input">
                                {{ Form::email('email', Session::get('signupInformations') != null ? Session::get('signupInformations')['email'] : null, array(
                                    'required' => 'required',
                                    'class' => '',
                                    'id' => '',
                                    'placeholder' => trans('txt.field_email'),
                                    'autocomplete' => 'off',
                                    "oninvalid"=> trans('txt.custom_error_mail_format'),
                                    "onchange"=> "this.setCustomValidity('')"
                                )) }}
                            </div>
                            <div class="form-input">
                                {{ Form::password('password', array(
                                    'required' => 'required',
                                    'class' => '',
                                    'id' => '',
                                    'placeholder' => trans('txt.field_password'),
                                    'autocomplete' => 'off',
                                    "oninvalid"=>  trans('txt.custom_error_complete_area'),
                                    "onchange"=> "this.setCustomValidity('')"
                                )) }}
                                <span class="minimum-pass-length">({{ trans('txt.minimum_password_length') }})</span>
                            </div>
                            <div class="form-input">
                                {{ Form::password('password_confirmation', array(
                                    'required' => 'required',
                                    'class' => '',
                                    'id' => '',
                                    'placeholder' => trans('txt.field_password_confirmation'),
                                    'autocomplete' => 'off',
                                    "oninvalid" =>  trans('txt.custom_error_complete_area'),
                                    "onchange" => "this.setCustomValidity('')"
                                )) }}
                            </div>
                            <div class="form-input" id="coupon-fields-list"
                                 data-prototype='{!! Form::text('coupon_codes[__name__]', null,
                                 ['required' => 'required','class' => 'coupon-code-box', 'placeholder'=>trans('txt.field_coupon_code'),"oninvalid"=>  trans('txt.custom_error_complete_area'),
                                    "onchange"=> "this.setCustomValidity('')"])

                                 !!}'
                                 data-widget-tags='{!! '<div class="form-input"></div>' !!}'>
                                <div class="form-input">
                                    {!! Form::text('coupon_codes[0]', null, ['required' => 'required','class' => 'coupon-code-box', 'placeholder'=>trans('txt.field_coupon_code'), "oninvalid"=>  trans('txt.custom_error_complete_area'),
                                    "onchange" => "this.setCustomValidity('')" ]) !!}
                                </div>
                            </div>
                            {{-- <div class="form-actions another-coupon-action">
                                <a class="add-another-coupon" data-list="#coupon-fields-list" href="#">[+]
                                    {{ trans('txt.link_add_coupon') }}</a>
                            </div> --}}
                            <div class="form-input terms-input-group">
                                <label>
                                    {!! Form::checkbox('terms', '1', null,  ['id' => 'terms', 'required'=>'required' ,  "oninvalid"=>  trans('txt.custom_error_terms_message'),
                                    "onchange" => "this.setCustomValidity('')"]) !!}
                                    {{--<a data-toggle="modal" data-target="#termsAndConditionsModalCenter" href="#"
                                       id="terms_link">{!! trans('txt.signup_terms_conditions_accept', ['terms' => url('terms-and-conditions'), 'privacy' => url('data-protection'), 'cookie' => url('cookie-policy')]) !!}</a>--}}
                                    {!! trans('txt.signup_terms_conditions_accept', ['terms' => url('terms-and-conditions'), 'privacy' => url('data-protection'), 'cookie' => url('cookie-policy') ]) !!}
                                </label>
                            </div>
                            <div class="form-actions">
                                <button class="mg-primary-button handButton">{{ trans('txt.link_signup') }}</button>
                                <button
                                    class="mg-secondary-button switch_login handButton">{{ trans('txt.link_login') }}</button>

                            </div>
                        </div>
                        {{ Form::close() }}
                        @if (!isset($create_new))
                            {{ Form::open(array('route' => 'auth.reset_password', 'method'=>'post','role'=>'form','class'=>'form-horizontal')) }}
                            <div class="forgotten_form generic-form">
                                <div class="form-input">
                                    {!! Form::email('email', null, ['placeholder'=> trans('txt.field_email'), "required" => "required" ]) !!}
                                </div>
                                <div class="form-actions">
                                    <button type="submit"
                                            class="mg-primary-button handButton">{{ trans('txt.reset_pass') }}</button>
                                    <button type="button"
                                            class="mg-secondary-button login_button handButton">{{ trans('txt.link_login') }}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        @else
                            {{ Form::open(array('route' => 'auth.create_new_password', 'method'=>'post','role'=>'form','class'=>'form-horizontal', 'id' => 'password_form')) }}
                            <div class="create_password_form generic-form">
                                <div class="form-input">
                                    {!! Form::hidden('customer', $customer) !!}
                                    {!! Form::hidden('reset_id', $resetId) !!}
                                    {!! Form::password('password', ['placeholder'=> 'New Password', 'id' => 'password' ], null) !!}

                                </div>
                                <div class="form-input">
                                    {!! Form::password('password-repeat', ['placeholder'=> 'Repeat New Password ', 'id' => 'password-repeat' ], null) !!}
                                </div>
                                <div class="form-actions">
                                    <button type="button" onclick="checkPasswords()"
                                            class="mg-primary-button handButton">{{ trans('txt.reset_pass') }}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@section('javascripts')
    <script>
        ;(function ($) {
            function checkPasswords() {
                if ($('#password').val() != $('#password-repeat').val()) {
                    var input = document.getElementById('password');
                    var input_rep = document.getElementById('password-repeat');
                    input_rep.value = '';
                    input.value = '';
                    input.focus();
                    input.select();
                    Swal.fire('{{ trans('txt.passwords_not_match') }}');
                    return;
                } else if ($('#password').val().length < 8) {
                    var input = document.getElementById('password');
                    var input_rep = document.getElementById('password-repeat');
                    input_rep.value = '';
                    input.value = '';
                    input.focus();
                    input.select();
                    Swal.fire('{{ trans('txt.minimum_password_length') }}');
                } else {
                    $('#password_form').submit();
                }
            }

            $('.login_button').click(function () {
                $('.switch_login').trigger('click');
                $('.create_password_form').hide();
            })
        })(jQuery);
    </script>
@endsection
