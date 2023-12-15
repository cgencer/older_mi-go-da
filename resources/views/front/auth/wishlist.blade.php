@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_wishlist')}} @parent @endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <h1>{{ trans('txt.wishlist_title') }}</h1>
                @if ($hotels)
                    @foreach($hotels as $hotel)
                        @include('front.partials.hotelcard',['hotel'=>$hotel,'user'=>$user])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
