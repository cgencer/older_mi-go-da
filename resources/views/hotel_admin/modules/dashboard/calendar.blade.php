@extends('hotel_admin.layouts.master')@php
    $hotelUser = Auth::guard('user')->user();
@endphp
@section('title'){{trans('txt.calendar')}} | @parent @endsection
@section('page_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/fullcalendar/fullcalendar.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"/>
    <link href="{{asset('admin/assets/vendor/air-datepicker/dist/css/datepicker.min.css')}}" rel="stylesheet">
    <style>


        .datepicker--cell.-current- {
            background: #50c531;
            color: #fff;
            border-radius: 50%
        }

        .datepicker--cell.-selected-, .datepicker--cell.-selected-.-current- {
            color: #fff;
            background: #f16293;
            border-radius: 50%

        }

        .datepicker.active {
            box-shadow: 0 2px 20px rgba(96, 97, 112, 0.43);
            border-radius: 9px;
            background-color: #ffffff;
        }


        .btn-success {
            background-color: #95ba5b !important;
        }

        .btn-success.disabled, .btn-success:disabled {
            background-color: rgb(94, 93, 93) !important;
            border-color: rgb(94, 93, 93) !important;
        }

        .btn-danger.disabled, .btn-danger:disabled {
            background-color: rgb(94, 93, 93) !important;
            border-color: rgb(94, 93, 93) !important;
        }


        .fc-bgevent {
            background-color: rgb(94, 93, 93) !important;
            cursor: no-drop !important;
            color: #000;
        }

        .calendar-holder {
            background: #fff;
            border-radius: 10px;
        }

        .fc-today {
            background: #fff !important;
        }

        .fc-basic-view .fc-today .fc-day-number {
            padding: 0px 16px !important;
        }

        .swal2-styled.swal2-confirm {
            background-color: #fa3844 !important;
        }

        .swal2-title {
            font-weight: 300 !important;
        }

        #avalibale-button, #avalibale-button:disabled {
            height: 43px;

        }

        #blocked-button, #blocked-button:disabled {
            height: 43px;

        }


    </style>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/vendor/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/fullcalendar/locale/de.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/fullcalendar/locale/en-gb.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{asset('admin/assets/vendor/air-datepicker/dist/js/datepicker.min.js')}}"></script>
    <script
        src="{{ asset('admin/assets/vendor/air-datepicker/dist/js/i18n/datepicker.'.\Illuminate\Support\Facades\App::getLocale().'.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        jQuery(document).ready(function ($) {


            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var events = [
                    @foreach($reservations as $reservation)
                {
                    title: '{{ trans('txt.reservation_for') }} : {{ $reservation->guest_adult }} {{ trans('txt.adult') }} {{  $reservation->guest_child }} {{ trans('txt.child') }}',
                    start: '{{ $reservation->checkin_date }}',
                    end: '{{ $reservation->checkout_date }}',
                    id: '{{route('hotel_admin.reservations.show',['id'=>$reservation->id])}}',
                    numberOfRooms: '1',
                    bullet: 'danger',
                    display: 'background'
                },
                    @endforeach
                    @foreach($unavailableDates as $value)
                {
                    title: 'OFFLINE',
                    start: '{{ $value->date }}',
                    end: '{{ $value->date }}',
                    rendering: 'background',
                    color: '#ff9f89',
                    allDay: true
                },
                @endforeach

            ];
            $('#full-calendar').fullCalendar({
                locale: "{{\Illuminate\Support\Facades\App::getLocale()}}",
                firstDay: 1,
                height: 850,
                editable: false,
                header: {left: 'prev', center: 'title,month,agendaWeek,agendaDay,today', right: 'next'},
                selectable: false,
                selectHelper: false,

                locale: '{{\Illuminate\Support\Facades\App::getLocale()}}',
                select: function (start, end) {
                    $('.calendarModal').modal('show');
                },
                events: events,
                eventClick: function (calEvent, jsEvent, view) {
                    $('.calendarModal').modal('show');
                    $('.calendarModal').find('#title').val(calEvent.title);
                    $('.calendarModal').find('#numberOfRooms').val(calEvent.numberOfRooms);
                    $('.calendarModal').find('#calendar-start-date').val(calEvent.start.format('YYYY-MM-DD'));
                    $('.calendarModal').find('#calendar-end-date').val(calEvent.end.format('YYYY-MM-DD'));
                    $('.calendarModal').find('#resId').attr("href", calEvent.id);
                }
            });
        });

    </script>
    <script>
        $("#start_date").datepicker({
            firstDay: 1,
            language: '{{\Illuminate\Support\Facades\App::getLocale()}}',
            onSelect: function (dateText) {
                $('#due_date').removeAttr("disabled", false);
            }
        });
        $("#due_date").datepicker({
            firstDay: 1,
            language: '{{\Illuminate\Support\Facades\App::getLocale()}}',
            onSelect: function (dateText) {
                if ($('#start_date').val() == "") {
                    Swal.fire({
                        title: '',
                        text: 'Please select a start day',
                        confirmButtonText: '{{ trans('txt.ok') }}'
                    })
                    $("#due_date").datepicker({
                        language: '{{\Illuminate\Support\Facades\App::getLocale()}}',
                    });
                    return;
                }
                if (dateText < $('#start_date').val()) {
                    Swal.fire({
                        title: '',
                        text: 'End date cannot be less than the start date',
                        confirmButtonText: '{{ trans('txt.ok') }}'
                    })
                    $('#avalibale-button').attr("disabled", true);
                    $('#blocked-button').attr("disabled", true);
                    $("#due_date").val('');
                    return;
                } else {
                    $('#avalibale-button').removeAttr("disabled", false);
                    $('#blocked-button').removeAttr("disabled", false);
                }
            }
        });


    </script>
