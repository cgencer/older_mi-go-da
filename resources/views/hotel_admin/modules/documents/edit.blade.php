@extends('hotel_admin.layouts.master')
@section('title')
{{trans('txt.edit_document_title')}} | {{ $document->id }} @parent
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
                @if ($document->status == 3)
                <h2 class="header-title">{{trans('txt.edit_document_sub_title1')}}</h2>
                @else
                <h2 class="header-title">{{trans('txt.edit_document_sub_title2')}}</h2>
                @endif
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
                     @if ($document->status == 2)
                     <div class="warning-reject">
                        <span class="badge badge-danger"> <i class="fa fa-times"></i> The Document Was Rejected at: {{ $document->updated_at->format('d-m-Y H:i:s') }} From Admin </span> <br> <br>
                        <label for="">{{trans('txt.field_reject_reason')}}</label>
                        <textarea name="" id="" readonly class="form-control font-size-20" cols="10" rows="3">{{ $document->reject_reason }}</textarea>
                    </div>
                     @endif
                    {{ Form::open(array('url' => route('hotel_admin.documents.update', ['id'=>$document->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
                    <div class="form-group docs-type">
                        {{Form::label('type', trans('txt.add_document_field_type'), array('class' => 'control-label'))}} <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{ $document->type == 1 ? "checked": "" }} type="radio" name="type" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">{{ trans('txt.add_document_type_service') }}</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ $document->type == 2 ? "checked": "" }} type="radio" name="type" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">{{ trans('txt.add_document_type_commercial') }}</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ $document->type == 3 ? "checked": "" }} type="radio" name="type" id="inlineRadio3" value="3" >
                            <label class="form-check-label" for="inlineRadio3">{{ trans('txt.add_document_type_insurance') }}</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{ $document->type == 4 ? "checked": "" }} type="radio" name="type" id="inlineRadio4" value="4" >
                            <label class="form-check-label" for="inlineRadio4">{{ trans('txt.add_document_type_other') }}</label>
                          </div>
                    </div>
                    <div class="row form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{ $document->id }}" name="id" >
                                {{Form::label('name', trans('txt.edit_document_field_title'), array('class' => 'control-label'))}}
                                {{Form::text('name',  $document->name, array('class'=>'form-control','autocomplete'=>'off', 'required'=>'required',))}}
                            </div>
                            <div class="form-group">
                                {{Form::label('description', trans('txt.edit_document_field_description'), array('class' => 'control-label'))}}
                                {{Form::text('description', $document->description, array('class'=>'form-control','autocomplete'=>'off', 'required'=>'required',))}}
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
                                {{Form::select('type', $type, $document->type , ['class' => 'selectize', 'required'=>'required', 'id' => 'type'])}}
                            </div> --}}
                            <div class="form-group">
                                @if ($document->status != 3)
                                <div class="form-group documents-file-input">
                                    {{Form::label('document', trans('txt.add_document_field_document'), array('class' => 'control-label'))}}
                                    {{-- <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple required> --}}
                                    <div class="custom-file">
                                        <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple required class="custom-file-input" id="customFileLang" lang="en">
                                        <label class="custom-file-label" for="customFileLang">Select Documents</label>
                                      </div>
                                      <span>{{ trans('txt.title_accepted_file_formats') }}: JPG, JPEG, PNG, PDF, CSV, XLX, XLXS, TXT, DOCX</span>
                                </div>
                                @endif
                                <div class="form-group ">
                                    @if ($document->status == 3)
                                     {{Form::label('file', trans('txt.edit_document_field_created_by_admin'),  array('class' => 'control-label'))}}
                                    @else
                                     {{Form::label('file', trans('txt.edit_document_field_created'),  array('class' => 'control-label'))}}
                                    @endif
                                    {{ $document->created_at->format('d-m-Y H:i:s') }} <br>
                                    {{Form::label('file', trans('txt.edit_document_field_documents'),  array('class' => 'control-label', 'required'=>'required'))}}
                                </div>
                                <div class="img-holder text-center">
                                    <div class="row">
                                        @if ($document->files)
                                            @foreach ($document->files as $item)
                                                <div class="col-2 mt-2">
                                                    <strong>{{trans('txt.edit_document_field_file')}} {{ $item->filename.'.'.$item->extension }}  </strong> <br>
                                                    <a class="btn btn-sm btn-download" download="{{  $item->getUrl() }}"  href="{{  $item->getUrl() }}" > <i class="fa fa-download"></i> {{ trans('txt.title_file_download') }}</a>
                                                    <a class="btn btn-sm btn-eye"  target="_blank" href="{{  $item->getUrl() }}" > <i class="fa fa-eye"></i> {{ trans('txt.title_file_preview') }}</a>
                                                </div>
                                            @endforeach
                                        @endif
                                     </div>
                                </div>
                                @if ($document->status == 3)
                                <div class="form-group mt-5">
                                    <label for="reject_reason">{{trans('txt.edit_document_comment_admin')}}</label>
                                    <textarea  readonly  class="form-control"  cols="20" rows="5">{{ $document->comment }}</textarea>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                @if ($document->status != 3 || $document->status != 1)
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        {!! Form::hidden('submitted', '1') !!}
                                        <button type="submit" class="btn btn-gradient-success">{{trans('txt.link_submit')}}</button>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        <a href="{{route('hotel_admin.documents.index')}}" class="btn btn-gradient-success"> <i class="fa fa-chevron-left"></i> {{trans('txt.back_to_documents')}}</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
