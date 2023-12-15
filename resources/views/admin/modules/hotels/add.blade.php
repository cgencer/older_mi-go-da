@extends('admin.layouts.master')@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title')
    Add New Hotel | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/air-datepicker/dist/css/datepicker.min.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/air-datepicker/dist/js/datepicker.min.js')}}"></script>
    <script src="{{ asset('admin/assets/vendor/air-datepicker/dist/js/i18n/datepicker.'.$app_locale.'.js') }}" charset="UTF-8"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnYtYeLXFaQcDXfhjf5FYwdp4SDhuF1ts&libraries=places&callback=initialize" async defer></script>
    <script type="text/javascript">
        function initialize() {

            $('form').on('keyup keypress', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            const locationInputs = document.getElementsByClassName("map-input");

            const autocompletes = [];
            const geocoder = new google.maps.Geocoder;
            for (let i = 0; i < locationInputs.length; i++) {

                const input = locationInputs[i];
                const fieldKey = input.id.replace("-input", "");
                const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

                const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

                const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                    center: {lat: latitude, lng: longitude},
                    zoom: 13
                });
                const marker = new google.maps.Marker({
                    map: map,
                    position: {lat: latitude, lng: longitude},
                });

                marker.setVisible(isEdit);

                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.key = fieldKey;
                autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
            }

            for (let i = 0; i < autocompletes.length; i++) {
                const input = autocompletes[i].input;
                const autocomplete = autocompletes[i].autocomplete;
                const map = autocompletes[i].map;
                const marker = autocompletes[i].marker;

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    marker.setVisible(false);
                    const place = autocomplete.getPlace();

                    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    });

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        input.value = "";
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                });
            }
        }

        function setLocationCoordinates(key, lat, lng) {
            const latitudeField = document.getElementById(key + "-" + "latitude");
            const longitudeField = document.getElementById(key + "-" + "longitude");
            latitudeField.value = lat;
            longitudeField.value = lng;
        }

        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 13
        });
        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: longitude},
        });
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
        geocoder.geocode({'placeId': place.place_id}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {

                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();

                setLocationCoordinates(autocomplete.key, lat, lng);
            }
        });
    </script>
    <script src="{{asset('admin/assets/vendor/sortable/sortable.js')}}"></script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            $('.timepicker').datepicker({
                minHours: 0,
                maxHours: 23,
                timepicker: true,
                onlyTimepicker: true
            });
            var el = document.getElementById("images-sortable");
            var sortable = Sortable.create(el);
            $("body").delegate("#images-sortable a.remove-item", "click", function (e) {
                e.preventDefault();
                $(this).parent().remove();
                return false;
            });
            $('.galery-card a.add-item').filemanagerGalery('images', {
                'prefix': '/admin/filemanager',
                {{--'hotelId': {{$data->id}}--}}
            });
            $('.lfm_image_button').filemanager('Images', {
                'prefix': '/admin/filemanager',
                {{--'hotelId': {{$data->id}}--}}
            });
        })(jQuery);
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Add New Hotel</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Hotels Management</span>
                        <a class="breadcrumb-item" href="{{route('admin.hotels.index')}}">Hotels</a>
                        <span class="breadcrumb-item active">Add New Hotel</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            {{ Form::open(array('url' => route('admin.hotels.add.post'), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
            <div class="row form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Hotel User</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="">
                            <div class="card-body">
                                <div class="hotel-users" id="hotel-users">
                                    <div class="row form-row hotelUser-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{Form::label('firstname', 'Firstname *', array('class' => 'control-label'))}}
                                                {{Form::text('hotelUsers[0][firstname]', null, array('class' => 'form-control','required'=>true))}}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{Form::label('lastname', 'Lastname *', array('class' => 'control-label'))}}
                                                {{Form::text('hotelUsers[0][lastname]', null, array('class' => 'form-control','required'=>true))}}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{Form::label('email', 'Email *', array('class' => 'control-label'))}}
                                                {{Form::text('hotelUsers[0][email]', null, array('class' => 'form-control','required'=>true))}}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{Form::label('password', 'Password *', array('class' => 'control-label'))}}
                                                {{Form::password('hotelUsers[0][password]', array('class' => 'form-control','required'=>true))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Hotel</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            {!! Form::checkbox('is_enabled', '1', false,  ['id' => 'is_enabled']) !!}
                                            {{Form::label('is_enabled', 'Is Enabled', array('class' => 'control-label'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            {!! Form::checkbox('is_verified', '1', false,  ['id' => 'is_verified']) !!}
                                            {{Form::label('is_verified', 'Migoda Verified Property', array('class' => 'control-label'))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">General</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('name', 'Name *', array('class' => 'control-label'))}}
                                            {{Form::text('name', '', array('class' => 'form-control'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('sku', 'Sku *', array('class' => 'control-label'))}}
                                            {{Form::text('sku', '', array('class' => 'form-control'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('description', 'Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('description', '', array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5>Star *</h5>
                                <div class="row">
                                    @php
                                        $stars = \App\Models\Features::where('type','star')->orderby('name','asc')->get();
                                    @endphp
                                    @foreach($stars as $star)
                                        <div class="col-md-6">
                                            <div class="radio">
                                                {!! Form::radio('star_id', $star->oldID, false,  ['id' => 'star_id_'.$star->id]) !!}
                                                {{Form::label('star_id_'.$star->id, $star->name, array('class' => 'control-label'))}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5>Property Types *</h5>
                                <div class="row">
                                    @php
                                        $categories = \App\Models\HotelCategories::all()->pluck('name','id');
                                    @endphp
                                    @foreach($categories as $id => $category)
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                {!! Form::checkbox('categories[]', $id, false,  ['id' => 'category_'.$id]) !!}
                                                {{Form::label('category_'.$id, $category, array('class' => 'control-label'))}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('property_checkin', 'Property check-in times *', array('class' => 'control-label'))}}
                                        {{Form::text('property_checkin', '', array('class' => 'form-control timepicker'))}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('property_checkout', 'Property check-out times *', array('class' => 'control-label'))}}
                                        {{Form::text('property_checkout', '', array('class' => 'form-control timepicker'))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('price', 'Price (in EUR, including tax) *', array('class' => 'control-label'))}}
                                {{Form::text('price', '', array('class' => 'form-control'))}}
                            </div>
                        </div>

                                <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Location Details</h5>

                                            <label for="address_address">Search Address</label>
                                            <input type="text" id="address-input" name="address_address" class="form-control map-input">
                                        </div>
                                        <div class="form-group">
                                            <div id="address-map-container" style="width:100%;height:400px; ">
                                                <div style="width: 100%; height: 100%" id="address-map"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{Form::label('address', 'Address *', array('class' => 'control-label'))}}
                                                    {{Form::textarea('address', '', array('class' => 'form-control','rows'=>5,'required'=>'required'))}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{Form::label('latitude', 'Latitude *', array('class' => 'control-label'))}}
                                                    <input type="text" name="latitude" id="address-latitude" class="form-control" value="" required="required"/>
                                                </div>
                                                <div class="col-md-6">
                                                    {{Form::label('longitude', 'Longitude *', array('class' => 'control-label'))}}
                                                    <input type="text" name="longitude" id="address-longitude" class="form-control" value="" required="required"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{Form::label('country_id', 'Country *', array('class' => 'control-label'))}}
                                                    @php
                                                        $countries= \App\Models\Countries::all()->pluck('name','id')->toArray();
                                                    @endphp
                                                    {!! Form::select('country_id', $countries, '', ['class' => 'selectize']) !!}
                                                </div>
                                                <div class="col-md-6">
                                                    {{Form::label('city', 'City *', array('class' => 'control-label'))}}
                                                    {{Form::text('city', '', array('class' => 'form-control','required'=>'required'))}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Property Facilities</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            @php
                            $features_categories = \App\Models\FeatureCategories::orderby('name','desc')->get();
                        @endphp
                        @foreach($features_categories as $features_category)
                        @if ($features_category->id == 1)
                            <div class="col-md-12">
                                <div class="form-group">
                                    @php
                                       $groups = $features_category->groups()->orderby('admin_position','asc')->get();
                                    @endphp
                                    @foreach($groups as $id => $group)
                                    @if ($group->type != "star")
                                        <div class="form-group">
                                            <label class="control-label required">{{$group->name}}</label>
                                            @php
                                                $features = $group->features()->get();
                                            @endphp
                                            <div class="row">
                                                @foreach($features as $feature)
                                                    <div class="col-md-3">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('features[]', $feature->id,null,  ['id' => 'features_'.$feature->id]) !!}
                                                            {{Form::label('features_'.$feature->id, $feature->name, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Gift for Migoda guests</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                {!! Form::checkbox('gift_for_migoda_guests', '1', '',  ['id' => 'gift_for_migoda_guests']) !!}
                                                {{Form::label('gift_for_migoda_guests', 'Welcome gift', array('class' => 'control-label'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>GIFTS</h5>
                                        <div class="row">
                                            @php
                                                $gifts = \App\Models\Features::where('type','gift')->orderby('name','asc')->get();
                                            @endphp
                                            @foreach($gifts as $gift)
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('gift[]', $gift->id, false,  ['id' => 'gift_'.$gift->id]) !!}
                                                            {{Form::label('gift_'.$gift->id, $gift->name, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('gift_description', 'Gift Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('gift_description', '', array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Food & Drinks</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            <div class="card-body">
                                <div class="row form-row">

                                    @php
                                        $features_categories = \App\Models\FeatureCategories::orderby('name','asc')->get();
                                    @endphp
                                    @foreach($features_categories as $features_category)
                                        @if ($features_category->id == 2)

                                        <div class="col-md-12">
                                            <div class="form-group">

                                                @php
                                                    $groups = $features_category->groups()->get();
                                                @endphp
                                                @foreach($groups as $id => $group)
                                                    <div class="form-group">
                                                        <label class="control-label required">{{$group->name}}</label>
                                                        @php
                                                            $features = $group->features()->get();
                                                        @endphp
                                                        <div class="row">
                                                            @foreach($features as $feature)
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        {!! Form::checkbox('features[]', $feature->id, '',  ['id' => 'features_'.$feature->id]) !!}
                                                                        {{Form::label('features_'.$feature->id, $feature->name, array('class' => 'control-label'))}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                    @endforeach
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                {!! Form::checkbox('gift_for_migoda_guests', '1', '',  ['id' => 'gift_for_migoda_guests']) !!}
                                                {{Form::label('gift_for_migoda_guests', 'Welcome gift', array('class' => 'control-label'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>GIFTS</h5>
                                        <div class="row">
                                            @php
                                                $gifts = \App\Models\Features::where('type','gift')->orderby('name','asc')->get();
                                            @endphp
                                            @foreach($gifts as $gift)
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('gift[]', $gift->id, false,  ['id' => 'gift_'.$gift->id]) !!}
                                                            {{Form::label('gift_'.$gift->id, $gift->name, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('gift_description', 'Gift Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('gift_description', '', array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Meal Package Offer</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn"
                                           data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" >
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <h4>BOARD MEAL ALLOWANCE - (MEAL PACKAGE TYPE)</h4>
                                        <div class="row">
                                            @php
                                                $board_food_allowances = \App\Models\Features::where('type','board_food_allowance')->orderby('name','asc')->get();
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        @foreach($board_food_allowances as $board_food_allowance)
                                                            <div class="col-md-6">
                                                                <div class="radio">
                                                                    {!! Form::radio('board_food_allowance_id', $board_food_allowance->id, null,  ['id' => 'board_food_allowance_id_'.$board_food_allowance->id]) !!}
                                                                    {{Form::label('board_food_allowance_id_'.$board_food_allowance->id, $board_food_allowance->name, array('class' => 'control-label'))}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('price', 'Price (in EUR, including tax) *', array('class' => 'control-label'))}}
                                            {{Form::text('price', null, array('class' => 'form-control','required'=>'required'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('property_description', 'Meal Package Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('property_description', '', array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    {{-- @php
                                        $features_categories = \App\Models\FeatureCategories::orderby('name','desc')->get();
                                    @endphp
                                    @foreach($features_categories as $features_category)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h4>{{$features_category->name}} *</h4>
                                                @php
                                                    $groups = $features_category->groups()->get();
                                                @endphp
                                                @foreach($groups as $id => $group)
                                                    <div class="form-group">
                                                        <label class="control-label required">{{$group->name}}</label>
                                                        @php
                                                            $features = $group->features()->get();
                                                        @endphp
                                                        <div class="row">
                                                            @foreach($features as $feature)
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        {!! Form::checkbox('features[]', $feature->id, $data->checkFeature($feature->id),  ['id' => 'features_'.$feature->id]) !!}
                                                                        {{Form::label('features_'.$feature->id, $feature->name, array('class' => 'control-label'))}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Location Details</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="address_address">Search Address</label>
                                    <input type="text" id="address-input" name="address_address" class="form-control map-input">
                                </div>
                                <div class="form-group">
                                    <div id="address-map-container" style="width:100%;height:400px; ">
                                        <div style="width: 100%; height: 100%" id="address-map"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{Form::label('address', 'Address *', array('class' => 'control-label'))}}
                                            {{Form::textarea('address', '', array('class' => 'form-control','rows'=>5,'required'=>'required'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{Form::label('latitude', 'Latitude *', array('class' => 'control-label'))}}
                                            <input type="text" name="latitude" id="address-latitude" class="form-control" value="" required="required"/>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('longitude', 'Longitude *', array('class' => 'control-label'))}}
                                            <input type="text" name="longitude" id="address-longitude" class="form-control" value="" required="required"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{Form::label('country_id', 'Country *', array('class' => 'control-label'))}}
                                            @php
                                                $countries= \App\Models\Countries::all()->pluck('name','id')->toArray();
                                            @endphp
                                            {!! Form::select('country_id', $countries, '', ['class' => 'selectize']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('city', 'City *', array('class' => 'control-label'))}}
                                            {{Form::text('city', '', array('class' => 'form-control','required'=>'required'))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Unavailable dates</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            <div class="card-body">
                                {{Form::text('unavailable_dates',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd'])}}
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Hotel Contact Person</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn" data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible">
                            <div class="card-body">
                                <div class="form-group">
                                    {{Form::label('contact_person', 'Contact Person *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_person', '', array('class' => 'form-control'))}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('contact_email', 'Contact Email *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_email', '', array('class' => 'form-control'))}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('contact_phone', 'Contact Phone *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_phone', '', array('class' => 'form-control'))}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12">
                    <div class="p-h-15">
                        <div class="form-group">
                            <div class="text-sm-right">
                                <button type="submit" class="btn btn-gradient-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection
