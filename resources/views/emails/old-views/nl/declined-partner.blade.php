@extends('emails.layouts.master')
@section('title')
    EINGEHENDE BUCHUNGSANFRAGE
@endsection
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">CONFIRMATION DÉCLINÉE</h1>
            <p class="strong">Cher (Chère) Partenaire de Migoda Hotel!</p>
            <p>Nous avons reçu de votre part un refus de la demande de réservation de M.(Mme) [[ guest_name ]] aux dates [[ date_checkin ]] - [[ date_checkout ]]. Nous avons déjà communiqué ce refus à M.(Mme) [[ guest_name ]] via notre système. </p>
            <p>Merci de bien vouloir gérer votre calendrier Migoda, afin d'éviter au client toute déception en ce qui concerne les demandes de dates pour votre établissement.</p>
            <p>Merci!</p>
            <p>Cordialement,</p>
            <p>Votre Équipe Migoda</p>
        </div>
    </td>
</tr>
    @endsection

