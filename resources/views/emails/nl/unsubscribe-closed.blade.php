@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Hallo {{ $name }},</h1>
            <p><br><br></p>
            <p>U  zult niet langer onze nieuwsbrief van ons ontvangen.</p> <br>
            <p>Wij bij Migoda vinden het jammer dat u weggaat.</p><br>
            <p>Natuurlijk zien wij u graag snel weer terug !!</p><br>
            <p class="strong">Uw Migoda Team</p>
        </div>
    </td>
</tr>
    @endsection

