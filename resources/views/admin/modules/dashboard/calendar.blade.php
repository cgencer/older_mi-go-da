@extends('admin.layouts.master')@php
    $admin = Auth::guard('admin')->user();
@endphp
@section('title')Calendar | @parent @endsection
@section('page_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/fullcalendar/fullcalendar.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/vendor/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
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
                    id: '{{route('admin.reservations.show',['id'=>$reservation->id])}}',
                    edit: '{{route('admin.reservations.edit',['id'=>$reservation->id])}}',
                    numberOfRooms: '1',
                    bullet: 'danger'
                },
                @endforeach
            ];
            $('#full-calendar').fullCalendar({
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
                    $('.calendarModal').find('#res-edit').attr("href", calEvent.edit);
                }
            })

            $('#calendar-start-date').datepicker();
            $('#calendar-end-date').datepicker();
        });
    </script>
@endsection
@section('content')
    <div class="main-content">
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
                                    <input type="text" class="form-control" id="title" placeholder="{{ trans('txt.summary') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ trans('txt.number_of_rooms') }}</label>
                                    <input type="text" class="form-control" id="numberOfRooms" placeholder="{{ trans('txt.number_of_rooms') }}" disabled>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="calendar-start-date">{{ trans('txt.check_in') }}</label>
                                            <div class="icon-input">
                                                <i class="mdi mdi-calendar-clock"></i>
                                                <input type="text" class="form-control" placeholder="{{ trans('txt.check_in') }}" id="calendar-start-date" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="calendar-start-date">{{ trans('txt.check_out') }}</label>
                                            <div class="icon-input">
                                                <i class="mdi mdi-calendar-clock"></i>
                                                <input type="text" class="form-control" placeholder="{{ trans('txt.check_out') }}" id="calendar-end-date" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 text-left"></div>
                                            <div class="col-md-6 text-right">
                                                <a href="#" class="btn btn-warning" id="res-edit"> {{ trans('Edit') }}</a>
                                                <a href="#" class="btn btn-info" id="resId"> {{ trans('Show Details') }}</a>
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
