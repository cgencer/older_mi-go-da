@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">INCOMING <br> BOOKING REQUEST</h1>
            <p class="strong">Dear Migoda Hotel Partner!</p>
                Mr(s) {{ $name }} has sent a booking request to stay at your hotel for the following dates: {{ $checkin }} to {{ $checkout }}. <br>
                The meal package you displayed through the Migoda Extranet includes half-board with a daily price of  {{ $price }} per person.
            </p>
            <p>According to your managed calendar in your Extranet account you
                show these dates available.</p> <br>
            <p>Please accept the booking - if you have availability and would
                like to take these guests on!</p> <br>
            <p>If your house is full, or at this point Migoda guests can't be accepted for whatever reason please decline this booking.</p>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:50px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                    valign="middle"><a href="{{ $route }}"  class="main-button"  target="_blank">Accept / Decline</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text">
                * You have 24 hours to respond! <br>
                A prompt response helps guests to pay and finalize their trip and look forward coming to your house. If you don’t respond to Mr. {{ $name }} booking request within 48 hours you will lose this guest/business opportunity.</p>
        </div>
    </td>
</tr>

    @endsection

