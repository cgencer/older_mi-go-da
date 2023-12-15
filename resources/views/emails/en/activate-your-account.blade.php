@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Hi {{ $name }}!</h1>
                <p>You’re almost ready to start your Migoda Journey...</p>
                <p >Click the button below to confirm your email address to activate your Migoda Account.</p> <br> <br><br>
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a class="main-button" href="{{route('auth.active.account',['code' => $code])}}" target="_blank">Active Account</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="note-text">*if you received this by mistake or weren’t expecting it, please disregard this email.</p>
            </div>
        </td>
    </tr>

@endsection
