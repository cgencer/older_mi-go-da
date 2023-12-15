@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Bienvenue à Migoda,<br> {{$name}}!</h1>
                <h3 class="inner-step">1</h3>
                <h3 class="inner-title">S'enregistrer</h3>
                <p>Enregistrez le Coupon en vous connectant à votre compte déjà existant ou si vous êtes un nouveau client, Merci de bien vouloir vous inscrire. Ensuite vous pouvez commencer à utiliser et échanger votre Coupon. </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">2</h3>
                <h3 class="inner-title"> 1 Coupon 1 Nuit</h3>
                <p>Un coupon, vous donne la possibilité de séjourner une nuit à l'hôtel pour deux personnes. Vous avez seulement besoin de payer le forfait-repas fourni par l'hôtel ainsi que les frais de votre trajet pour s'y rendre. Ce sont les hôtels qui décident de fournir la chambre gratuite sous réserve de disponibilité.</p>
                <p class="note-text">Merci de bien noter que le coupon est valable 18 mois après l'inscription.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">3</h3>
                <h3 class="inner-title">Collectez les Coupons</h3>
                <p>Vous pouvez collecter les Coupons sur votre compte afin de les échanger pour
                    <span class="strong">un plus long séjour, les transférer à vos proches ou bien les offrir comme un cadeau à ceux que vous aimez. </span>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">4</h3>
                <h3 class="inner-title">Découvrez votre Destination</h3>
                    <p> Dès maintenant, vivez l'expérience de <span class="strong">séjourner gratuitement pendant une ou plusieurs nuits, en choisissant votre destination favorite et ce, parmi + de 2000 hôtels entre 1 et 5 étoiles à travers 30 pays dans le monde entier.  </span>
                        Sélectionnez vos dates préférées et envoyez votre demande de réservation. Assurez-vous d'avoir suffisamment de coupons pour la/les nuits que vous avez réservé. Gardez à l'ésprit que pour chaque nuit réservée, un Coupon sera utilisé et il sera supprimé une fois la réservation finalisée. L'attente de confirmation de l'hôtel peut prendre entre 24 heures et 48 heures.
                    </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">5</h3>
                <h3 class="inner-title">Profitez de Votre Séjour!</h3>
                <p>Une fois que nous reçevrons la confirmation de l'hôtel, vous receverez une notification de notre part pour finaliser la réservation. Il vous sera demandé de payer, de vérifier et ensuite vous pouvez profiter pleinement de votre séjour à l'hôtel. </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:40px 10px 40px 10px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a href="{{ env('APP_URL') }}/destinations" class="main-button" target="_blank">Découvrez votre Destination</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
