@extends('emails.layouts.master')
@section('content')

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Hi Murat!</h1>
                <h2 class="header-subtitle">U bent bijna klaar om uw Migoda-reis te beginnen ...</h2>
                <h3 class="header-subsubtitle">Klik op onderstaande knop om uw e-mailadres te bevestigen en uw Migoda-account te activeren. </h3>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a class="main-button" href="" target="_blank">ACCOUNT ACTIVEREN</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="note-text">* als u dit per ongeluk heeft ontvangen of niet had verwacht, negeer deze e-mail.</p>
            </div>
        </td>
    </tr>

@endsection
