@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">GOOD NEWS</h1>
            <h2 class="header-subtitle">YOU HAVE GUESTS COMING!</h2>
            <p class="strong">Dear Migoda Hotel Partner!</p>
            <p>
                We are happy to let you know that the guest has paid for the meal package for the date(s) {{ $checkin }} to {{ $checkout }} and is looking forward to stay with you! (Ref. {{ $code  }}).
            </p><br>
            <p>Unless there is an unforeseen cancellation on behalf of the guest prior to 48 hours of arrival to your house - we will pay out the following:</p> <br>
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
                    valign="middle"><a href="{{ $route }}"
                                       class="main-button-bg"
                                       target="_blank">OVERVIEW OF EARNINGS</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
          <br>  <p>...(MINUS THE 18,5% MIGODA COMMISION)</p> <br>
            <p>If you have any questions regarding your payouts and fees,
                please contact <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a>
            </p>
        </div>
    </td>
</tr>
    @endsection

