@extends('front.layouts.master')
@section('title') {{ trans("txt.account_settings_title") }} @parent @endsection
@section('styles')

@endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <h1>{{ trans('txt.profile_language_settings') }}</h1>
                <div class="profile-form generic-form generic-form-smaller-text">
                    @include('front.partials.alert')
                    <form action="{{route('auth.language.save')}}" method="post">
                        @csrf
                        <h4>{{ trans('txt.profile_language_settings_desc') }}</h4>
                        <br>
                        <div class="form-group">
                            {!! Form::select('language', \Illuminate\Support\Facades\Config::get('languages') , $user->language , ['class' => 'select2 form-control']) !!}
                        </div>

                        <div class="form-group">
                            <button type="submit"  class="mg-primary-button handButton">{{ trans('txt.save_button') }}
                                <i class="fa fa-long-arrow-alt-right"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascripts')
    <script>
        $('.select2').select2();
    </script>
@endsection
