@extends('admin.layouts.master')
@section('title')
    Edit Document | {{ $document->id }} @parent
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
                <h2 class="header-title">Document of {{ $hotelInformation->name }}</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
                        <a class="breadcrumb-item" href="{{route('admin.documents.index')}}">Documents</a>
                        <span class="breadcrumb-item active">Add Document</span>
                    </nav>
                </div>
            </div>
            @include('admin.partials.notifications')
            <div class="card">
                <div class="card-body">
                    @if ($document->updated_at != null)
                        <?php $date = $document->updated_at->format('d-m-Y H:i:s');;
                              $label = "Updated Requestion:";
                        ?>
                        @else
                        <?php $date = $document->created_at;
                           $label = "Requestion At";
                        ?>
                    @endif
                    {{Form::label('created_at', $label,  array('class' => 'control-label'))}}
                    {{ $date.' | ' }}
                        @if ($document->creator == 'ADMIN' )
                           <strong>{{ 'Created By Admin For - '.$hotelInformation->name  }}</strong>

                            @else
                                 <strong>{{ 'From: '.$hotelInformation->name }}</strong>

                        @endif
                    {{ Form::open(array('url' => route('admin.documents.update', ['id'=>$document->id]), 'method'=>'post', 'files' => true,'class'=>'m-t-15', 'autocomplete'=>'off')) }}
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
                                <input type="hidden" name="userID" value="{{ $document->userID }}"  >
                                {{Form::label('name', 'Title', array('class' => 'control-label'))}}
                                {{Form::text('name',  $document->name, array('class'=>'form-control','autocomplete'=>'off', 'required'=>'required',))}}
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description', array('class' => 'control-label'))}}
                                {{Form::text('description', $document->description, array('class'=>'form-control','autocomplete'=>'off'))}}
                            </div>
                            {{-- <div class="form-group">
                                @php
                                    $type = [
                                        "1" => trans('txt.add_document_type_service'),
                                        "2" => trans('txt.add_document_type_insurance'),
                                        "3" => trans('txt.add_document_type_other'),
                                    ]
                                @endphp
                                {{Form::label('type', trans('txt.add_document_field_type'), array('class' => 'control-label'))}}
                                {{Form::select('type', $type, $document->type , ['class' => 'selectize', 'required'=>'required', 'id' => 'type'])}}
                            </div> --}}
                            <div class="form-group">
                                {{Form::label('document', trans('txt.add_document_field_document'), array('class' => 'control-label'))}}
                                {{-- <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple required> --}}
                                <div class="custom-file">
                                    <input type="file"  name="file[]" id="file" onchange="readFileInput(this);" multiple class="custom-file-input" id="customFileLang" lang="en">
                                    <label class="custom-file-label" for="customFileLang">Select Documents</label>
                                  </div>
                                  <span>{{ trans('txt.title_accepted_file_formats') }}: JPG, JPEG, PNG, PDF, CSV, XLX, XLXS, TXT, DOCX</span>
                                <div class="form-group ">
                                    {{Form::label('file', 'Document Preview',  array('class' => 'control-label'))}}
                                </div>
                                <div class="img-holder text-center">
                                    <div class="row">
                                        @if ($document->files)
                                            @foreach ($document->files as $item)
                                                <div class="col-2 mt-2">
                                                    <strong>File: {{ $item->filename.'.'.$item->extension }}  </strong> <br>
                                                    <a class="btn btn-sm btn-download" download="{{  $item->getUrl() }}"  href="{{  $item->getUrl() }}" > <i class="fa fa-download"></i> Download</a>
                                                    <a class="btn btn-sm btn-eye"  target="_blank" href="{{  $item->getUrl() }}" > <i class="fa fa-eye"></i> Preview</a>
                                                </div>
                                            @endforeach
                                        @endif
                                     </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @if ($document->status == 3)
                                <label for="reason">This is a local document</label>

                                @else
                                <label for="reason">Document Status</label>
                                <select name="status" class="form-control" id="">
                                    <option {{  $document->status == 0 ? 'selected' : '' }} value="0">Keep Pending</option>
                                    <option {{  $document->status == 1 ? 'selected' : '' }} value="1">Approve Document</option>
                                    <option {{  $document->status == 2 ? 'selected' : '' }} value="2">Reject Document</option>
                                    <option {{  $document->status == 3 ? 'selected' : '' }} value="3">{{trans('txt.local_document_title')}}</option>
                                </select>
                                @endif
                            </div>
                            @if ($document->status == 3)
                            <div class="form-group">
                                {{Form::label('type', 'Hotel: ', array('class' => 'control-label'))}}
                                {!! Form::select('hotel', $new_hotels, $document->hotelId, ['class' => 'selectize', 'required'=>'required', 'id' => 'hotels_select']) !!}
                            </div>
                            @endif
                            <div class="form-group">
                                <div class="checkbox p-0">
                                    <input id="selectable1" type="checkbox" {{  $document->hotel_preview == 1 ? 'checked' : '' }}  name="hotel_preview">
                                    <label for="selectable1">Hotel Preview</label>
                                </div>
                           </div>
                            <div class="form-group">
                                <label for="comment">Give a comment for document (Reason for why us add this document)</label>
                                <textarea name="comment" class="form-control" id="" cols="20" rows="5">{{ $document->comment }}</textarea>
                            </div>
                            @if ($document->status != 3)
                                <div class="form-group">
                                    <label for="reject_reason">Give a reason for document why it was rejected (Can only see hotels)</label>
                                    <textarea name="reject_reason" class="form-control"  id="" cols="20" rows="5">{{ $document->reject_reason }}</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="p-h-15">
                                <div class="form-group">
                                    <div class="text-sm-right">
                                        {!! Form::hidden('submitted', '1') !!}
                                        <button type="submit" class="btn btn-gradient-success">Save Document</button>
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
