

@extends('emails.layouts.master-hotel')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="title-h1">Que faisons-nous? - Nous vous aideons à remplir vos chambres INVENDUES!</h1>
            <h4 class="title-h4">
                @if ($gender == "f")
                Chère Madame {{ $name }}
                    @else
                Cher Monsieur {{ $name }}
                @endif
                <br>
                Nous VOUS avons choisi pour faire partie de notre famille! <br>
                Vous n'avez rien à perdre - seulement tout à GAGNER! <br>
            </h4>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
                <h2 class="title-h2">Comment allons-nous remplir vos chambres invendues?</h2>
            <br>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 40px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <br>
            <p class="paragraph">
                Vous acceptez de nous donner gratuitement vos chambres invendues et nous remplissons votre établissement de détenteurs de coupons prêts à voyager - qui apprécieront votre chambre gratuite en échange ils acceptent de payer un forfait-repas que vous proposez sur notre marché numérique
                <a target="_blank" rel="noopener noreferrer" href="https://migoda.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migoda.com</a>.
            </p>
            <br>
            <br>
            <br>

        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                <tbody>
                    <tr style="padding:0;vertical-align:top;">
                        <td class="eclipse-holder holder-1"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                            <span class="eclipse">01</span>
                        </td>
                        <td height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                         <p class="paragraph">
                            Comme vous le savez peut-être déjà - il y a eu quelques entreprises qui proposent un modèle similaire - mais nous sommes maintenant la première entreprise - entièrement numérique avec un public international. Veuillez consulter notre E-brochure pour en savoir plus sur nous - et comprendre à quel point votre participation à ce modèle commercial gagnant-gagnant est si facile!
                        </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
        </div>
    </td>
</tr>

<tr style="padding:0;vertical-align:top;text-align:left;">
        <td style="font-size:0px;padding:10px 80px 20px 165px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <table style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;">
                <tbody>
                <tr style="padding:0;vertical-align:top;text-align:left;">
                    <td style="">
                        <a target="_blank" rel="noopener noreferrer" href="https://meet.google.com/yta-hvwr-bym" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn1.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:block;border:none;"></a>
                    </td>
                    <td style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td style="">
                        <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migoda-brochure-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn2.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:block;border:none;"></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                <tbody>
                    <tr style="padding:0;vertical-align:top;text-align:left;">
                        <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">

                        </td>
                        <td  height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                            <br><br>
                            <p class="paragraph">
                                Bien sûr, vous pouvez également trouver toutes ces informations sur notre site Web <a target="_blank" rel="noopener noreferrer" href="https://migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">migodahotels.com</a>.<br><br>
                            </p>
                            <br>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 82px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">

        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                    <tbody>
                        <tr style="padding:0;vertical-align:top;text-align:left;">
                            <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                                <span class="eclipse">02</span>
                            </td>
                            <td  height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                              <p class="paragraph">  Comme nous vous invitons à faire partie de notre famille - nous avons créé avec beaucoup d'AMOUR votre compte ainsi que votre profil dans notre système Extranet. Veuillez cliquer ici pour le voir ...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>

<tr>
    <td align="right" style="font-size:0px;padding:10px 110px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ $url }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn3.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br>
                <table class="spacer float-center" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:100%;margin:0 auto;margin:0 auto;float:none;text-align:center;">
                    <tbody>
                        <tr style="padding:0;vertical-align:top;text-align:left;">
                            <td class="eclipse-holder"  style="width: 70px;vertical-align: middle;    padding-right: 20px;">
                                <span class="eclipse">03</span>
                            </td>
                            <br>
                            <td height="30px" style="word-wrap:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;vertical-align:top;color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;font-size:16px;line-height:1.3;color:#6d6f7e;font-family:Arial;font-size:14px;font-weight:400;line-height:22px;border-collapse:collapse !important;">
                                <p class="paragraph">
                                    Nous espérons sincèrement que vous aimez ce que nous avons créé et nous vous serions reconnaissants si vous vous joignez à nous. <br>
                                    Pour cela, il vous suffit juste d'accepter et de signer notre <a href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">Contrat de service</a>.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </td>
</tr>


<tr>
    <td align="right" style="font-size:0px;padding:10px 110px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;margin-top:50px">
        <div class="buttons-holder" style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:right;color:#6d6f7e;padding-top: 30px;">
                    <a target="_blank" rel="noopener noreferrer" href="{{ url('pdf/migodahotels-service-agreement-'.$lang.'.pdf') }}" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;"><img src="{{ asset("mailing/images/welcome/". $lang ."/btn4.png") }}" alt="" style="outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;clear:both;display:inline-block;border:none;"></a>
        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <br><br>
                <p class="paragraph">
                                Veuillez télécharger le contrat dans la section tableau de bord/ document, nous le renvoyer en temps opportun, soit par fax (F. +49 40 228 200 169) ou scanné par e-mail ( <a href="mailto:register@migodahotels.com" style="color:#0a0a0a;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;margin:0;text-align:left;line-height:1.3;color:#2199e8;text-decoration:none;color:#ef66a3;text-decoration:underline;">register@migodahotels.com</a>.  ).
                            </p>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </td>
</tr>


<tr>
    <td align="left" style="font-size:0px;padding:10px 75px 20px 75px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="paragraph">
                    Nous sommes toujours là pour vous soutenir, en mettant à votre disposition toutes nos connaissances - que ce soit pour les affaires, les questions numériques ou simplement comment  améliorer certaines parties de votre profil.   <br><br>

                    S'il vous plaît, n'hésitez jamais à nous contacter.  <br><br>

                    Avec nos salutations les plus chaleureuses pour un beau voyage et une bonne coopération ensemble, <br><br><br>

                    Votre équipe Migoda <br><br>

                    <b>Mischeila Golla</b><br>
                    Fondatrice &amp; PDG
                </p ></b><br></b><br>

        </div>
    </td>
</tr>



@endsection
