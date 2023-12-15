@extends('emails.layouts.master')
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Hello <br> {{ $name }},</h1>
            <p><br><br></p>
            <p>Ab sofort erhalten Sie von uns keinen Newsletter mehr.</p> <br>
            <p>Wir von Migoda bedauern es sehr, dass Sie uns verlassen.</p> <br>
            <p>
                Natürlich würden wir uns sehr freuen, Sie bald wieder zu begrüßen !!
            </p><br>
            <p class="strong">Ihr Migoda Team</p>
        </div>
    </td>
</tr>
    @endsection

