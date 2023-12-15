@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">ANNULATION DU CLIENT</h1>
            <p class="strong">Cher Partenaire de Migoda Hotel!</p>
            <p>Malheureusement, nous avons reçu une demande d'annulation de la part de M.(Mme) [[ guest_name ]] durant la période où l'annulation est gratuite. Le/Les client(s) ne pourront pas venir à votre établissement aux dates réservées du [[ date_checkin ]] - [[ date_checkout ]].</p>
            <p>Merci de bien vouloir mettre à jour votre aperçu de réservation et de supprimer celle qui vient d'être annulée.</p>
            <p>Merci!</p>
            <p>Cordialement,</p>
            <p>Votre Équipe Migoda</p>
        </div>
    </td>
</tr>

    @endsection

