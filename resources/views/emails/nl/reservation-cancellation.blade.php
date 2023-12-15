@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Het spijt ons te horen <br> over uw last minute annulering ...</h1>
            <p>
                Uw boeking met referentienummer {{ $reference }} is geannuleerd in ons systeem. Wij hebben het hotel ook geïnformeerd dat u niet zult komen. Ter informatie: uw coupons staan weer in uw account. Hopelijk kunt u snel weer een reis met ons maken!
            </p>
            <p>Met vriendelijke groet,</p>
            <br>
            <br>
            <p><strong>Uw Migoda Team</strong></p>
            <br>
            <br>
            <br>
        </div>
    </td>
</tr>
    @endsection

