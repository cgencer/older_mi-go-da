@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Delete Account Approval?</h1>
            <p class="strong">Hi {{ $name }}</p>
            <br>
            <p>We have received the request from you to permanently delete your
                Migoda Account. We at Migoda are very sorry you leaving us!</p> <br>
            <p>We will immediately delete you and all your information (incl.
                travel history and wishlist) from our system. Should there be
                open bookings we will also delete this on your behalf. With
                this you will no longer have access to our members only
                website.</p>
                <br>
                <br>
        </div>
    </td>
</tr>
<tr>
    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
               style="border-collapse:separate;width:100%;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"  valign="middle"><a href="{{ $resetUrl }}" class="main-button" target="_blank">Delete Account</a></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <p class="note-text">*(If you don’t want to delete your account,
                ignore this message)</p>
            <p>Should you in the future change your mind again to utilize
                another Coupon, you can always sign up again and we would love
                to have you back!</p>
            <p>For now all the best to you!</p>
            <p class="strong">Your Migoda Team</p> <br><br>
        </div>
    </td>
</tr>

    @endsection

