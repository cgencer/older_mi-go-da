@extends('admin.layouts.master')@php
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title')
    Hotel Edit (ID: {{$data->id}}) | @parent
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
    <script src="{{ asset('admin/assets/vendor/air-datepicker/dist/js/i18n/datepicker.'.$app_locale.'.js') }}"
            charset="UTF-8"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnYtYeLXFaQcDXfhjf5FYwdp4SDhuF1ts&libraries=places&callback=initialize"
        async defer></script>
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
            $('.galery-card a.add-item').filemanagerGalery('Images', {
                'prefix': '/admin/filemanager',
                'rq': 'admin',
                'hotelId': {{$data->id}}
            });
            $('.lfm_image_button').filemanager('Images', {
                'prefix': '/admin/filemanager',
                'rq': 'admin',
                'hotelId': {{$data->id}}
            });
        })(jQuery);
    </script>
    @php
        $unavailableDates = $data->getUnavailableDates()->get()->pluck('date');
    @endphp
    @if($unavailableDates)
        <script>
            jQuery(document).ready(function ($) {
                $('.multi-datepicker').datepicker('setDates', [
                    @foreach($unavailableDates as $date)
                    new Date({{$date->format('Y')}}, {{$date->format('m') - 1}}, {{$date->format('d')}}),
                    @endforeach
                ])
            });
        </script>
    @endif
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">Hotel Edit (ID: {{$data->id}})</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <span class="breadcrumb-item">Hotels Management</span>
                        <a class="breadcrumb-item" href="{{route('admin.hotels.index')}}">Hotels</a>
                        <span class="breadcrumb-item active">Hotel Edit (ID: {{$data->id}})</span>
                    </nav>
                </div>
                <div class="header-action float-right">

                    <form class="form-inline" method="POST" action="{{ route('admin.hotels.invite',['id'=>$data->id])}}">
                        <div class="form-group mx-sm-3 mb-2">
                            <select name="lang" class="form-control select2" required>
                                <option value="">Please select invitation language</option>
                                <option value="en">English</option>
                                <option value="tr">Turkish</option>
                                <option value="de">Deutch</option>
                                <option value="fr">French</option>
                                <option value="nl">Netherland</option>
                            </select>
                        </div>
                        <button class="btn btn-gradient-success float-right" type="submit"> <i
                            class="fa fa-envelope"></i> Invite Hotel</button>
                      </form>
                </div>
            </div>
            @include('admin.partials.notifications')
            {{ Form::open(array('url' => route('admin.hotels.save',['id'=>$data->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
            <div class="row form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Hotel User</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                @php
                                    $hotelUsers = $data->hotel_user()->get();
                                @endphp
                                @foreach($hotelUsers as $n => $hotelUser)
                                    <div class="hotel-users" id="hotel-users">
                                        <div class="row form-row hotelUser-row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{Form::label('hotelUsers['.$n.'][firstname]', 'Firstname *', array('class' => 'control-label'))}}
                                                    {{Form::text('hotelUsers['.$n.'][firstname]', $hotelUser->firstname, array('class' => 'form-control'))}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{Form::label('hotelUsers['.$n.'][lastname]', 'Lastname *', array('class' => 'control-label'))}}
                                                    {{Form::text('hotelUsers['.$n.'][lastname]', $hotelUser->lastname, array('class' => 'form-control'))}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{Form::label('hotelUsers['.$n.'][email]', 'Email *', array('class' => 'control-label'))}}
                                                    {{Form::text('hotelUsers['.$n.'][email]', $hotelUser->email, array('class' => 'form-control'))}}
                                                    {{Form::hidden('hotelUsers['.$n.'][id]', $hotelUser->id, array('class' => 'form-control'))}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{Form::label('hotelUsers['.$n.'][password]', 'Password *', array('class' => 'control-label'))}}
                                                    {{Form::password('hotelUsers['.$n.'][password]', array('class' => 'form-control'))}}
                                                </div>
                                            </div>
                                            @if ($n != 0)
                                                <hr>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
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
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn"
                                           data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            {!! Form::checkbox('is_enabled', '1', $data->is_enabled,  ['id' => 'is_enabled']) !!}
                                            {{Form::label('is_enabled', 'Is Enabled', array('class' => 'control-label'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            {!! Form::checkbox('is_verified', '1', $data->is_verified,  ['id' => 'is_verified']) !!}
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
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn"
                                           data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="display:none;">
                            {{-- <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('name', 'Name *', array('class' => 'control-label'))}}
                                            {{Form::text('name', $data->name, array('class' => 'form-control'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('sku', 'Sku *', array('class' => 'control-label'))}}
                                            {{Form::text('sku', $data->sku, array('class' => 'form-control'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('description', 'Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('description', $data->description, array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('name', 'Name *', array('class' => 'control-label'))}}
                                            {{Form::text('name', $data->name, array('class' => 'form-control'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('sku', 'Sku *', array('class' => 'control-label'))}}
                                    {{Form::text('sku', $data->sku, array('class' => 'form-control'))}}
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('description', 'Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('description', $data->description, array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Star *</h5>
                                            <div class="row">
                                                @php
                                                    $stars = \App\Models\Features::where('type','star')->orderby('name','asc')->get();
                                                @endphp
                                                @foreach($stars as $star)
                                                    <div class="col-md-6">
                                                        <div class="radio">
                                                            {!! Form::radio('star_id', $star->oldID, ($data->star_id == $star->oldID) ? true:false,  ['id' => 'star_id_'.$star->id]) !!}
                                                            {{Form::label('star_id_'.$star->id, $star->name, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Property Types *</h5>
                                            <div class="row">
                                                @php
                                                    $categories = \App\Models\HotelCategories::all()->pluck('name','id');
                                                    $cats = $data->categories ;
                                                @endphp
                                                @foreach($categories as $id => $category)
                                                    <div class="col-md-3">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('categories[]', $id, !empty($cats) ? ((in_array($id,$cats)) ? true:false) :false,  ['id' => 'category_'.$id]) !!}
                                                            {{Form::label('category_'.$id, $category, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('property_checkin', 'Property check-in times *', array('class' => 'control-label'))}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{Form::label('property_checkin_hour', 'Hour *', array('class' => 'control-label'))}}
                                                    <select name="property_checkin" class="form-control">
                                                        <?php
                                                        for ($hours = 0; $hours < 24; $hours++)
                                                            echo '<option ' . (@$data['checkin'][0] == str_pad($hours, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    {{Form::label('property_checkin_minute', 'Minute *', array('class' => 'control-label'))}}
                                                    <select name="property_checkin2" class="form-control">
                                                        <?php
                                                        for ($mins = 0; $mins < 60; $mins += 5)
                                                            echo '<option ' . (@$data['checkin'][1] == str_pad($mins, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '">' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('property_checkout', 'Property check-out times *', array('class' => 'control-label'))}}

                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{Form::label('property_checkout_hour', 'Hour *', array('class' => 'control-label'))}}
                                                    <select name="property_checkout" class="form-control">
                                                        <?php
                                                        for ($hours = 0; $hours < 24; $hours++)
                                                            echo '<option ' . (@$data['checkout'][0] == str_pad($hours, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    {{Form::label('property_checkout_minute', 'Minute *', array('class' => 'control-label'))}}
                                                    <select name="property_checkout2" class="form-control">
                                                        <?php
                                                        for ($mins = 0; $mins < 60; $mins += 5)
                                                            echo '<option ' . (@$data['checkout'][1] == str_pad($mins, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '">' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5>Location</h5>
                                    <div class="form-group">
                                        <label for="address_address">Search Address</label>
                                        <input type="text" id="address-input" name="address_address"
                                                class="form-control map-input">
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
                                                {{Form::textarea('address', $data->address, array('class' => 'form-control','rows'=>5,'required'=>'required'))}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{Form::label('latitude', 'Latitude *', array('class' => 'control-label'))}}
                                                <input type="text" name="latitude" id="address-latitude"
                                                        class="form-control" value="{{$data->latitude}}"
                                                        required="required"/>
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('longitude', 'Longitude *', array('class' => 'control-label'))}}
                                                <input type="text" name="longitude" id="address-longitude"
                                                        class="form-control" value="{{$data->longitude}}"
                                                        required="required"/>
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
                                                {!! Form::select('country_id', $countries, $data->country_id, ['class' => 'selectize']) !!}
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('city', 'City *', array('class' => 'control-label'))}}
                                                {{Form::text('city', $data->city, array('class' => 'form-control','required'=>'required'))}}
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
                        <div class="card-collapsible" style="display:none;">
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
                                            @if ($group->name == "Meal Package" || $group->name == "Parking")
                                            <label class="control-label required"></label>
                                                @else
                                            <label class="control-label required">{{$group->name}}</label>
                                            @endif
                                            @php
                                                $features = $group->features()->get();
                                            @endphp
                                            <div class="row">
                                                @foreach($features as $feature)
                                                    <div class="col-md-3">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('features[]', $feature->id,$data->checkFeature($feature->id),  ['id' => 'features_'.$feature->id]) !!}
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
                                        <a href="javascript:void(0);" class="text-gray card-collapse-btn"
                                           data-toggle="card-collapse">
                                            <i class="mdi mdi-chevron-down font-size-20"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                {!! Form::checkbox('gift_for_migoda_guests', '1', $data->gift_for_migoda_guests,  ['id' => 'gift_for_migoda_guests']) !!}
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
                                                        @php
                                                            $check = \App\Models\HotelFeatures::where('hotel_id',$data->id)->where('feature_id',$gift->id)->get();
                                                        @endphp
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('gift[]', $gift->id, ($check->count() > 0) ? true:false,  ['id' => 'gift_'.$gift->id]) !!}
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
                                            {{Form::textarea('gift_description', $data->gift_description, array('class' => 'form-control mg-ckeditor'))}}
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
                            <h4 class="card-title">Property Types and board prices</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <h5>BOARD MEAL ALLOWANCE </h5>
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
                                                                    {!! Form::radio('board_food_allowance_id', $board_food_allowance->id, ($data->board_food_allowance_id == $board_food_allowance->id) ? true:false,  ['id' => 'board_food_allowance_id_'.$board_food_allowance->id]) !!}
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
                                            {{Form::label('property_description', 'Meal Package Description *', array('class' => 'control-label'))}}
                                            {{Form::textarea('property_description', $data->property_description, array('class' => 'form-control mg-ckeditor'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('property_checkin', 'Property check-in times *', array('class' => 'control-label'))}}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {{Form::label('property_checkin_hour', 'Hour *', array('class' => 'control-label'))}}
                                                            <select name="property_checkin" class="form-control">
                                                                <?php
                                                                for ($hours = 0; $hours < 24; $hours++)
                                                                    echo '<option ' . (@$data['checkin'][0] == str_pad($hours, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '</option>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{Form::label('property_checkin_minute', 'Minute *', array('class' => 'control-label'))}}
                                                            <select name="property_checkin2" class="form-control">
                                                                <?php
                                                                for ($mins = 0; $mins < 60; $mins += 5)
                                                                    echo '<option ' . (@$data['checkin'][1] == str_pad($mins, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '">' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('property_checkout', 'Property check-out times *', array('class' => 'control-label'))}}

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {{Form::label('property_checkout_hour', 'Hour *', array('class' => 'control-label'))}}
                                                            <select name="property_checkout" class="form-control">
                                                                <?php
                                                                for ($hours = 0; $hours < 24; $hours++)
                                                                    echo '<option ' . (@$data['checkout'][0] == str_pad($hours, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . '</option>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{Form::label('property_checkout_minute', 'Minute *', array('class' => 'control-label'))}}
                                                            <select name="property_checkout2" class="form-control">
                                                                <?php
                                                                for ($mins = 0; $mins < 60; $mins += 5)
                                                                    echo '<option ' . (@$data['checkout'][1] == str_pad($mins, 2, '0', STR_PAD_LEFT) ? 'selected' : null) . ' value="' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '">' . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::label('price', 'Price (in EUR, including tax) *', array('class' => 'control-label'))}}
                                            {{Form::text('price', $data->price, array('class' => 'form-control'))}}
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
                                                            {!! Form::radio('star_id', $star->oldID, ($data->star_id == $star->oldID) ? true:false,  ['id' => 'star_id_'.$star->id]) !!}
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
                                                    $cats = $data->categories;
                                                @endphp
                                                @foreach($categories as $id => $category)
                                                    <div class="col-md-3">
                                                        <div class="checkbox">
                                                            {!! Form::checkbox('categories[]', $id, !empty($cats) ? ((in_array($id,$cats)) ? true:false) :false,  ['id' => 'category_'.$id]) !!}
                                                            {{Form::label('category_'.$id, $category, array('class' => 'control-label'))}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $features_categories = \App\Models\FeatureCategories::orderby('name','asc')->get();
                                    @endphp
                                    @foreach($features_categories as $features_category)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>{{$features_category->name}} *</h5>
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
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

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
                        <div class="card-collapsible" style="display:none;">
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
                                                                    {!! Form::radio('board_food_allowance_id', $board_food_allowance->id, ($data->board_food_allowance_id == $board_food_allowance->id) ? true:false,  ['id' => 'board_food_allowance_id_'.$board_food_allowance->id]) !!}
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
                                            {{Form::text('price', $data->price, array('class' => 'form-control','required'=>'required'))}}
                                        </div>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Food & Drinks</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                @php
                                $features_categories = \App\Models\FeatureCategories::orderby('name','desc')->get();
                                @endphp
                                @foreach($features_categories as $features_category)
                                    @if ($features_category->name == "Food & Drinks")

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
                                    @endif
                                @endforeach
                                <div class="col-md-12">
                                    <h5>Gift for Migoda guests</h5>
                                    <div class="row">
                                        @php
                                            $gifts = \App\Models\Features::where('type','gift')->orderby('name','asc')->get();
                                        @endphp
                                        @foreach($gifts as $gift)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    @php
                                                        $check = \App\Models\HotelFeatures::where('hotel_id',$data->id)->where('feature_id',$gift->id)->get();
                                                    @endphp
                                                    <div class="checkbox">
                                                        {!! Form::checkbox('gift[]', $gift->id, ($check->count() > 0) ? true:false,  ['id' => 'gift_'.$gift->id]) !!}
                                                        {{Form::label('gift_'.$gift->id, $gift->name, array('class' => 'control-label'))}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Unavailable dates</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                {{Form::text('unavailable_dates',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd'])}}
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Photo gallery</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{Form::label('listing_image1', 'DESKTOP LISTING IMAGE (CROPS TO 200X170)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="imdlisting" data-preview="imdlisting_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="imdlisting" class="form-control" type="hidden" name="imdlisting" value="{{$data->imdlisting}}">
                                            </div>
                                            <div id="imdlisting_holder" class="lfm-image-holder">
                                                <img src="{{$data->imdlisting}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 200x170
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image2', 'DESKTOP DETAIL IMAGE (CROPS TO 1920X680)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="imddetail" data-preview="imddetail_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="imddetail" class="form-control" type="hidden" name="imddetail" value="{{$data->imddetail}}">
                                            </div>
                                            <div id="imddetail_holder" class="lfm-image-holder">
                                                <img src="{{$data->imddetail}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 1920x680
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image3', 'DESKTOP PAYMENT IMAGE (CROPS TO 630X130)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="imdcheckout" data-preview="imdcheckout_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="imdcheckout" class="form-control" type="hidden" name="imdcheckout" value="{{$data->imdcheckout}}">
                                            </div>
                                            <div id="imdcheckout_holder" class="lfm-image-holder">
                                                <img src="{{$data->imdcheckout}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 630x130
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image4', 'DESKTOP ON MAP IMAGE (CROPS TO 390X170)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="imdmap" data-preview="imdmap_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="imdmap" class="form-control" type="hidden" name="imdmap" value="{{$data->imdmap}}">
                                            </div>
                                            <div id="imdmap_holder" class="lfm-image-holder">
                                                <img src="{{$data->imdmap}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 390x170
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image5', 'MOBILE LISTING IMAGE (CROPS TO 630X190)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="immlisting" data-preview="immlisting_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="immlisting" class="form-control" type="hidden" name="immlisting" value="{{$data->immlisting}}">
                                            </div>
                                            <div id="immlisting_holder" class="lfm-image-holder">
                                                <img src="{{$data->immlisting}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 630x190
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image6', 'MOBILE DETAIL IMAGE (CROPS TO 750X590)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="immdetail" data-preview="immdetail_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="immdetail" class="form-control" type="hidden" name="immdetail" value="{{$data->immdetail}}">
                                            </div>
                                            <div id="immdetail_holder" class="lfm-image-holder">
                                                <img src="{{$data->immdetail}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 750x590
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('listing_image7', 'MOBILE PAYMENT IMAGE (CROPS TO 630X130)', array('class' => 'control-label'))}}
                                            <div class="input-group">
   <span class="input-group-btn">
     <a data-input="immcheckout" data-preview="immcheckout_holder" class="btn btn-default lfm_image_button">
       <i class="fa fa-picture-o"></i> {{trans('lfm.message-choose')}}
     </a>
   </span> <input id="immcheckout" class="form-control" type="hidden" name="immcheckout" value="{{$data->immcheckout}}">
                                            </div>
                                            <div id="immcheckout_holder" class="lfm-image-holder">
                                                <img src="{{$data->immcheckout}}"/>
                                            </div>
                                            <div class="alert alert-default">
                                                Recommended size: 630X130
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{Form::label('galery_label', 'Gallery Images', array('class' => 'control-label'))}}
                                    <div class="card">
                                        <div class="card-body galery-card">
                                            <div class="galery-area">
                                                <a href="javascript:void(0);" title="Add Gallery Images"
                                                   class="add-item btn btn-icon btn-success"><i
                                                        class="mdi mdi-plus-circle"></i></a>
                                                <div id="images-sortable"
                                                     class="images-sortable d-flex flex-center flex-wrap">
                                                    <?php
                                                    $items = $data->imgallery;
                                                    if($items != ""){
                                                    $items = unserialize(\App\Helpers::repairSerializeString($items));
                                                    if($items){
                                                    foreach ($items as $item){
                                                    ?>
                                                    <div class="image-item">
                                                        <input type="hidden" name="galeryItems[]" value="{{$item}}"><img
                                                            src="{{$item}}" alt=""><a href="javascript:void(0);"
                                                                                      class="remove-item btn btn-icon btn-rounded btn-default"><i
                                                                class="mdi mdi-delete"></i></a>
                                                    </div>
                                                    <?php
                                                    }
                                                    }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-default">
                                        Recommended size for gallery images: 1000X600
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border bottom">
                            <h4 class="card-title">Hotel Contact Person</h4>
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
                        <div class="card-collapsible" style="display:none;">
                            <div class="card-body">
                                <div class="form-group">
                                    {{Form::label('contact_person', 'Contact Person *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_person', $data->contact_person, array('class' => 'form-control'))}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('contact_email', 'Contact Email *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_email', $data->contact_email, array('class' => 'form-control'))}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('contact_phone', 'Contact Phone *', array('class' => 'control-label'))}}
                                    {{Form::text('contact_phone', $data->contact_phone, array('class' => 'form-control'))}}
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
            {{Form::close()}}</div>
    </div>
@endsection
