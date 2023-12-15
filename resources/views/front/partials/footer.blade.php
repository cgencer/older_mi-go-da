@php

    $currentPage = \App\Helpers::getCurrentPage();
    $otherCurrentPage = \App\Helpers::getCurrentPage(false);

    $logged = \Illuminate\Support\Facades\Auth::guard('customer')->check();
   if ($logged) {
       $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
   }
@endphp

{{-- @if (!\Illuminate\Support\Facades\Auth::guard('customer')->user())
    @include('cookieConsent::index')
@endif --}}
<div class="modal fade" id="termsAndConditionsModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="termsAndConditionsModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ trans("txt.title_terms_and_conditions") }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! trans('txt.footer_terms_modal_desc') !!}
            </div>
        </div>
    </div>
</div>
@if($logged)
    <div class="modal fade" id="addCouponsModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="addCouponsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>{{ trans("txt.popup_enter_coupon_code_title") }}</h3>
                    <div class="coupons_added"></div>
                    <div class="coupons_notice" style="display:none;">{{ trans("txt.popup_coupon_additional") }}</div>
                    <div class="coupon_fields">
                        @for ($i = 0; $i < 12 ; $i++)
                            {!! Form::text('coupon_code[]', '', ['class' => 'coupon_field','maxlength'=>1]) !!}
                        @endfor
                        <span class="validate_coupon invalid_coupon"><i id="validation-icons-valid"
                                                                        class="fa fa-check"></i>
                        <i id="validation-icons-invalid" style="display: none;color:red"
                           class="fa fa-times "></i></span>
                    </div>
                    <div class="coupons_error">{{ trans("txt.popup_coupon_invalid") }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mg-primary-button__disabled handButton addCouponsModalButton"
                            disabled="disabled">{{ trans("txt.popup_accept") }}</button>
                </div>
            </div>
        </div>
    </div>

@endif
<script>
    var urlAddCoupon = '{{ route('coupon.add-coupon.ajax') }}';
    var urlGetCoupons = '{{ route('coupon.get-coupons.ajax') }}';
    var urlChkCoupons = '{{ route('coupon.check-coupons.ajax') }}';
</script>
<footer>
    <div class="footer-top">
        <div class="mg-section mg-group">
            <div class="footer-navigation_wrapper centered">
                <ul class="footer-navigation hide-desktop-flex" >
                    <li>
                        <a {!! $currentPage == 'f.about' ?  'class="active"':'' !!} href="{{ route('f.about') }}">{{ trans("txt.link_about") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.how-it-works' ? 'class="active"':'' !!} href="{{ route('f.how-it-works') }}">{{ trans("txt.link_how_it_works") }}</a>
                    </li>
                    <li>
                        <a {!! ($currentPage == 'f.destinations' || $currentPage == 'f.detail') ? 'class="active"':'' !!} href="{{ route('f.destinations') }}">{{ trans("txt.link_destinations") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.faq' ?  'class="active"':'' !!} href="{{ route('f.faq') }}">{{ trans("txt.link_faq") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.contact' ?  'class="active"':'' !!} href="{{ route('f.contact') }}">{{ trans("txt.link_contact") }}</a>
                    </li>

                    @if(\App\Helpers::getPageData(settings()->get('terms')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('terms'))->slug ? 'class="active"' :'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('terms'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('terms'))->title }}</a>
                        </li>
                    @endif

                    <li>
                        <a {!! $currentPage == 'f.data-privacy' ?  'class="active"':'' !!} href="{{ route('f.data-privacy') }}">{{ trans("txt.data_privacy_title") }}</a>
                    </li>

                    @if(\App\Helpers::getPageData(settings()->get('cookie_policy')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('cookie_policy'))->slug ?  'class="active"':'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('cookie_policy'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('cookie_policy'))->title }}</a>
                        </li>
                    @endif


                    @if(\App\Helpers::getPageData(settings()->get('imprint')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('imprint'))->slug ?  'class="active"':'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('imprint'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('imprint'))->title }}</a>
                        </li>
                    @endif

                </ul>
                <ul class="footer-navigation hide-mobile-flex col-6" >
                    <li>
                        <a {!! $currentPage == 'f.about' ?  'class="active"':'' !!} href="{{ route('f.about') }}">{{ trans("txt.link_about") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.how-it-works' ? 'class="active"':'' !!} href="{{ route('f.how-it-works') }}">{{ trans("txt.link_how_it_works") }}</a>
                    </li>
                    <li>
                        <a {!! ($currentPage == 'f.destinations' || $currentPage == 'f.detail') ? 'class="active"':'' !!} href="{{ route('f.destinations') }}">{{ trans("txt.link_destinations") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.faq' ?  'class="active"':'' !!} href="{{ route('f.faq') }}">{{ trans("txt.link_faq") }}</a>
                    </li>
                    <li>
                        <a {!! $currentPage == 'f.contact' ?  'class="active"':'' !!} href="{{ route('f.contact') }}">{{ trans("txt.link_contact") }}</a>
                    </li>

                </ul>
                <ul class="footer-navigation hide-mobile-flex col-6" >

                    @if(\App\Helpers::getPageData(settings()->get('terms')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('terms'))->slug ? 'class="active"' :'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('terms'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('terms'))->title }}</a>
                        </li>
                    @endif

                    <li>
                        <a {!! $currentPage == 'f.data-privacy' ?  'class="active"':'' !!} href="{{ route('f.data-privacy') }}">{{ trans("txt.data_privacy_title") }}</a>
                    </li>

                    @if(\App\Helpers::getPageData(settings()->get('cookie_policy')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('cookie_policy'))->slug ?  'class="active"':'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('cookie_policy'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('cookie_policy'))->title }}</a>
                        </li>
                    @endif


                    @if(\App\Helpers::getPageData(settings()->get('imprint')))
                        <li>
                            <a {!! $otherCurrentPage == \App\Helpers::getPageData(settings()->get('imprint'))->slug ?  'class="active"':'' !!} href="{{ url(\App\Helpers::getPageData(settings()->get('imprint'))->slug) }}">{{ \App\Helpers::getPageData(settings()->get('imprint'))->title }}</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <a href="#top" title="{{config('app.name')}}" class="footer-logo"><img
                src="{{ asset('front/assets/images/logo-footer.png') }}" alt="Migoda"/></a>
        <br/> <br/> &copy; 2018 {{config('app.name')}}. {{ trans('txt.all_rights_reserved') }}

    </div>
</footer>
