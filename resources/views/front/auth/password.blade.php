@extends('front.layouts.master')
@section('title') {{trans('txt.page_title_profile')}} @parent @endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
                <a class="profile-settings-link" href="{{route('auth.account-settings')}}"><i class="fas fa-sliders-h-square"></i> Settings</a>
                <h1>{{ trans('txt.title_change_password') }}</h1>
                <div class="profile-form generic-form generic-form-smaller-text">
                    @include('front.partials.alert')
                    <form action="{{route('auth.password')}}" method="post">
                        <div class="form-input form-input-double">
                            <div>
                                {!! Form::password('oldPassword', ['placeholder' => trans('txt.field_old_password')]) !!}
                            </div>
                        </div>
                        <div class="form-input form-input-double">
                            &nbsp;
                        </div>
                        <div class="form-input form-input-double">
                            <div>
                                {!! Form::password('password', ['placeholder' => trans('txt.field_new_password')]) !!}
                            </div>
                        </div>
                        <div class="form-input form-input-double">
                            &nbsp;
                        </div>
                        <div class="form-input form-input-double">
                            <div>
                                {!! Form::password('password_confirmation', ['placeholder' => trans('txt.field_new_password_repeat')]) !!}
                            </div>
                        </div>
                        <div class="form-input form-input-double">
                            &nbsp;
                        </div>
                        <div class="form-actions form-actions-inline">
                            <button type="submit"
                                    class="mg-primary-button handButton">{{ trans('txt.update_password_button') }}
                                <i class="fa fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
