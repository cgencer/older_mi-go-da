@extends('emails.layouts.master')

@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Merhaba {{ $name }},</h1>
            <p><br><br></p>
            <p>Artik bizden haber bülteni almayacaksınız.</p> <br>
            <p>Gittiğinizi görmek Migoda olarak bizi üzdü.</p><br>
            <p>Tabiki sizi tekrardan aramızda görmekten mutluluk duyarız !!</p><br>
            <p class="strong">Migoda Ekibiniz</p>
        </div>
    </td>
</tr>
    @endsection

