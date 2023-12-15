@extends('front.layouts.master')
@section('title') {{ trans("txt.account_settings_title") }} @parent @endsection
@section('styles')

@endsection
@section('body')
    <div class="page-profile page-two-column">
        <div class="page-profile-inner  mg-section mg-group page-two-column-inner">
            @include('front.partials.profile-menu')
            <div class="listing_wrapper two-column-right">
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
                        <div class="delete-account">
                            <a class="delete-account-link" href="#" data-toggle="modal" data-target="#deleteAccountModal"><i class="fas fa-sliders-h-square"></i> {{ trans('txt.delete_account_button') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteAccountModalTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body text-center">
               <h3 style="font-size:25px">{{trans('txt.delete_account_modal_title')}}</h3>
               <p>{{trans('txt.delete_account_modal_desc')}}</p>
               <div class="listing_wrapper two-column-right text-center">
                   <div class="profile-form generic-form generic-form-smaller-text">
                       <form action="{{route('auth.delete-account')}}" method="post">
                           <div class="form-input form-input-double delete-account-input">
                               <div>
                                   {!! Form::password('password_confirmation', ['placeholder' => "Confirm Password", 'required' => "required"]) !!}
                               </div>
                           </div>
                       @csrf
                   </div>
               </div>
           </div>
           <div class="modal-footer delete-modal-footer text-center">
               <button type="submit"
                       class="handButton mg-primary-button">{{trans('txt.delete_account_modal_delete_btn')}}</button>
           </div>
           </form>
       </div>
   </div>
</div>

@endsection
