@extends('hotel_admin.layouts.master')
@section('title')
{{trans('txt.add_document_title')}} | @parent
@endsection
@section('page_styles')
    <link href="{{asset('admin/assets/vendor/selectize/dist/css/selectize.default.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/vendor/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/selectize/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-mask/dist/jquery.mask.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function readFileInput(input) {
            if (input.files[0].size > 2097152) {
                Swal.fire({
                    title: '',
                    text: '{{ trans('txt.title_file_too_big', ["size" => "2MB"]) }}',
                    icon: 'info',
                    confirmButtonText: '{{ trans('txt.ok') }}'
                })
                $('#file').val("")
            }
        }
    </script>
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <h2 class="header-title">{{trans('txt.add_document_title')}}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('hotel_admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>{{trans('txt.link_home')}}</a>
                        <a class="breadcrumb-item" href="{{route('hotel_admin.documents.index')}}">{{trans('txt.admin_menu_documents')}}</a>
                        <span class="breadcrumb-item active">{{trans('txt.link_add_document')}}</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    @include('hotel_admin.modules.documents.alert-documents')
                    {{ Form::open(array('url' => route('hotel_admin.documents.store', ['id'=> 0]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="row form-row">
                        <div class="col-md-12">
                            <div class="form-group docs-type">
                                {{Form::label('type', trans('txt.add_document_field_type'), array('class' => 'control-label'))}} <br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" checked name="type" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">{{ trans('txt.add_document_type_service') }}</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">{{ trans('txt.add_document_type_commercial') }}</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="inlineRadio3" value="3" >
                                    <label class="form-check-label" for="inlineRadio3">{{ trans('txt.add_document_type_insurance') }}</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="inlineRadio4" value="4" >
                                    <label class="form-check-label" for="inlineRadio4">{{ trans('txt.add_document_type_other') }}</label>
                                  </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" value="">
                                {{Form::label('name', trans('txt.add_document_field_title'), array('class' => 'control-label'))}}
                                {{Form::text('name', null,array('class'=>'form-control','autocomplete'=>'off', 'required' => true))}}
                            </div>
                            <div class="form-group">
                                {{Form::label('description', trans('txt.add_document_field_description'), array('class' => 'control-label'))}}
                                {{Form::text('description', null,array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                            {{-- <div class="form-group">
                                @php
                                    $type = [
                                        "1" => trans('txt.add_document_type_service'),
                                        "2" => trans('txt.add_document_type_commercial'),
                                        "3" => trans('txt.add_document_type_insurance'),
                                        "4" => trans('txt.add_document_type_other'),
                                    ]
                                @endphp
                                {{Form::label('type', trans('txt.add_document_field_type'), array('class' => 'control-label'))}}
                                {{Form::select('type', $type, 1 , ['class' => 'selectize', 'required'=>'required', 'id' => 'type'])}}
                            </div> --}}
                            <div class="form-group documents-file-input">
                                {{Form::label('document', trans('txt.add_document_field_document'), array('class' => 'control-label'))}}
                                {{-- <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple required> --}}
                                <div class="custom-file">
                                    <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple required class="custom-file-input" id="customFileLang" lang="en">
                                    <label class="custom-file-label" for="customFileLang">Select Documents</label>
                                  </div>
                                  <span>  {{ trans('txt.title_accepted_file_formats') }}: JPG, JPEG, PNG, PDF, CSV, XLX, XLXS, TXT, DOCX</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        {!! Form::hidden('submitted', '1') !!}
                                        <button type="submit" class="btn btn-gradient-success">{{trans('txt.link_submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection




