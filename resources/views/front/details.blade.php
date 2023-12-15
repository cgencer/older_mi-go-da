@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title') {{ $hotel->name }} @parent
@endsection

@section('body_class') page-detail-body @endsection

@section('body')
    <div class="page-detail">
        <div class="page-detail-header"
             style="background: url( @if($hotel->getImageUrl('imddetail')){{ $hotel->getImageUrl('imddetail') }}@else{{ asset('front/assets/images/pages/hotel-top-banner.jpg') }}@endif ) no-repeat center center transparent; background-size: cover;"></div>
        <div class="page-detail-inner mg-section mg-group">
            <div class="page-detail-inner-top clearfix">
                @if ($hotel->getIsVerified())
                    <div class="migoda-verified">
                        <div class="verified-logo">
                            <img src="{{ asset('front/assets/images/svg/migoda-verified.svg') }}"
                                 alt="Migoda verified"/>
                        </div>
                        <div class="verified-text"><h3>{{ trans('txt.migoda_verified') }}</h3>
                            <p>{{ trans('txt.migoda_verified_text') }}</p>
                        </div>
                    </div>
                @endif
                <div class="view-photos">
                    <a href="#" id="view-photos">{{ trans('txt.det_view_photos') }}</a>
                    <div style="display: none">
                        <div id="gallery-image-container">
                            @if($hotel->getGalleryImagesUrl())
                                @foreach($hotel->getGalleryImagesUrl() as $image)
                                    <img src="{{ $image['path'] }}"/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-detail-block">
                <div class="page-detail-left">
                    <div class="detail-header">
                        <div class="detail-icons">
                            @php
                                $wishlistClass = 'style="display:none"';
                            @endphp
                            @if ($user->hasFavorited($hotel))
                                @php
                                     $wishlistClass = 'style="display:block"';
                                @endphp
                            @endif
                            <a href="{{ route('f.add-to-wishlist', ['id' => $hotel->id ]) }}"
                               class="add-to-wishlist  mg-primary-button">
                                {{ trans('txt.whishlist_button') }}
                                @if ($user->hasFavorited($hotel))
                                <img class="wish_image" src="{{ asset('front/assets/images/svg/heart-white.png') }}"/>
                                <img class="wish_image_empty" style="display: none" src="{{ asset('front/assets/images/svg/heart-white-empty.png') }}"/>
                                @else
                                <img class="wish_image_empty" src="{{ asset('front/assets/images/svg/heart-white-empty.png') }}"/>
                                <img class="wish_image" style="display: none" src="{{ asset('front/assets/images/svg/heart-white.png') }}"/>
                                @endif
                                <i style="display: none" class="fa fa-spinner fa-spin wish-spinner"></i>
                            </a>
                        </div>
                        <h1>
                            {{ $hotel->name }}
                            {!! $hotel->getStarHtml() !!}
                        </h1>
                        <h3>{{ $hotel->getCityName() }} {{ $hotel->getCountryName() }}</h3>
                    </div>
                    <div class="detail-note desktop-only">
                        <p>
                            {{ trans('txt.det_notice_line1') }}<br/>
                            {{ trans('txt.det_notice_line2') }}
                        </p>
                    </div>
                    <div class="detail-information desktop-only">
                        <h4>{{trans('txt.det_hotel_information_title') }}</h4>
                        <div class="detail-text cropped">
                            {!! $hotel->description !!}
                        </div>
                        <a href="#" class="detail-read-more">{{ trans('txt.read_more_button') }}
                            <i class="fa fa-caret-down"></i></a>
                    </div>
                    @if($hotel->getPropertyCheckinCheckout())
                        <div class="detail-information property-information desktop-only">
                            <div class="detail-text checkin-checkout">
                                {!! $hotel->getPropertyCheckinCheckout() !!}
                            </div>
                        </div>
                    @endif
                    @if($hotel->propertyDescription != '')
                        <div class="detail-information property-information desktop-only">
                            <h4>{{ trans('txt.det_meal_package_title') }}</h4>
                            <div class="detail-text cropped">
                                {!! $hotel->propertyDescription !!}
                            </div>
                            <a href="#" class="detail-read-more">{{ trans('txt.read_more_button') }}
                                <i class="fa fa-caret-down"></i></a>
                        </div>
                    @endif
                </div>
                @php
                    $now = \Carbon\Carbon::now();
                    $tomorrow = \Carbon\Carbon::tomorrow();
                @endphp
                <div class="page-detail-calendar">
                    {!! Form::open(['route'=> 'f.book','method' => 'get']) !!}
                    @csrf
                    {!! Form::hidden('hotel', $hotel->uuid, ['id' => 'uuid']) !!}
                    <div class="calendar-wrapper">
                        <div class="dates-wrapper-outer">
                            <div class="dates-wrapper">
                                <div class="date date-end">
                                    <h5>{{ trans('txt.det_checkin_title') }}</h5>
                                    <h4><a href="#" class="checkin">{{ $now->addDays()->format('M d, Y') }}</a></h4>
                                </div>
                                <div class="date date-start">
                                    <h5>{{ trans('txt.det_checkout_title') }}</h5>
                                    <h4>
                                        <a href="#" class="checkout">{{ $tomorrow->addDays()->format('M d, Y') }}</a>
                                    </h4>
                                </div>
                                
                            </div>
                            <div class="datepicker-hider">
                                <input type="text" id="date-picker" value="" data-language="{{$app_locale}}"/>
                            </div>
                        </div>
                        <div id="dates-container">
                            <input type="hidden" name="date_checkin" id="date_checkin" class="actual_range"
                                   value="{{ $now->format('Y-m-d') }}"/>
                            <input type="hidden" name="date_checkout" id="date_checkout" class="actual_range"
                                   value="{{ $tomorrow->format('Y-m-d') }}"/>
                        </div>
                        <div class="clearfix select-style disable_text_highlighting">
                            <div class="select-replacement" data-target-field="guests_adult">
                                <div class="select-replacement__line1 clearfix">
                                    <div class="right">
                                        <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i></div>
                                    <div class="left"><span class="num_val num_val_adult">2</span> {{ trans('txt.guest') }}</div>
                                </div>
                                <div class="select-replacement__line2 clearfix">
                                    <div class="right">
                                        <a class="num_down"><i class="fa fa-caret-down"></i></a>
                                        <span  class="num_val num_val_adult">2</span> <a class="num_up"><i class="fa fa-caret-up"></i></a>
                                    </div>
                                    <div class="left">{{ trans('txt.number_of_guests') }}</div>
                                </div>
                            </div>
                            <select name="guests_adult" id="guests_adult" style="display: none">
                                <option  value="1">{{ trans('txt.1guest') }}</option>
                                <option  value="2" selected="selected">{{trans('txt.number-guests', ['number' => 2])}}</option>
                                <option  value="3">{{trans('txt.number-guests', ['number' => 3])}}</option>
                                <option  value="4">{{trans('txt.number-guests', ['number' => 4])}}</option>
                                <option  value="5">{{trans('txt.number-guests', ['number' => 5])}}</option>
                                <option  value="6">{{trans('txt.number-guests', ['number' => 6])}}</option>
                                <option  value="7">{{trans('txt.number-guests', ['number' => 7])}}</option>
                                <option  value="8">{{trans('txt.number-guests', ['number' => 8])}}</option>
                            </select>
                        </div>
                        <div class="clearfix select-style disable_text_highlighting">
                            <div class="select-replacement" data-target-field="guests_child">
                                <div class="select-replacement__line1 clearfix">
                                    <div class="right">
                                        <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i></div>
                                    <div class="left"><span class="num_val num_val_child">0</span> {{ trans('txt.children') }}
                                    </div>
                                </div>
                                <div class="select-replacement__line2 clearfix">
                                    <div class="right">
                                        <a class="num_down"><i class="fa fa-caret-down"></i></a>
                                        <span  class="num_val num_val_child">0</span> <a class="num_up"><i class="fa fa-caret-up"></i></a>
                                    </div>
                                    <div class="left">{{ trans('txt.number_of_children') }}</div>
                                </div>
                            </div>
                            <select name="guests_child" id="guests_child" style="display: none">
                                <option value="0">{{ trans('txt.0child') }}</option>
                                <option value="1">{{ trans('txt.1child') }}</option>
                                <option value="2">{{trans('txt.number-children', ['number' => 2])}}</option>
                                <option value="3">{{trans('txt.number-children', ['number' => 3])}}</option>
                                <option value="4">{{trans('txt.number-children', ['number' => 4])}}</option>
                                <option value="5">{{trans('txt.number-children', ['number' => 5])}}</option>
                                <option value="6">{{trans('txt.number-children', ['number' => 6])}}</option>
                                <option value="7">{{trans('txt.number-children', ['number' => 7])}}</option>
                                <option value="8">{{trans('txt.number-children', ['number' => 8])}}</option>
                            </select>
                        </div>
                        <div class="extras extras-active_color clearfix">
                            <div class="extra">
                            <span class="extra_title">
                                {{ trans('txt.room_price') }}
                                <span class="extra_subtitle">
                                    @php
                                        $number_coupons = trans('txt.number-coupons', ['number' => '<span id="calculated_days">1</span>']);

                                    @endphp
                                    {!! trans('txt.you-need-number-coupons-for-these-dates', ['number_coupons' => $number_coupons ]) !!}
                                </span>
                            </span> <span class="extra_price">
                                {{ trans('txt.text_free') }}
                            </span>
                            </div>
                        </div>
                        @php
                        $FoodTextExplode = explode(' (', $hotel->getBoardFoodAllowance());
                        @endphp
                        
                        <div class="extras clearfix">
                            <div class="extra">
                            <span class="extra_title">
                                @if (count($FoodTextExplode) > 0)
                                {{$FoodTextExplode[0]}}
                                <br>
                                {{'(' . $FoodTextExplode[1]}}
                                <span class="extra_subtitle">
                                    {{ trans('txt.per_person_per_day') }}
                                </span>
                            </span> <span class="extra_price">
                                        {{ \App\Helpers::localizedCurrency($hotel->price) }}
                            </span>
                            </div>
                        </div>
                        @endif
                        <div class="extras clearfix" id="total_price"
                             data-price-per-person="{{ $hotel->price }}"
                             data-price-symbol="{{\App\Helpers::getCurrentCurrencySymbol()}}">
                            <div class="extra">
                            <span class="extra_title">
                                {{ trans('txt.total') }}
                                <span class="extra_subtitle">
                                    {{ trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%
                                </span>
                            </span> <span class="extra_price">
                                    <span
                                        id="calculated_price">{{ \App\Helpers::localizedCurrency(($hotel->price * 2)) }}</span>
                                </span>
                            </div>
                        </div>
                        <button
                            class="mg-primary-button mg-primary-button__aligned handButton">{{  trans('txt.send_booking_request_short') }}
                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="detail-note mobile-only">
                    <p>
                        {{ trans('txt.det_notice_line1') }}<br/>
                        {{ trans('txt.det_notice_line2') }}
                    </p>
                </div>
                <div class="detail-information mobile-only">
                    <h4>{{ trans('txt.det_hotel_information_title') }}</h4>
                    <div class="detail-text cropped">
                        {!! $hotel->description !!}
                    </div>
                    <a href="#" class="detail-read-more">{{ trans('txt.read_more_button') }}
                        <i class="fa fa-caret-down"></i></a>
                </div>
                @if ($hotel->getPropertyCheckinCheckout())
                    <div class="detail-information property-information mobile-only">
                        <div class="detail-text  checkin-checkout">
                            {!! $hotel->getPropertyCheckinCheckout() !!}
                        </div>
                    </div>
                @endif
                @if ($hotel->propertyDescription != '')
                    <div class="detail-information property-information mobile-only">
                        <h4>{{ trans('txt.det_meal_package_title') }}</h4>
                        <div class="detail-text cropped">
                            {!! $hotel->propertyDescription !!}
                        </div>
                        <a href="#" class="detail-read-more">{{ trans('txt.read_more_button') }}
                            <i class="fa fa-caret-down"></i></a>
                    </div>
                @endif
            </div>
            <div class="page-amenities-block">
                @php
                    $featureCategories = \App\Models\FeatureCategories::all();
                @endphp
                @foreach($featureCategories as $featureCategory)
                    <div class="detail-amenities">
                        <h4>
                            <img
                                src="{{ asset('front/assets/'.$featureCategory->icon) }}"/>{{ ($featureCategory->lang_key) ? trans('txt.'.$featureCategory->lang_key) : $featureCategory->name }}
                        </h4>
                        @php
                            $featureGroups = $featureCategory->groups()->get();
                        @endphp
                        @foreach($featureGroups as $group)
                            @php
                                $features = $hotel->features()->where('group_id',$group->id)->get();
                            @endphp
                            @if($features->count() > 0)
                                <h5>{{ ($group->lang_key) ? trans('txt.'.$group->lang_key) : $group->name }}</h5>
                                <ul class="clearfix">
                                    @foreach($features as $feature)

                                        <li>
                                            <img
                                                src="{{ asset('front/assets/images/svg/tick.svg') }}"/> {{ $feature->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="map-block">
        <iframe
            src="https://maps.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&hl=es;z=14&amp;output=embed"
            width="600" height="450" frameborder="0" style="border:0"></iframe>
    </div>
@endsection

@section('javascripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>

    var hotelId = "{{$hotel->id}}";
    var storagedHotel = localStorage.getItem('storageHotel');
    if (hotelId != storagedHotel) {
        localStorage.clear('storageCheckin');
        localStorage.clear('storageCheckout');
        localStorage.clear('guests_adult');
        localStorage.clear('guests_child');
    }

</script>

<script>

    if (localStorage.getItem('guests_adult') != null ) {
        $('#guests_adult').each(function() {
                    $(this).find('option[value="'+localStorage.getItem('guests_adult')+'"]').attr('selected', true);
                });
        $('.num_val_adult').html(localStorage.getItem('guests_adult'));
    }

    if (localStorage.getItem('guests_child') != null ) {
        $('#guests_child').each(function() {
                    $(this).find('option[value="'+localStorage.getItem('guests_child')+'"]').attr('selected', true);
                });
                $('.num_val_child').html(localStorage.getItem('guests_child'));
    }

</script>

    <script>
        jQuery('.select2').select2();


        var galleryImages = [];

        @if($hotel->getGalleryWebImages())
        @foreach($hotel->getGalleryWebImages() as $image)
        galleryImages.push({"src": "{{ $image['path'] }}", "thumb": "{{ $image['path'] }}"});
        @endforeach
        @endif

        $('.view-photos').on('click', function (event) {
            event.preventDefault();

            $(this).lightGallery({
                dynamic: true,
                dynamicEl: galleryImages,
                download: false,
                autoplayControls: false
            })
        });


    </script>
    
    <script>
        function checkDates() {
            if ($('#date_checkin').val() == $('#date_checkout').val()) {

                var startDay = new Date($('#date_checkin').val());
                var nextDay = new Date();
                nextDay.setDate(startDay.getDate() + 1);

                $('#date_checkout').val(formattedDate(nextDay));
            }
        }

        function checkUnavailableDates() {

            var startDate = $('#date_checkin').val();
            var endDate = $('#date_checkout').val();
            var check = false;
            @json($dates).
            forEach(unavaliableDate => {
                if (startDate < unavaliableDate && endDate > unavaliableDate) {
                    check = true;
                    return;
                }
            });
            return check;
        }

    var disabledDates = @json($dates);
    var today = new Date();
    var dpicker = $('#date-picker').datepicker({
        range: true,
        dateFormat: 'yyyy-mm-dd',
        inline: true,
        startDate: today,
        firstDay: 1,
        language: '{{\Illuminate\Support\Facades\App::getLocale()}}',
        onRenderCell: function (d, cellType) {
            if (cellType == 'day') {
             var disabled = false,
      		 formatted = formattedDate(d);
               var classes = "";
              if (today > d) {
                    disabled = true;
                    classes = "old-day"
                } else {
                    disabled = disabledDates.filter(function(date){
                        return date == formatted;
                    }).length
                    classes = "unavailable-day"
                }
                if (disabled == true) {
                    return {
                        disabled: disabled,
                        classes: classes
                    }
                }else{
                    return {
                        disabled: disabled,
                    }
                }
            }
        },
        onSelect: function (selectedDate, date, inst) {
                var dates = selectedDate.split(',');
                if (typeof (dates[0]) !== 'undefined') {
                    //first date
                    localStorage.setItem('storageCheckin', dates[0]);
                    localStorage.setItem('storageHotel', "{{$hotel->id}}");

                    printFormattedDate(dates[0], 'checkin', '{{\Illuminate\Support\Facades\App::getLocale()}}');
                    $('#date_checkin').val(dates[0]);
                }

                if (typeof (dates[1]) !== 'undefined') {
                    //second date
                    localStorage.setItem('storageCheckout', dates[1]);
                    printFormattedDate(dates[1], 'checkout', '{{\Illuminate\Support\Facades\App::getLocale()}}');
                    $('#date_checkout').val(dates[1]);

                    $('.dates-wrapper-outer').removeClass('picker-visible');
                } else {
                    var startDay = new Date($('#date_checkin').val());
                    var nextDay = new Date();
                    nextDay.setDate(startDay.getDate() + 1);

                    printFormattedDate(formattedDate(nextDay), 'checkout', '{{\Illuminate\Support\Facades\App::getLocale()}}');
                    $('#date_checkout').val(formattedDate(nextDay));
                }

                if (checkUnavailableDates()) {
                    inst.clear();

                    var startDay = new Date();
                    var nextDay = new Date();
                    nextDay.setDate(startDay.getDate() + 1);
                    startDay.setDate(nextDay.getDate() - 1);

                    printFormattedDate(formattedDate(nextDay), 'checkout', '{{\Illuminate\Support\Facades\App::getLocale()}}');
                    printFormattedDate(formattedDate(startDay), 'checkin', '{{\Illuminate\Support\Facades\App::getLocale()}}');

                    $('#date_checkin').val(formattedDate(startDay));
                    $('#date_checkout').val(formattedDate(nextDay));

                    Swal.fire('{{ trans('txt.booking_alert_unavailable_date') }}');
                    return;
                }

                checkDates();
                calculateRoomTotal();
            }
        });

        if (localStorage.getItem('storageCheckin') != null && localStorage.getItem('storageCheckout') != null) {

            printFormattedDate(localStorage.getItem('storageCheckin'), 'checkin', '{{\Illuminate\Support\Facades\App::getLocale()}}');
            printFormattedDate(localStorage.getItem('storageCheckout'), 'checkout', '{{\Illuminate\Support\Facades\App::getLocale()}}');
            $('#date_checkin').val(localStorage.getItem('storageCheckin'));
            $('#date_checkout').val(localStorage.getItem('storageCheckout'));

            calculateRoomTotal();
        }

        $('#date-picker').css('display', 'none');
        $('.dates-wrapper,.datepicker-hider').click(function (event) {
            event.stopPropagation();
        });
        $('.dates-wrapper h4 a.checkin').on('click', function (event) {
            event.preventDefault();

            $('.dates-wrapper-outer').addClass('picker-visible');
        });

        $('.dates-wrapper h4 a.checkout').on('click', function (event) {
            event.preventDefault();

            $('.dates-wrapper-outer').addClass('picker-visible');
        });
        $(window).click(function () {
            $('.dates-wrapper-outer').removeClass('picker-visible');
        });

        </script>
@endsection
