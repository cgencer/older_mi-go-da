@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
@endphp
@section('title') {{ trans('txt.page_title_booking_details') }} @parent @endsection
@section('top_nav')
    <ul class="header-navigation desktop-only steps">
        <li><a class="active" href="#">{{ trans('txt.title_booking_details') }}</a></li>
        <li><a href="#">{{ trans('txt.title_confirm') }}</a></li>
        <li><a href="#">{{ trans('txt.title_payment') }}</a></li>
    </ul>
@endsection
@section('body')
    <div class="booking-details-outer mg-section mg-group">
        <h1>{{ trans('txt.title_booking_page') }}</h1>
        <div class="booking-details page-two-column">
            <div class="page-two-column-inner">
                <div class="two-column-left generic-form">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    {!! Form::open(['route'=>'f.bookAction','method' => 'post']) !!}
                    {!! Form::hidden('hotel', $hotel->uuid, ['id' => 'uuid']) !!}
                    @csrf
                    <div class="form-input">
                        <div>
                            {!! Form::label('main_guest', trans('txt.field_main_guest')) !!}
                            {!! Form::text('main_guest', $user->firstname.' '.$user->lastname, ['required'=>'required']) !!}
                        </div>
                    </div>
                    <div class="form-input">
                        <div>
                            {!! Form::label('email', trans('txt.field_email')) !!}
                            {!! Form::email('email', $user->email, ['required'=>'required', 'readonly' => 'true']) !!}
                        </div>
                    </div>
                    {{-- <div class="form-input">
                        <div>
                            {!! Form::label('phone', trans('txt.field_phone')) !!}
                            {!! Form::text('phone', '(+' . $user->prefix . ') ' . $user->phone, ['required'=>'required']) !!}
                        </div>

                    </div> --}}
                    <div class="form-row  form-countries">

                        <div class="col-2">
                            {!! Form::label('email', trans('txt.field_phone')) !!}
                            <div>
                                @php
                                    $set = \App\Models\Countries::orderBy('name', 'ASC')->get();
                                @endphp
                                    <input type="tel" name="prefix" class="phone1" id="PhoneNumber1" style="visibility:hidden" value="{{ $user->prefix }}">
                                    <input type="tel" name="country" class="iso2" id="iso2" style="visibility:hidden">
                            </div>
                        </div>
                        <div class="col">
                            <label for="">&nbsp;</label>
                            <div class="form-input phone-container">
                             <input type="tel" name="phone" class="phone2" id="PhoneNumber2" value="{{ $user->phone }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-input form-gender">
                        <div>
                            {!! Form::label('gender', trans('txt.field_gender')) !!}
                            {!! Form::select('gender', ['' => 'Not specified','m' => 'Male','f' => 'Female'],$user->gender, ['required'=> true]) !!}
                        </div>
                    </div>
                    <div class="form-input form-date-of-birth">
                        <div>
                            @php
                                $days =[];
                                $years =[];
                                for($i=1;$i<=31;$i++){
                                    $days[$i] = $i;
                                }
                                for($i=1900;$i<=date('Y');$i++){
                                    $years[$i] = $i;
                                }
                                $date_of_birth = $user->date_of_birth;
                                $day = null;
                                $month = null;
                                $year = null;
                                if($date_of_birth != ""){
                                    $date_of_birth = \DateTime::createFromFormat('Y-m-d', $date_of_birth);
                                    $day= (int)$date_of_birth->format('d');
                                    $month= (int)$date_of_birth->format('m');
                                    $year= (int)$date_of_birth->format('Y');
                                }else{
                                    $day ="";
                                    $month = "";
                                    $yearNow = \Carbon\Carbon::now()->year;
                                    $year = (int)$yearNow - 18;
                                    $days = collect(['' => trans('txt.book_select_day_birth')] + $days);
                                }
                            @endphp
                            {!! Form::label('dob', trans('txt.field_date_of_birth')) !!}
                            <div>
                                {!! Form::select('month', [''=> trans('txt.book_select_month_birth'), '1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'] , $month , ['class' => 'form-control', 'required' => true]) !!}{!! Form::select('day', $days , $day , ['class' => 'form-control', 'required' => true]) !!}{!! Form::select('year', $years , $year , ['class' => 'form-control', 'required' => true]) !!}</select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions form-actions-inline">
                        <button class="mg-primary-button__passive backButton handButton bookingButtonLeft" data-previous-url="{{ route('f.detail', ['slug' => $hotel->slug,'id'=>$hotel->id]) }}">
                            <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/>
                        </button>
                        @if ($coupons_needed > $coupons_valid)
                            <button class="mg-primary-button__disabled handButton bookingButtonRight" disabled="disabled" id="bookingRequestButton">{{ trans('txt.send_booking_request_button') }}
                                <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/></button>
                        @else
                            <button class="mg-primary-button handButton bookingButtonRight" id="bookingRequestButton">{{ trans('txt.send_booking_request_button') }}
                                <img src="{{ asset('front/assets/images/svg/arrow.svg') }}"/></button>
                        @endif
                    </div>
                    {!! Form::hidden('coupons_needed',$coupons_needed, ['id' => 'coupons_needed']) !!}
                    {!! Form::hidden('guest_adult',$guests_adult, ['id' => 'guest_adult']) !!}
                    {!! Form::hidden('guest_child',$guests_child, ['id' => 'guest_child']) !!}
                    {!! Form::hidden('checkinDate',$date_checkin->format('Y-m-d'), ['id' => 'checkinDate']) !!}
                    {!! Form::hidden('checkoutDate',$date_checkout->format('Y-m-d'), ['id' => 'checkoutDate']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="two-column-right">
                    <div class="two-column-right-inner">
                        <div class="hotel-info clearfix">
                            <div id="book-image">
                                <img src="@if ($hotel->getImageUrl('imdlisting'))  {{ $hotel->getImageUrl('imdlisting') }} @else https://dummyimage.com/211x180 @endif" class="img-desktop desktop-only" width="211" height="180"/>
                                <img src="@if ($hotel->getImageUrl('immlisting')) {{ $hotel->getImageUrl('immlisting') }} @else https://dummyimage.com/315x95 @endif" class="img-mobile mobile-only"/>
                            </div>
                            {!! $hotel->getStarHtml() !!}
                            <h2>{{ $hotel->name }}</h2>
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
                        <div class="calendar-wrapper">
                            <div class="blocks-wrapper">
                                <div class="blocks-left">
                                    <h5>{{ trans('txt.det_checkin_title') }}</h5>
                                    <h4>{!! $date_checkin->format('M d, Y') !!}</h4>
                                </div>
                                <div class="blocks-right">
                                    <h5>{{ trans('txt.det_checkout_title') }}</h5>
                                    <h4>{!! $date_checkout->format('M d, Y') !!}</h4>
                                </div>
                            </div>
                            <div class="blocks-wrapper">
                                <div class="blocks-left">
                                    <h4>{{ trans('txt.number-guests',['number'=>$guests_adult]) }}</h4>
                                </div>
                                <div class="blocks-right">
                                    <h4>
                                        @if ($guests_child > 1)
                                            {{trans('txt.number-children',['number'=>$guests_child])}}
                                        @else
                                            {{trans('txt.number-children',['number'=>$guests_child])}}
                                        @endif
                                    </h4>
                                </div>
                            </div>
                            <div class="extras extras-active_color clearfix">
                                <div class="extra">
                                    <span class="extra_title">
                                        {{ trans('txt.room_price') }}
                                        <span class="extra_subtitle">
                                            @php
                                                $number_coupons = trans('txt.number-coupons',['number'=>'<span id="calculated_days">'.$coupons_needed.'</span>']);
                                            @endphp
                                            {!! trans('txt.you-need-number-coupons-for-these-dates',['number_coupons'=>'<span>'.$number_coupons.'</span>']) !!}
                                        </span>
                                    </span> <span class="extra_price">
                                        {{ trans('txt.text_free') }}
                                    </span>
                                </div>
                            </div>
                            <div class="extras clearfix">
                                <div class="extra">
                            <span class="extra_title">
                               @php
                                   $boardFoodExp = explode(' (', $hotel->getBoardFoodAllowance());
                               @endphp
                                @if (count($boardFoodExp) > 0)
                                    {{$boardFoodExp[0]}}
                                @else
                                    {{$hotel->getBoardFoodAllowance()}}
                                @endif
                                <span class="extra_subtitle">
                                    {{ trans('txt.per_person_per_day') }}
                                </span>
                            </span> <span class="extra_price">
                                {{ \App\Helpers::localizedCurrency($hotel->price) }}
                            </span>
                                </div>
                            </div>
                            <div class="extras clearfix" id="total_price" data-price-per-person="{{ \App\Helpers::localizedCurrency($hotel->price) }}">
                                <div class="extra">
                            <span class="extra_title">
                                {{  trans('txt.total') }}
                                <span class="extra_subtitle">
                                     {{  trans('txt.vat_or_kdv') }} {{ $hotel->vat }}%
                                </span>
                            </span> <span class="extra_price">
                                    <span id="calculated_price">{{ \App\Helpers::localizedCurrency($price) }}</span>
                                </span>
                                </div>
                            </div>
                        </div>
                        @php
                            if($coupons_needed > $coupons_valid){
                                $bookBottomActive= 'hidden';
                                $bookBottomPassive = '';
                            }else{
                                $bookBottomActive= '';
                                $bookBottomPassive = 'hidden';
                            }
                        @endphp
                        <div class="book-bottom {{ $bookBottomPassive }} book-bottom-passive" id="book-bottom-passive">
                            <button type="button" class="btn btn-add" data-toggle="modal" data-target="#addCouponsModalCenter">
                                <img src="{{ asset('front/assets/images/svg/add.svg') }}"/></button>
                            </button><img src="{{ asset('front/assets/images/svg/talk.svg') }}"/>
                            <p>
                                {!! trans('txt.text_you_dont_have_enough') !!}
                            </p>
                        </div>
                        <div class="book-bottom {{ $bookBottomActive }} book-bottom-active" id="book-bottom-active">
                            <button type="button" class="btn btn-add" data-toggle="modal" data-target="#addCouponsModalCenter">
                                <img src="{{ asset('front/assets/images/svg/add.svg') }}"/></button>
                            </button>
                            {!! trans('txt.you-have-number-coupons',['number'=>'<span id="coupons_valid">'.$coupons_valid.'</span>']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="booking-details-message">
                @if (\Illuminate\Support\Facades\Cookie::get('booking_notice') != 1)
                    <div class="notice" id="booking_notice">
                        <a href="#" class="notice-button listing-notice" data-cookie-id="booking_notice">x</a>
                        {{ trans('txt.text_booking_notice') }}
                    </div>
                @endif
            </div>
        </div>
        </form>
    </div>
@endsection

@section('stylesheets')
    <style>
        .select2-container--default .select2-selection--single{
            padding-bottom: 34px;
            font-size: 17px;
            border: 0;
            border-bottom: 1px solid #ededed !important;
            padding-top: 0px;
            margin-top: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: unset;
            color: #000;
            line-height: 28px;
            font-size: 1.5rem;
            font-family: "Futura ND Light", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }
    </style>
    @php
    $code = null;
    if(!empty($user->prefix)) {
        $country = \App\Models\Countries::where('prefix', '=', $user->prefix)->get()->first();
        $code = $country['code'];
    }

    @endphp
@endsection

@section('javascripts')
    <script src="https://raw.githack.com/jackocnr/intl-tel-input/master/build/js/utils.js"></script>
    <script>
        jQuery('select').select2();
              (function($){
                       // function that uses intl-tel-input format as jQuery-Mask
                       function initMasking(formatterInput, maskedInput) {
                           // get the format front intl-tel-input placeholder
                           var format = $(formatterInput).attr('placeholder');

                           // use the format as placeholder to jQuery-Mask input
                           $(maskedInput).attr('placeholder', format);

                           // replace all digits to zero and use is as the mask
                           $(maskedInput).mask(format.replace(/[1-9]/g, 0));
                       }
                        var prefix = $("#PhoneNumber1");
                       // initialize intl-tel-input
                       prefix.intlTelInput({
                        initialCountry: "de",
                        autoPlaceholder: "aggressive",
                        utilsScript: "https://raw.githack.com/jackocnr/intl-tel-input/master/build/js/utils.js",
                        separateDialCode: true
                       });

                       @if($code != null)
                       //Set Country Flag
                       var iso2 = "{{ $code }}";

                       if(iso2 !== null && iso2!== undefined){

                            $("#PhoneNumber1").intlTelInput("setCountry",iso2);
                       }

                       @endif

                       // initialize the mask
                       initMasking("#PhoneNumber1", "#PhoneNumber2");
                       // update the mask format when changing country
                       $("#PhoneNumber1").on("countrychange", function (e, countryData) {
                           $(this).val('');
                           $("#PhoneNumber2").val('');

                           // update the mask
                           initMasking(this, "#PhoneNumber2");
                        });
                     })(jQuery);

                     $(".generic-form").submit(function() {
                       $("#PhoneNumber1").val($("#PhoneNumber1").intlTelInput("getSelectedCountryData").dialCode);
                        $("#iso2").val($("#PhoneNumber1").intlTelInput("getSelectedCountryData").iso2);
                     });
    </script>

@endsection
