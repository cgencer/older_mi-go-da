@php $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user(); @endphp
<!-- Side Nav START -->
<div class="side-nav expand-lg">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown {{(\Request::route()->getName() == 'admin.dashboard') ? 'open' : '' }}">
                <a class="{{(\Request::route()->getName() == 'admin.dashboard') ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                                <span class="icon-holder">
									<i class="mdi mdi-gauge"></i>
								</span> <span class="title">Dashboard</span> </a>
            </li>
            <li class="nav-item dropdown {{(\Request::route()->getName() == 'admin.calendar') ? 'open' : '' }}">
                <a class="{{(\Request::route()->getName() == 'admin.calendar') ? 'active' : '' }}" href="{{route('admin.calendar')}}">
                                <span class="icon-holder">
									<i class="mdi mdi-calendar-multiple"></i>
								</span> <span class="title">Calendar</span> </a>
            </li>
            <li class="side-nav-header">
                <span>Hotel Management</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.hotels') ? 'active' : '' }}">
                <a href="{{route('admin.hotels.index')}}">
                    <span class="icon-holder"><i class="mdi mdi-hotel"></i></span><span class="title">Hotels</span> </a>
            </li>
            <li class="nav-item dropdown {{(\Illuminate\Support\Str::startsWith(\Request::route()->getName(), 'admin.feature_categories') || \Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.feature_groups') || \Illuminate\Support\Str::startsWith(Request::route()->getName(), 'admin.features')) ? 'open' : '' }}">
                <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
									<i class="mdi mdi-microsoft"></i>
								</span> <span class="title">Features</span> <span class="arrow">
									<i class="mdi mdi-chevron-right"></i>
								</span> </a>
                <ul class="dropdown-menu">
                    <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.feature_categories') ? 'active' : '' }}">
                        <a href="{{route('admin.feature_categories.index')}}">Feature Categories</a>
                    </li>
                    <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.feature_groups') ? 'active' : '' }}">
                        <a href="{{route('admin.feature_groups.index')}}">Feature Groups</a>
                    </li>
                    <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.features') ? 'active' : '' }}">
                        <a href="{{route('admin.features.index')}}">Features</a>
                    </li>
                </ul>
            </li>
            <li class="side-nav-header">
                <span>User Management</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.users') ? 'active' : '' }}">
                <a href="{{route('admin.users.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-account-star"></i></span><span class="title">Hotel Users</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.customers') ? 'active' : '' }}">
                <a href="{{route('admin.customers.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-ticket-account"></i></span><span class="title">Customers</span>
                </a>
            </li>
            @hasrole('SuperAdmin', 'admin')
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.admin_users') ? 'active' : '' }}">
                <a href="{{route('admin.admin_users.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-account-key"></i></span><span class="title">Admins</span>
                </a>
            </li>
            @endhasrole
            <li class="side-nav-header">
                <span>Coupon Management</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.coupon-rules') ? 'active' : '' }}">
                <a href="{{route('admin.coupon-rules.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-ticket-confirmation"></i></span><span class="title">Coupon Rules</span>
                </a>
            </li>
            <li class="side-nav-header">
                <span>Finance Management</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.reservations') ? 'active' : '' }}">
                <a href="{{route('admin.reservations.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-ticket"></i></span><span class="title">Reservations</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.payments') ? 'active' : '' }}">
                <a href="{{route('admin.payments.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-cash-usd"></i></span><span class="title">Payments</span>
                </a>
            </li>
            <li class="side-nav-header">
                <span>Pages</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.contact') ? 'active' : '' }}">
                <a href="{{route('admin.contact.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-email-variant"></i></span><span class="title">Contact Form</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.pages') ? 'active' : '' }}">
                <a href="{{route('admin.pages.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-file-document-box"></i></span><span class="title">Pages</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.faq') ? 'active' : '' }}">
                <a href="{{route('admin.faq.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-format-line-weight"></i></span><span class="title">FAQ</span>
                </a>
            </li>
            <li class="side-nav-header">
                <span>Documents Management</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.documents') ? 'active' : '' }}">
                <a href="{{route('admin.documents.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-briefcase"></i></span><span class="title">Documents</span>
                </a>
            </li>
            <li class="side-nav-header">
                <span>Others</span>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.newsletter_subscriptions') ? 'active' : '' }}">
                <a href="{{route('admin.newsletter_subscriptions.index')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-contact-mail"></i></span><span class="title">Newsletter Subscriptions</span>
                </a>
            </li>
            <li class="{{\Illuminate\Support\Str::startsWith(\Request::route()->getName(),'admin.settings') ? 'active' : '' }}">
                <a href="{{route('admin.settings')}}" class="">
                    <span class="icon-holder"><i class="mdi mdi-settings"></i></span><span class="title">Settings</span>
                </a>
            </li>
            <li class="nav-item dropdown {{(\Request::route()->getName() == 'admin.file-manager') ? 'open' : '' }}">
                <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
									<i class="mdi mdi-vector-arrange-above"></i>
								</span> <span class="title">File Manager</span> <span class="arrow">
									<i class="mdi mdi-chevron-right"></i>
								</span> </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('admin.file-manager')}}?type=image" class="{{(\Request::route()->getName() == 'admin.file-manager') ? 'active' : '' }}">Images</a>
                    </li>
                    <li>
                        <a href="{{route('admin.file-manager')}}?type=file" class="{{(\Request::route()->getName() == 'admin.file-manager') ? 'active' : '' }}">Files</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div><!-- Side Nav END -->
