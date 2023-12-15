@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Hello Admin,</h1>
            <p><br><br></p>
            <p>{{ $hotel }} was uploaded {{$type}} document in {{$date}}</p>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                           style="vertical-align:top;"
                           width="100%">
                        <tr>
                            <td align="center" vertical-align="middle"
                                style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="border-collapse:separate;width:100%;line-height:100%;">
                                    <tr>
                                        <td align="center" bgcolor="#fa3440" role="presentation"
                                            class="main-button-holder"
                                            valign="middle"><a href="{{ $url }}"
                                            class="main-button"
                                                               target="_blank">View Document Now</a></td>
                                    </tr>
                            </table>
                        </td>
                    </tr>
            </table>
        </div>
    </td>
</tr>

    @endsection

