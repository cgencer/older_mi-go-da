@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">YOUR GUESTS <br> ARE ON THE WAY!</h1>
            <p class="strong">Dear Migoda Hotel Partner!</p>
            <p>Mr(s) {{ $name }} arrives {{ $checkin }}  to {{ $checkout }}, with
                @if ($children == 0)
                {{ $person }} people
                @else
                {{ $person }} people and {{ $children }} childrens
                @endif
                to your hotel.</p> <br> <br>
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
                                       target="_blank">Overview of Booking</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p>...(MINUS THE 18,5% MIGODA COMMISION)</p>
            {{-- <p>If you have any questions regarding your payouts and fees,
                please contact <a class="mail_link" href="mailto:accounting@migodahotels.com">accounting@migodahotels.com</a> --}}
            </p>
        </div>
    </td>
</tr>

    @endsection

