@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GUEST CANCELLATION</h1>
            <p class="strong">Dear Migoda Hotel Partner!</p>
            <p>Unfortunately we received a cancellation request from Mr(s) [[ guest_name ]]
                within the free cancellation request period. The guest(s) are
                not coming to your house on the reserved dates [[ date_checkin ]] to [[ date_checkout ]].</p>
            <p>Please update your in-house reservation overview and delete this
                booking from it.</p>
            <p>Thank you!</p>
            <p>Kind regards,</p>
            <p>Your Migoda Team</p>
        </div>
    </td>
</tr>
    @endsection