@endsection
@section('content')

    <div class="main-content">
        <div class="container-fluid">
            {{ Form::open(array('url' => route('hotel_admin.setUnavailableDates'))) }}
            <div class="row calendar-holder mb-2 p-20">
                <div class="col-6  ">
                    <strong class="d-block">{{trans('txt.calendar_form_title')}}</strong>
                    <span>{!! trans('txt.calendar_form_desc') !!}</span>
                </div>
                <div class="col-6  dates-col">
                    <div class="form-row">
                        <div class="col">
                            <label for="">{{trans('txt.field_start_date')}}</label>
                            <div class="icon-input fix-width">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('start_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'d-m-yyyy', 'placeholder' => trans('txt.field_start_date_placeholder'), 'id' => 'start_date', 'autocomplete' => 'off'])}}
                            </div>
                        </div>
                        <div class="col">
                            <label for="">{{trans('txt.field_end_date')}}</label>
                            <div class="icon-input fix-width">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('due_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'d-m-yyyy', 'placeholder' => trans('txt.field_end_date_placeholder'),'id' => 'due_date', 'disabled', 'autocomplete' => 'off'])}}
                            </div>
                        </div>
                        <div class="col">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-danger btn-block" id="blocked-button" disabled name="block"><i
                                    class="fa fa-ban"></i> {{trans('txt.hotel_calendar_block')}}
                            </button>
                        </div>
                        <div class="col">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-success btn-block" id="avalibale-button" disabled name="available"><i
                                    class="fa fa-check"></i> {{trans('txt.hotel_calendar_unblock')}}
                            </button>
                        </div>
                    </div>
                    {{-- <div class="form-row">
                        <div class="col">
                            <div class="icon-input">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('start_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd', 'placeholder' => 'Starting Date', 'id' => 'start_date'])}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="icon-input">
                                <i class="mdi mdi-calendar"></i>
                                {{Form::text('due_date',null,['class'=>'form-control multi-datepicker','data-date-format'=>'yyyy/mm/dd', 'placeholder' => 'Due Date','id' => 'due_date', 'disabled'])}}
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-success" style="float: right" id="avalibale-button" disabled name="available"> <i class="fa fa-check"></i> Available</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger"  id="blocked-button" disabled name="block"> <i class="fa fa-ban"></i> Blocked</button>

                        </div>
                      </div> --}}
                </div>

                {{Form::close()}}
            </div>
        </div>
        @include('admin.partials.notifications')
        <div id="full-calendar"></div>
        <div class="calendarModal modal fade" id="event-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header border bottom">
                        <h4 class="modal-title">{{ trans('txt.reservation_details') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row p-v-20">
                            <div class="col-sm-10 offset-sm-1">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('txt.summary') }}</label>
                                    <input type="text" class="form-control" id="title"
                                           placeholder="{{ trans('txt.summary') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('txt.number_of_rooms') }}</label>
                                    <input type="text" class="form-control" id="numberOfRooms"
                                           placeholder="{{ trans('txt.number_of_rooms') }}" disabled>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="calendar-start-date">{{ trans('txt.check_in') }}</label>
                                            <div class="icon-input">
                                                <i class="mdi mdi-calendar-clock"></i>
                                                <input type="text" class="form-control"
                                                       placeholder="{{ trans('txt.check_in') }}"
                                                       id="calendar-start-date" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="calendar-start-date">{{ trans('txt.check_out') }}</label>
                                            <div class="icon-input">
                                                <i class="mdi mdi-calendar-clock"></i>
                                                <input type="text" class="form-control"
                                                       placeholder="{{ trans('txt.check_out') }}" id="calendar-end-date"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 text-left"></div>
                                            <div class="col-md-6 text-right">
                                                <a href="#" class="btn btn-info"
                                                   id="resId"> {{ trans('Show Details') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
