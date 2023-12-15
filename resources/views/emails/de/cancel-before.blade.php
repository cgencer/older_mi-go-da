@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">STORNIERUNG VON <br> SEITEN DES GASTES</h1>
            <p class="strong">Sehr geehrtes Partnerhotel!</p>
            <p>
                Leider haben wir innerhalb der kostenfreien Widerrufsfrist eine Stornierung von Herrn {{ $guest }} erhalten. Die Gäste kommen zu den reservierten Terminen {{ $checkin}} to {{ $checkout }} nicht zu Ihnen ins Hotel.
            </p>
            <p>Bitte aktualisieren Sie Ihre interne Reservierungsübersicht und löschen Sie diese Buchung daraus.</p> <br>
            <p>Vielen Dank!</p><br>
            <p>Mit freundlichen Grüßen,</p> <br>
            <p><strong>Ihr Migoda-Team!</strong></p> <br><br>
        </div>
    </td>
</tr>
    @endsection

