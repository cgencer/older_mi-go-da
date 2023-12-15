@php

    $hotelUser = \Illuminate\Support\Facades\Auth::guard('user')->user();

    $hotel = \App\Models\Hotels::where('user_id', $hotelUser->id)->first();


    $hotelId = $hotel->id;
    $hotelSlug = $hotel->slug;

@endphp
<!-- Side Nav START -->
<div class="side-nav expand-lg">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown {{(\Request::route()->getName() == 'admin.dashboard') ? 'open' : '' }}">
                <a class="{{(\Request::route()->getName() == 'admin.dashboard') ? 'active' : '' }}"
                   href="{{route('hotel_admin.dashboard')}}">
                                <span class="icon-holder">
									<i class="mdi mdi-gauge"></i>
								</span> <span class="title">{{ trans('txt.admin_menu_dashboard') }}</span> </a>
            </li>
            <li class="nav-item dropdown {{(\Request::route()->getName() == 'admin.calendar') ? 'open' : '' }}">
                <a class="{{(\Request::route()->getName() == 'admin.calendar') ? 'active' : '' }}"
                   href="{{route('hotel_admin.calendar')}}">
                                <span class="icon-holder">
									<i class="mdi mdi-calendar-multiple"></i>
								</span> <span class="title">{{ trans('txt.admin_menu_manage_calendar') }}</span> </a>
            </li>
            <li>
                <a href="{{route('hotel_admin.hotels.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-hotel"></i></span><span class="title">{{ trans('txt.admin_menu_hotel_info') }}</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'hotel_admin.reservations') ? 'active' : '' }}">
                <a href="{{route('hotel_admin.reservations.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-ticket"></i></span><span
                        class="title">{{ trans('txt.admin_menu_reservations') }}</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'hotel_admin.payments') ? 'active' : '' }}">
                <a href="{{route('hotel_admin.payments.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-cash-usd"></i></span><span class="title">{{ trans('txt.admin_menu_payments') }}</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'hotel_admin.documents') ? 'active' : '' }}">
                <a href="{{route('hotel_admin.documents.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-briefcase"></i></span><span
                        class="title">{{ trans('txt.admin_menu_documents') }}</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'hotel_admin.faq') ? 'active' : '' }}">
                <a href="{{route('hotel_admin.faq.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-format-line-weight"></i></span><span
                        class="title">{{ trans('txt.admin_menu_faq') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('f.detail-preview', ['id' => $hotelId, 'slug' => $hotelSlug]) }}" target="_blank">
                    {{-- <img src="{{ asset('admin/assets/images/logo/banner.png') }}" alt=""> --}}
                    <div class="preview-banner">
                        <div class="border"></div>
                        <div class="content">
                            <h2>{!! trans('txt.sidebar-preview-title') !!}</h2>
                            <p class="d-block">{!! trans('txt.sidebar-preview-desc') !!}</p>
                            <img src="{{ asset('front/assets/images/arrow-gradient.png') }}" width="36" class="float-right d-block mt-3" alt="">
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div><!-- Side Nav END -->

