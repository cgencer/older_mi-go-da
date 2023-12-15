@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Hello {{ $name }},</h1>
            <p><br><br></p>
            <p>You are subscribed our newsletter now.</p> <br>
            <p>You will now be the first to know about our newsletter mails.</p> <br>
            <p>Of course we would love to have you back again soon !!</p> <br>
            <p class="strong">Your Migoda Team</p>
        </div>
    </td>
</tr>
    @endsection

