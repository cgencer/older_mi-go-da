@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
    $admin = Auth::guard('admin')->user();
    $profile_image = $admin->getMedia('profile_image')->first();
@endphp
<!-- Header START -->
<div class="header navbar">
    <div class="header-container">
        <div class="nav-logo">
            <a href="{{route('admin.dashboard')}}">
                <div class="logo logo-colored" style="background-image: url('{{asset('admin/assets/images/logo/logo.png')}}')"></div>
                <div class="logo logo-white" style="background-image: url('{{asset('admin/assets/images/logo/logo.png')}}')"></div>
            </a>
        </div>
        <ul class="nav-left">
            <li>
                <a class="sidenav-fold-toggler" href="javascript:void(0);"> <i class="mdi mdi-menu"></i> </a>
                <a class="sidenav-expand-toggler" href="javascript:void(0);"> <i class="mdi mdi-menu"></i> </a>
            </li>
        </ul>
        <ul class="nav-right">
            {{-- <li class="dropdown dropdown-animated scale-left">
                <a href="" class="dropdown-toggle" data-toggle="dropdown"> <i class="mdi mdi-apps"></i> </a>
                <ul class="dropdown-menu dropdown-header-menu dropdown-grid col-3 dropdown-lg">
                    <li>
                        <a href="{{route('admin.newsletter_subscriptions.index')}}">
                            <div class="text-center">
                                <i class="mdi mdi-contact-mail font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Newsletters</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.index')}}">
                            <div class="text-center">
                                <i class="mdi mdi-account-star font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Users</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.dashboard')}}">
                            <div class="text-center">
                                <i class="mdi mdi mdi-gauge font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Dashboard</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.customers.index')}}">
                            <div class="text-center">
                                <i class="mdi mdi-ticket-account font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Customers</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.reservations.index')}}">
                            <div class="text-center">
                                <i class="mdi mdi-ticket font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Reservations</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hotels.index')}}">
                            <div class="text-center">
                                <i class="mdi mdi-hotel font-size-30 icon-gradient-success"></i>
                                <p class="m-b-0">Hotels</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="notifications dropdown dropdown-animated scale-left">
                <span class="counter">1</span> <a href="" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="mdi mdi-bell-ring-outline"></i> </a>
                <ul class="dropdown-menu dropdown-lg p-v-0">
                    <li class="p-v-15 p-h-20 border bottom text-dark">
                        <h5 class="m-b-0">
                            <i class="mdi mdi-bell-ring-outline p-r-10"></i> <span>Notifications</span>
                        </h5>
                    </li>
                    <li>
                        <ul class="list-media overflow-y-auto relative scrollable" style="max-height: 300px">
                            <li class="list-item border bottom">
                                <a href="javascript:void(0);" class="media-hover p-15">
                                    <div class="media-img">
                                        <div class="icon-avatar bg-primary">
                                            <i class="ti-user"></i>
                                        </div>
                                    </div>
                                    <div class="info">
                                                    <span class="title">
                                                        New user is registered! (Example Data.)
                                                    </span> <span class="sub-title">8 min ago</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
            <li class="user-profile dropdown dropdown-animated scale-left">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="profile-img img-fluid" src="{{$profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')}}" alt="">
                </a>
                <ul class="dropdown-menu dropdown-md p-v-0">
                    <li>
                        <ul class="list-media">
                            <li class="list-item p-15">
                                <div class="media-img">
                                    <img src="{{$profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')}}" alt="">
                                </div>
                                <div class="info header-user-info">
                                    <span class="title text-semibold">{{$admin->firstname.' '.$admin->lastname}}</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{route('admin.auth.profile.edit')}}"> <i class="ti-user p-r-10"></i>
                            <span>Profile</span> </a>
                    </li>
                    <li>
                        <a href="{{route('admin.auth.logout')}}"> <i class="ti-power-off p-r-10"></i>
                            <span>Logout</span> </a>
                    </li>
                </ul>
            </li>
            <li class="m-r-10">
                <div class="dropdown dropdown-animated header-lang-select">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span>{{ trans('txt.trans_'.$app_locale) }}</span>
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                        @foreach (\Illuminate\Support\Facades\Config::get('languages') as $lang => $language)
                            @if ($lang !== $app_locale)
                                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">{{ trans('txt.trans_'.$lang) }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div><!-- Header END -->
