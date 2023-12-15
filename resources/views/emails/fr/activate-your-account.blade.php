@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Hi Murat!</h1>
                <h2 class="header-subtitle">Vous êtes presque prêt à commencer votre voyage avec Migoda…</h2>
                <h3 class="header-subsubtitle">Cliquez sur le bouton ci-dessous pour confirmer votre adresse e-mail afin d'activer votre compte Migoda.</h3>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a class="main-button" href="" target="_blank">ACTIVER LE COMPTE</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="note-text">*Si vous avez reçu cet e-mail par erreur ou que vous ne l'attendiez pas, ignorez-le.</p>
            </div>
        </td>
    </tr>

@endsection
