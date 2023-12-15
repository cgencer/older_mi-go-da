@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Bonjour <br> {{ $name }},</h1>
            <p><br><br></p>
            <p>Vous ne recevrez plus de newsletter de notre part.</p> <br>
            <p>Nous, chez Migoda, sommes tristes de vous voir partir.</p><br>
            <p>
                Bien sûr, nous aimerons bien vous revoir bientôt !!
            </p> <br>
            <p class="strong">Your Migoda Team</p>
        </div>
    </td>
</tr>
    @endsection

