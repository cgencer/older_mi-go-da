@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_profile')}} @parent @endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right profile-page-wrapper">
                <h1>{{ trans('txt.title_edit_profile_picture') }}</h1>
                <div class="profile-form generic-form generic-form-smaller-text">
                    @include('front.partials.alert')
                    <form action="{{route('auth.postProfile')}}" method="post" id="form_post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row profile-img-area">
                            <div class="col-3">
                                @if ($user->profile_image == null)
                                    <img class="user-profile-pic" id="profile_picture_display" width="188"
                                         src="{{ asset('front/assets/images/avatars/default_avatar.png') }}" alt="">
                                @else
                                    <img class="user-profile-pic" id="profile_picture_display" width="188"
                                         src="{{ $user->profile_image->getUrl() }}" alt="">
                                @endif
                                <input type="file" onchange="readFileInput(this);"
                                       accept="image/png, image/jpeg, image/jpg, image/bmp" name="profile_picture"
                                       class="d-none" id="profile_picture_input">
                            </div>
                            <div class="col-9">
                                <p>{{trans('txt.title_upload_profile_photo')}}. <br> {{trans('txt.title_accepted_file_formats')}}: jpg, png, jpeg, bmp. {{trans('txt.title_maximum_filesize')}}2MB</p>
                                <div class="form-actions form-actions-inline">
                                    <button type="button" onclick="openFile()"
                                            class="mg-primary-button handButton user-profile-pic-save">{{ trans('txt.title_upload_profile_photo') }}
                                        <i class="fa fa-arrow-right submit-arrow"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::hidden('customerID',  Auth::guard('customer')->id(), ['id' => 'customerID']) !!}
                        <hr>
                        <h1>{{ trans('txt.title_edit_profile') }}</h1>

                        <div class="form-elements">
                            <div class="form-input form-input-triple ">
                                <div>
                                    {!! Form::text('firstname', $user->firstname, ['placeholder'=>trans('txt.field_firstname')]) !!}
                                </div>
                            </div>
                            <div class="form-input form-input-triple form-lastname-phone">
                                <div>
                                    {!! Form::text('lastname', $user->lastname, ['placeholder'=>trans('txt.field_lastname')]) !!}
                                </div>
                            </div>
                            <div class="form-input form-input-triple form-date-of-birth">
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
                                        }
                                    @endphp
                                    <div id="user_dateOfBirth">
                                        <div>
                                            {!! Form::select('month', ['1'=> trans('txt.January'),'2'=>  trans('txt.February'),'3'=> trans('txt.March'),'4'=>  trans('txt.April'),'5'=>  trans('txt.May'),'6'=>  trans('txt.June'),'7'=>  trans('txt.July'),'8'=> trans('txt.August'),'9'=>  trans('txt.September'),'10'=>  trans('txt.October'),'11'=>  trans('txt.November'),'12'=>  trans('txt.December')] , $month , ['class' => 'select2 form-control']) !!}
                                        </div>
                                        <div>
                                            {!! Form::select('day', $days , $day , ['class' => 'select2 form-control']) !!}
                                        </div>
                                        <div>
                                            {!! Form::select('year', $years , $year , ['class' => 'select2 form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-input waiting-filter form-input-triple form-countries">
                                <div>
                                    @php
                                        $prefixes = [];
                                        $prefix = 0;
                                        $set = \App\Models\Countries::whereRaw('name <> ""')->whereRaw('iso3 <> ""')->orderBy('name')->pluck('name', 'iso3');
                                        $set = json_decode(json_encode($set), true);
                                        $set = collect(['' => trans('txt.please_select_a_country')] + $set);
                                    @endphp
                                    {!! Form::select('country', $set->toArray(), $user->country ? $user->country : '', ['class' => 'select2 form-control', 'required'=>'required','data-dropdownCssClass'=>'country-select2','data-placeholder'=>trans('txt.please_select_a_country')]) !!}
                                </div>
                            </div>
                            <div class="form-input form-input-triple form-lastname-phone">
                                <div class="phone-container">
                                    <input type="tel" class="phone1" id="PhoneNumber1" style="visibility:hidden" name="prefix" value="{{ $user->prefix }}">
                                    <input type="tel" class="phone2" id="PhoneNumber2" name="phone" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="form-input form-input-triple form-gender">
                                <div>
                                    {!! Form::select('gender', [''=>trans('txt.select_gender'),'m' => trans('txt.Male'),'f' => trans('txt.Female')],$user->gender, ['class' => 'select2 form-control', 'required' => 'required', 'data-placeholder' => trans('txt.select_gender')]) !!}
                                </div>
                            </div>
                            <div class="form-actions form-actions-inline">
                                <button onclick="addCroppedImage()"
                                        class="mg-primary-button handButton">{{ trans('txt.save_button') }}
                                    <i class="fa fa-arrow-right submit-arrow"></i>
                                </button>
                            </div>
                        {!! Form::hidden('submitted', 1) !!}
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    @php
   $code = null;
    if(!empty($user->prefix)) {
        $country = \App\Models\Countries::where('prefix', '=', $user->prefix)->get()->first();
        $code = $country['code'];
    }
    @endphp
@endsection
@section('stylesheets')
    <link href="{{ asset('front/assets/css/croppie.css').((config('app.debug'))?'?v='.time():'') }}" rel="stylesheet"
          media="all">
    <style>
        .country-select2 {
            font-weight: 300 !important;
            font-size: 4
        }
    </style>
@endsection
@section('javascripts')
    <script src="{{ asset('front/assets/js/croppie.js').((config('app.debug'))?'?v='.time():'') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

        $('.select2').select2();

        function addCroppedImage() {
            $('#profile_picture_display').on('update.croppie', function (ev, data) {
                // console.log('jquery update', ev, data);
            });
            $('#profile_picture_display').croppie('result', {
                type: 'rawcanvas',
                circle: true,
                // size: { width: 300, height: 300 },
                format: 'png'
            }).then(function (canvas) {
                $('#form_post').append('<input type="hidden" name="cropped_image" value="' + canvas.toDataURL() + '" />')
            });
        }


        function openFile() {
            $('#profile_picture_input').trigger('click');
        }

        function readFileInput(input) {
            if (input.files[0].size > 2097152) {
                Swal.fire({
                    title: '',
                    text: '{{ trans('txt.title_file_too_big') }}',
                    icon: 'info',
                    confirmButtonText: '{{ trans('txt.ok') }}'
                })
            } else {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile_picture_display').croppie({
                            enableExif: true,
                            viewport: {
                                width: 150,
                                height: 150,
                                type: 'circle'
                            },
                            boundary: {
                                width: 150,
                                height: 150
                            },
                            url: e.target.result,
                            // enforceBoundary: false
                            mouseWheelZoom: true
                        });
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
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
                            var input = document.querySelector("#PhoneNumber1");

                               // initialize intl-tel-input
                               $("#PhoneNumber1").intlTelInput({
                                 initialCountry: "de",
                                 autoPlaceholder: "aggressive",
                                 utilsScript: "https://raw.githack.com/jackocnr/intl-tel-input/master/build/js/utils.js",
                                   separateDialCode: true
                               });
                               // initialize the mask
                               initMasking("#PhoneNumber1", "#PhoneNumber2");

                               @if($code != null)
                            //Set Country Flag
                            var iso2 = "{{ $code }}";

                            if(iso2 !== null && iso2!== undefined){

                            $("#PhoneNumber1").intlTelInput("setCountry",iso2);
                       }

                       @endif

                               // update the mask format when changing country
                               $("#PhoneNumber1").on("countrychange", function (e, countryData) {
                                   $(this).val('');
                                   $("#PhoneNumber2").val('');

                                   // update the mask
                                   initMasking(this, "#PhoneNumber2");
                                });
                                $(".generic-form").submit(function() {
                                    $("#PhoneNumber1").val($("#PhoneNumber1").intlTelInput("getSelectedCountryData").dialCode);
                                });
        })(jQuery);
    </script>
@endsection
