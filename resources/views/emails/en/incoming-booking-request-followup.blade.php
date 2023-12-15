@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">ALERT! - MIGODA/ <br> INCOMING BOOKING REQUEST REMINDER</h1>
                <p class="strong">Dear Hotel Partner!</p> <br>
                <p class="strong">We have sent you an email 24 hours ago - to which
                    you have not responded yet.</p> <br>
                <p>Mr(s) {{ $name }} has sent a booking request to stay at your hotel for
                    the following dates: {{ $checkin }} to {{ $checkout }} . The meal
                    allowance you displayed through the Migoda Extranet includes
                    Half-Board with a daily price of &euro; {{ $price }}/ per person.</p> <br>
                <p>
                    The meal package you displayed through the Migoda Extranet includes half-board with a daily price of {{ $price }}/ per person.
                </p> <br>
                <p>According to your managed calendar in your Extranet account you
                    show these dates available.</p> <br>
                <p>Please accept the booking - if you have availability and would
                    like to take these guests on!</p> <br>
                <p>If your house is full - or at this point Migoda guests can not
                    come for whatever reason - please decline.</p> <br>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                        valign="middle"><a href="{{ $route }}" class="main-button"
                                        target="_blank">Accept / Decline</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:15px 30px;padding-top:30px;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                {{-- <p class="note-text-red">* You have 24 hours to respond!</p> --}}
                <p class="note-text">
                    * You have 24 hours to respond! <br>
                    A prompt response helps guests finalize their
                    trip and look forward coming to your house. If you don’t
                    respond to booking request within 24 hours you will lose this
                    guest/business opportunity.</p>
            </div>
        </td>
    </tr>

    @endsection

