@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">GUEST <br> CANCELLATION</h1>
                <p class="strong">Dear Migoda Hotel Partner!</p>
                <p>Unfortunately we received a cancellation request from Mr(s) {{ $guest}}
                    past the free cancellation request period of 48 hours prior to
                    guest arrival. The guests are not coming to your house on the
                    reserved dates {{ $checkin}} to {{ $checkout }} .</p> <br>
                <p>Please update your in-house reservation overview and delete this
                    booking from it.</p> <br>
                <p>Since the cancellation is past the free cancellation period the
                    payment has been secured and - <span class="strong">Good news!</span>
                    ...</p> <br>
                <p>We will issue your payout shortly of {{ $amount}} and is due to
                    arrive to your account on {{ $refund}}.</p> <br>
                <p>Taking in the consideration of weekends and holidays it might
                    arrive due to banking hours afterwards.</p> <br><br>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#ffffff" role="presentation"
                        class="main-button-holder-bg"
                        valign="middle"><a href="{{ $url}}"
                                        class="main-button-bg"
                                        target="_blank">Overview of Earnings</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <p>(MINUS THE 18,5% MIGODA COMMISION)</p>
                {{-- <p>If you have any questions regarding your payouts and fees,
                    please contact <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a> --}}
                </p>
            </div>
        </td>
    </tr>

    @endsection

