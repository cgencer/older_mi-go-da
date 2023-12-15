@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">CONFIRMATION OF <br> DECLINE</h1>
                <p class="strong">Dear Migoda Hotel Partner!</p>
                <p>We have received from you your decline for Mr(s)  {{ $name }}’s booking
                    request with the dates {{ $checkinCustomer }} to {{ $checkoutCustomer }} . We have communicated this
                    decline already to Mr(s) {{ $name }} through our system.</p> <br>
                <p>Please ensure that you manage your Extranet Calendar to avoid
                    customer disappointments on date requests for your house.</p> <br><br>
                    <p>
                        Kind regards,
                    </p><br>
                    <p style="font-weight: 600">Your Migoda Team</p> <br><br>
            </div>
        </td>
    </tr>
    @endsection

