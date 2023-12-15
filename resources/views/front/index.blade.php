@extends('front.layouts.master')@php
    $logged = \Illuminate\Support\Facades\Auth::guard('customer')->check();
@endphp

@section('title') {{trans('txt.page_title_index')}} @parent @endsection
@section('body')

    <div class="coupon-area">

        <div class="forms">

            <img src="{{ asset('front/assets/images/X_icon.png') }}" id="coupon_close">

            <div class="use-coupon-list">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAAAAXNSR0IB2cksfwAABNZJREFUeJylmF1sVEUUx8+Z3XZNli2PxJYE0ChF0lUq2NCGlRJomtKPB2uMYsSWaktfDFFYE4sppTE2vpgopVjEj/hoNEBt+tCIxoSWGDSC2D6BGkhawAeUfuzXHM/ee3f33r0zu7dhHnbux9w5vznnP2dmFmEF5d/y1yv9BI2ScDsQbEYQa4lgNQIC1/eQ8CYBXOOmU9xmouyfj2e99o1eGi1WdLVz014iqjc+ITQ/JbMLhgB01GjVdIFQDIfufPT1A4EsrOuoBglDPNLdTmPCqNUw/ItcSzDr9HvCSb6KBu+e+GXFIMvr9x+UkoaBjTqNCYUHMlAaT6Xv+J1E6A3dPnHSM8jSun3HCbDP3mnGiNv9Ts+YtQWP7rBJosHQnZNHi4IsbXiJIaBPHXOFMY2nVIMwCqlhHCDLj73QzbEd0Xcu1CNfMXT6OfUEb4+ccoHEKp+vkim4oo95njbIJkxTkGqNoMi9B8h7L8Or5j+56gBZfPy588zd7G3kek/pw+SEtOqx4NyplizI8qa2Ju7sO56qVmc597rd7YYsHD5Vf7YUQLiXYcYNkNgTrWf5YWvBkUm74Lx7qKinJJ4Lzo224cLG1nK/X97Kb6zUSCZJyXxB6qd25l4Rllw7IStwqaqpg/nPZB/KYhopEiZZKAOrkiG3ItGJy081jqKErmynpHKj2rhy5GQZLQtCyVAP0MzfkPjwG41nzHskOI2xJxum+bJG7eYCs0OifuRlISj96iiITeuBbt2FWOSNAnkG0/G+hPEte+b44zXFNZLXCQnXyIzvy1ZByZf9BgT8twjxfQMg//jLHeaM5408g/MYq96V5M59TiOYM6AMgwY2FIKSL44xxAYT4uV+hvizqKD5SQrjW+uT3IlPGRa78MofBt/AIUh9MMpxv+EOX4g98fkgYKUF8cq7QBaETri2qc0g2yIcGrGm2CqLLQ3gH3iTjSxA4kAU5Mx1J8Rn7zHEIybE/j4brGYqS4e9eUzU7Jhm4dUUmnIZSN+xwyBa9rCx+5DoiprG0hCfvm9C3GfIV99hyBuFp3h2rcp6nsX6TN0oJ6kubezz0r4J02DAJA8NgO9wN+DGR02IzrdNCNJrSakREqcxXlvbwXnkjHbqkntkvv4jJkymMETywBGQs9fNdml4NNK3N41I7ESqqytPSk7xXsht7339URDNDSbEa28ZmlEZcWdUt0ZSkKowVrFEbc1ZbtTqQd2O9+LFdqAfLnLSmrPygnuKuzNqnkbIdy4w+22bAZKs29pEvA1QLmSysGeK7lekAsLen6S9D82MjWc3Rskd285z42bXyMmDsUKQpPcMtxsL/D6W2xilSyzydJWP4IpXjbhHnq8ND0IlEQ5cHXduFdMlFanu5kcj+rWmQHrXaEQbFhI9pb9NuDfPmZKIbDmO6TONNgzeNZJbr3I7O+v5YODXSf1xwg4jEPq8rMLFw2dtGaxjKE+KwcDl74sfsLJhejZ8EPgArd2DSmvkoNOIOxx81Vv684/ej5yZEt8VrvaTGJIEu7PzPnuOyR0r3bPDBTVJKKKl0z+t/BBuL8md4XauetkD9V72oLYwXcCUGPZfuvhgf0vkF9pZVSmFr5FStJ09s5mNruUuVlsjv8d7z5tE4hqfbadKJE3g1GXPf9T8DzO63irqbKpxAAAAAElFTkSuQmCC">
            </div>

            <div class="coupon-title">{{ trans("txt.popup_enter_coupon_code_title") }}</div>
            <div class="coupon_fields">
                @for ($i = 0; $i < 12 ; $i++)
                    {!! Form::text('coupon_code[]', '', ['class' => 'coupon_field','maxlength'=>1, 'autocomplete' => 'off']) !!}
                @endfor
                    <img src="{{ asset('front/assets/images/pasive_tick.png') }}" id="coupon_status">
            </div>
            <div class="coupons_added"></div>

            <div class="coupons_error"></div>
            <script>
                var error_msg = '{{ trans("txt.popup_coupon_invalid") }}';
                var empty_msg = '{{ trans("txt.popup_coupon_empty") }}';
                var warning_img = '{{ asset('front/assets/images/uyari.png') }}';
                var pasive_tick_img = '{{ asset('front/assets/images/pasive_tick.png') }}';
                var active_tick_img = '{{ asset('front/assets/images/active_tick.png') }}';
            </script>
            <button class="save-coupon buttonn">{{ trans("txt.popup_accept") }}</button>

            <div class="buttons">
                <button class="add-more-coupons buttonn">{{trans('txt.add_more_coupons')}} <span class="validate_coupon invalid_coupon"><i class="fa fa-plus"></i></span></button>
                <button class="save-coupon2 buttonn buttonn2" onclick="window.location='{{ route("f.destinations") }}'">{{trans('txt.start_your_journey')}}</button>
            </div>
        </div>
    </div>

    <div class="middle-banner_wrapper">
        <div class="slide show" style="background-image: url('{{ asset('front/assets/images/pages/home-banner-1.jpg') }}');"></div>
        <div class="slide" style="background-image: url('{{ asset('front/assets/images/pages/home-banner-2.jpg') }}');"></div>
        <div class="slide" style="background-image: url('{{ asset('front/assets/images/pages/home-banner-3.jpg') }}');"></div>
        <div class="slide" style="background-image: url('{{ asset('front/assets/images/pages/home-banner-4.jpg') }}');"></div>
        @if($logged)
            <div class="mg-section mg-group middle-banner">
                <div class="mg-col mg-span_2_of_12 empty-mg-col">
                    &nbsp;
                </div>
                <div class="mg-col mg-span_8_of_12 search-block_wrapper">
                    <h1>{{ trans('txt.ind_create_your_memories_now') }}</h1>
                    <div class="search-input_wrapper">
                        <form action="{{ route('f.destinations') }}" method="get">
                            <div class="input-text">
                            <span class="location">
                                <img src="{{ asset('front/assets/images/svg/location.svg') }}"/>
                            </span>
                                <input type="text" name="q" placeholder="{{ trans('txt.search_destination_input') }}"/>
                                <button class="search mg-primary-button mg-primary-button_intext">
                                    <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mg-col mg-span_2_of_12 empty-mg-col">
                    &nbsp;
                </div>
            </div>
        @else
            <div class="mg-section mg-group middle-banner">
                <div class="mg-col mg-span_12_of_12 redeem-block_wrapper">
                    <h1>{{ trans('txt.ind_create_your_memories_now') }}</h1>
                    <div class="redeem-input_wrapper">
                        <button class="mg-primary-button switch_signup-login handButton">{{ trans('txt.ind_redeem_your_coupon') }}</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="middle-hiw_wrapper middle-wrapper">
        <h2>{{ trans('txt.ind_how_it_works_header') }}</h2>
        <p class="middle-hiw_desc">
            {!! trans('txt.ind_how_it_works_text') !!}<br/>
        </p>
        <div class="mg-section mg-group middle-hiw">
            <div class="mg-col mg-span_4_of_12">
                <span class="globe">
                    <img src="{{ asset('front/assets/images/svg/globe.svg') }}"/>
                </span>
                <h3>{{ trans('txt.ind_discover_destinations_header') }}</h3>
                <p>{!! trans('txt.ind_discover_destinations_text') !!}</p>
            </div>
            <div class="mg-col mg-span_4_of_12">
                <span class="ticket">
                    <img src="{{ asset('front/assets/images/svg/ticket.svg') }}"/>
                </span>
                <h3>{{ trans('txt.ind_coupon_code_header') }}</h3>
                <p>{!! trans('txt.ind_coupon_code_text') !!}</p>
            </div>
            <div class="mg-col mg-span_4_of_12">
                <span class="calendar">
                    <img src="{{ asset('front/assets/images/svg/calendar.svg') }}"/>
                </span>
                <h3>{{ trans('txt.ind_send_booking_request_header') }}</h3>
                <p>{!! trans('txt.ind_send_booking_request_text') !!}</p>
            </div>
        </div>
    </div>

    <div class="middle-categories_wrapper middle-wrapper">
        <h2>{{ trans('txt.ind_hotel_categories_header') }}</h2>
        @if (isset($homeCategories))
            @foreach($homeCategories as $key => $categories)
                <div class="mg-section mg-group middle-categories @if ($key != 0) middle-wrapper @endif">
                    @foreach($categories as $category)
                        <div class="mg-col mg-span_3_of_12">
                            <div class="category-image">
                                <img src="{{ $category->getCategoryBgWebPath() }}">
                            </div>
                            <a class="category-content" href="{{ route('f.category',['slug'=>$category->slug]) }}">
                                <span><img src="{{ $category->getCategoryWhiteIconWebPath() }}"/></span>
                                <h3>{{  $category->name }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
@endsection
