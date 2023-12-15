@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">ATTENTION! - RAPPEL CONCERNANT UNE NOUVELLE DEMANDE DE RÉSERVATION MIGODA </h1>
                <p class="strong">Cher(e) partenaire!</p> <br>
                <p class="strong">Il y a 24 heures, nous vous avons envoyé un e-mail auquel vous n'avez pas répondu.</p> <br>
                <p>Mr(s) {{ $name }} has sent a booking request to stay at your hotel for
                    the following dates: {{ $checkin }} to {{ $checkout }} . The meal
                    allowance you displayed through the Migoda Extranet includes
                    Half-Board with a daily price of &euro; {{ $price }}/ per person.</p> <br>
                <p>
                    Mme / M. {{ $name }} a envoyé une demande de réservation pour séjourner dans votre hôtel et ce pour les dates suivantes: Du {{ $checkin }} - {{ $checkout }}
                </p><br>
                <p>
                    Le forfait-repas que vous avez mentionné via l'Extranet-Migoda, comprend la formule en demi-pension et le prix quotidien en {{ $price }} par personne.
                </p><br>
                <p>Selon votre calendrier, que vous avez géré auparavant et qui se trouve dans votre compte Extranet , vous avez affiché ces dates comme disponibles.</p> <br>
                <p>Merci de bien vouloir accepter la réservation - si vous avez des places disponibles et si vous souhaitez recevoir ces invités.</p> <br>
                <p>Si votre établissement est plein, ou si en ce moment-là, les clients de Migoda ne peuvent pas être acceptés pour quelconque raison, veuillez refuser cette réservation.</p> <br>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder"
                        valign="middle"><a href="{{ $route }}" class="main-button"
                                        target="_blank">ACCEPTER / REFUSER  </a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:15px 30px;padding-top:30px;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                {{-- <p class="note-text-red">* You have 24 hours to respond!</p> --}}
                <p class="note-text">
                    * Vous avez 24 heures pour répondre! <br>
                    Une réponse rapide permet à nos clients de payer et de finaliser leur séjour, ainsi ils auront hâte de venir à votre hôtel. Si vous ne répondez pas à la demande de réservation de Mme / M. {{ $name }} dans les 48 heures, vous perdrez cette opportunité de recevoir des invités et de conclure de belles affaires pour votre établissement.</p>
            </div>
        </td>
    </tr>

    @endsection

