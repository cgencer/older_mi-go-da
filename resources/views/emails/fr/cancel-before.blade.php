@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">ANNULATION DU <br> CLIENT</h1>
            <p class="strong">Cher(e) partenaire!</p>
            <p>
                Malheureusement, nous avons reçu une demande d'annulation de Mme / M.  {{ $guest }} au cours de la période d'annulation gratuite. Le/ Les client(s) ne pourront pas venir à votre hôtel aux dates réservées du {{ $checkin}} to {{ $checkout }}..
            </p>
            <p>Merci de bien vouloir mettre à jour l'aperçu des réservations de votre établissement et veuillez supprimer cette réservation annulée.
             </p> <br>
            <p>Merci!</p><br>
            <p>Cordialement, </p> <br>
            <p><strong>Votre Équipe Migoda!</strong></p> <br><br>
        </div>
    </td>
</tr>
    @endsection

