@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Forgot Your Password?</h1>
                <h3 class="header-subsubtitle">Don’t worry, we’re here to help!<br><br>Let’s get you a new password.
                </h3>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" style="border:none;border-radius:10px;cursor:auto;height:25px;padding:10px 25px;background:#fa3440;" valign="middle">
                        <a href="#" style="background:#fa3440;color:#ffffff;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;" target="_blank">Reset Password</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p>If you didn't mean to reset your password - you can just ignore this email.</p>
                <p>Your password will not change.</p>
            </div>
        </td>
    </tr>
@endsection
