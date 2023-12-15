@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">CONFIRMATION DU REFUS</h1>
                <p class="strong">Cher Partenaire!</p>
                    Nous avons bien reçu votre refus pour la demande de réservation de {{ $name }} et ce pour les dates du {{ $checkinCustomer }} au {{ $checkoutCustomer }}. (Ref. {{ $code }}). Nous avons déjà signalé ce refus à {{ $name }} par le biais de notre système.
                </p> <br>
                <p>Assurez-vous toujours de bien gérer votre calendrier Extranet, afin d'éviter une quelconque déception pour les clients lors de leur réservation dans votre établissement. Merci infiniment!</p> <br><br>
                    <p>
                        Cordialement,
                    </p><br>
                    <p style="font-weight: 600">Votre Équipe Migoda!</p> <br><br>
            </div>
        </td>
    </tr>
    @endsection

