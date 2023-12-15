@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Sorry to hear about <br> your last minute cancellation ...</h1>
              <p>
                Your booking with reference number {{ $reference }} has been cancelled in our system. We have also informed the hotel that you will not come. Just for your information, your Coupons are back in your account. Hope you can manage another journey with us soon!
              </p>
            <p>Kind regards,</p>
            <br>
            <br>
            <p><strong>Your Migoda Team</strong></p>
            <br>
            <br>
            <br>
        </div>
    </td>
</tr>
    @endsection

