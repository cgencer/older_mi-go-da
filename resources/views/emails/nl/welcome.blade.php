@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Welkom bij Migoda, <br> {{$name}}!</h1>
                <h3 class="inner-step">1</h3>
                <h3 class="inner-title">Inschrijven</h3>
                <p>Registreer de Coupon door in te loggen op uw reeds bestaande account of als u een nieuwe klant bent, registreer u dan voor een account bij ons. Daarna kunt u beginnen met het inwisselen van uw coupon.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">2</h3>
                <h3 class="inner-title"> 1 Gutschein 1 Nacht</h3>
                <p>Met één hotelcoupon kunt u één nacht in een hotelkamer verblijven voor twee personen. U hoeft alleen te betalen voor de maaltijdtoeslag die het hotel biedt en uw reiskosten naar het hotel. Het is de beslissing van het hotel om de gratis kamer op basis van beschikbaarheid te bieden.</p>
                <p class="note-text">Let op: de coupon is 18 maanden geldig na registratie.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">3</h3>
                <h3 class="inner-title">Verzamel Coupons</h3>
                <p>n uw account kunt u coupon verzamelen om ze in te wisselen voor
                    <span class="strong">een langere reis, de coupon overdragen aan geliefden, ze cadeau geven aan iemand van wie u houdt.</span>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">4</h3>
                <h3 class="inner-title">Ontdek je Bestemming</h3>
                    <p> Nu kunt u kiezen voor <span class="strong">een gratis overnachting</span> op uw favoriete plek<span class="strong">in een van onze meer dan 2.000 hotels van 1 tot 5 sterren in 30 landen wereldwijd. </span>Selecteer de gewenste data en verzend een boekingsverzoek. Zorg voor voldoende coupons voor de nachten die u hebt geboekt. Houd er rekening mee dat voor elke nacht een coupons wordt toegewezen aan uw boeking en wordt verwijderd nadat de reservering is voltooid. Wachten op bevestiging van de hotels kan 24-48 uur duren.
                    </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">5</h3>
                <h3 class="inner-title">Geniet van je Verblijf!</h3>
                <p>Nadat we een bevestiging van het hotel hebben ontvangen, ontvangt u van ons een bericht om de boeking te voltooien. U wordt gevraagd om te betalen, uit te checken en dan kunt u zich verheugen op uw hotelverblijf.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:40px 10px 40px 10px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a href="{{ env('APP_URL') }}/destinations" class="main-button" target="_blank">Ontdek bestemmingen</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
