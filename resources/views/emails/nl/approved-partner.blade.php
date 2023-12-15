@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">APPROVAL <br> CONFIRMATION</h1>
            <p class="strong">Dear Migoda Hotel Partner!</p>
            <p>We have received from you your acceptance for Mr(s) {{ $name }}’s booking
                request with the dates {{ $checkinCustomer }} to {{ $checkoutCustomer }}. We have communicated this
                acceptance already to Mr(s) {{ $name }} through our system.</p> <br>
            <p>We are delighted! So is the guest!</p> <br>
            <p>Within the next 48 hours you will receive another email from us
                informing you about the customers payment for the times
                requested.</p> <br>
            <p>We will keep you posted!.. stay tuned!</p>
            <p>Kind regards,</p> <br> <br>
            <p style="font-weight: 600">Your Migoda Team</p>  <br><br>
        </div>
    </td>
</tr>

    @endsection

