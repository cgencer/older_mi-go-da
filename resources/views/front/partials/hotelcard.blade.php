@php
    $wishlistClass = 'mg-secondary-button';
@endphp
@if ($user->hasFavorited($hotel))
    @php
        $wishlistClass = 'mg-primary-button';
    @endphp
@endif
<div id="listing-wrapper" class="listing-item clearfix">
    <div class="listing-item_left">
        <a href="{{ route('f.detail', ['slug' => $hotel->slug,'id'=>$hotel->id]) }} ">
            <img src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/200x170 @endif" class="img-desktop" width="200" height="170"/>
            <img src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif" class="img-mobile"/>
        </a>
    </div>
    <div class="listing-item_middle">
        {!! $hotel->getStarHtml() !!}
        <h2>
            <a href="{{ route('f.detail', ['slug' => $hotel->slug,'id'=>$hotel->id]) }} ">{{ $hotel->name }}</a>
        </h2>
        <h3>{{ $hotel->getCityName() }} {{ $hotel->getCountryName() }}</h3>
        <ul class="listing-icons">
            @foreach($hotel->getPropertyTypes() as $property_type)
                @if (!is_null($property_type[0]->getCategoryRedIconWebPath()))
                    <li>
                        <img src="{{ $property_type[0]->getCategoryRedIconWebPath() }}" title="{{ str_replace(' Hotel','',$property_type[0]->name) }}"/>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="listing-item_right">
        <div class="right-top-wrapper">
            <div class="category">
                @php
                    $boardFoodExp = explode(' (', $hotel->getBoardFoodAllowance());
                @endphp
                @if (count($boardFoodExp) > 0)
                    {{$boardFoodExp[0]}}
                @else
                    {{$hotel->getBoardFoodAllowance()}}
                @endif
            </div>
            <div class="price">{{ \App\Helpers::localizedCurrency($hotel->price) }}</div>
        </div>
        <div class="right-middle-wrapper">
            @if (count($boardFoodExp) > 1)
                ({{ $boardFoodExp[1] }}
                <br/>
            @else
                ({{ $boardFoodExp[0] }})
                <br/>
            @endif
            {{ trans('txt.per_person_per_day') }}
        </div>
        <div class="right-bottom-wrapper">
            <a href="{{ route('f.add-to-wishlist', ['id' => $hotel->id ]) }}"
                class="add-to-wishlist  mg-primary-button">
                 @if ($user->hasFavorited($hotel))
                     <img class="wish_image" src="{{ asset('front/assets/images/svg/heart-white.png') }}"/>
                     <img class="wish_image_empty" style="display: none" src="{{ asset('front/assets/images/svg/heart-white-empty.png') }}"/>
                 @else
                    <img class="wish_image_empty" src="{{ asset('front/assets/images/svg/heart-white-empty.png') }}"/>
                    <img class="wish_image" style="display: none" src="{{ asset('front/assets/images/svg/heart-white.png') }}"/>
                 @endif
                 <i style="display: none" class="fa fa-spinner fa-spin wish-spinner"></i>
             </a>
            <a href="{{ route('f.detail', ['slug' => $hotel->slug,'id'=>$hotel->id]) }} " class="mg-tertiary-button">{{ trans('txt.search_booking_button') }}
                <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/> </a>
        </div>
    </div>
</div>
