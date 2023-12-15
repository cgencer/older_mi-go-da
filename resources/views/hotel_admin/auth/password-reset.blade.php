@extends('hotel_admin.layouts.account')
@section('title'){{ trans('txt.create_new_password_btn') }} | @parent @endsection
@section('styles')
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
                                    <p class="m-t-15 font-size-13">{{trans('txt.hotel_admin_password_reset_desc')}}</p>
                                </div>
                                <form class="mgd-form" method="post"
                                      action="{{route('hotel_admin.create_new_password.submit')}}">
                                    @csrf
                                    <input type="hidden" value="{{ $resetId ?? '' }}" name="resetId">
                                    <input type="hidden" value="{{ $customer ?? '' }}" name="customer">
                                    @include('front.partials.alert')
                                    <div class="form-row margin-top--20">
                                        <div class="col">
                                            <input type="password" name="password"
                                                   class="mgd-form__input mgd-placeholder--gray2"
                                                   placeholder="{{ trans('txt.field_password') }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-row margin-top--20">
                                        <div class="col">
                                            <input type="password" name="password-repeat"
                                                   class="mgd-form__input mgd-placeholder--gray2"
                                                   placeholder="{{ trans('txt.field_repeat_password') }}"
                                                   required>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="mgd-btn mgd-btn--default mgd-btn--medium mgd-btn--shadow margin-top--45 text-capitalize">{{trans('txt.create_new_password_btn')}}</button>
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
