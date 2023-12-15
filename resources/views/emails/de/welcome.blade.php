@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Willkommen bei Migoda, <br> {{$name}}!</h1>
                <h3 class="inner-step">1</h3>
                <h3 class="inner-title">Registrieren</h3>
                <p>Registrieren Sie den Gutschein indem Sie sich entweder bei Ihrem bereits bestehenden Konto anmelden oder wenn Sie Neukunde sind, registrieren Sie sich bitte für ein Konto bei uns. Dann können Sie Ihren Gutschein einlösen.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">2</h3>
                <h3 class="inner-title"> 1 Gutschein 1 Nacht</h3>
                <p>Der Gutschein ermöglicht Ihnen eine Hotelübernachtung für zwei Personen im Doppelzimmer. Sie müssen nur die vom Hotel gewünschte Verpflegungspauschale bezahlen und Ihre Anfahrt und Abreise. Es ist die Entscheidung des Hotels, das kostenlose Zimmer nach Verfügbarkeit zur Verfügung zu stellen.</p>
                <p class="note-text">Beachten Sie, dass der Gutschein 18 Monate nach der Registrierung gültig ist.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">3</h3>
                <h3 class="inner-title">Gutscheine sammeln</h3>
                <p>In Ihrem Konto können Sie Gutscheine sammeln, um sie entweder für
                    <span class="strong">eine längere Reise einzulösen, oder die Gutscheine an Freunde, Familie oder an Jemanden zu verschenken, den Sie lieb haben.   </span>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">4</h3>
                <h3 class="inner-title">Entdecken Sie Ihr Reiseziel</h3>
                    <p> Jetzt können Sie sich für <span class="strong">eine kostenlose Übernachtung</span> in Ihrem Lieblingsort <span class="strong">in einem unserer über 2.000 Hotels von 1 bis 5 Sternen in 30 Ländern weltweit</span>
                        entscheiden. Wählen Sie Ihre bevorzugten Termine aus und senden Sie eine Buchungsanfrage. Stellen Sie sicher, dass Sie für die von Ihnen gebuchten Nächte genügend Gutscheine haben. Bitte beachten Sie, dass für jede Nacht ein Gutschein Ihrer Buchung zugeordnet und nach Abschluss der Buchung gelöscht wird. Das Warten auf die Bestätigung der Hotels kann bis zu 24 - 48 Stunden dauern.
                    </p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h3 class="inner-step">5</h3>
                <h3 class="inner-title">Genießen Sie Ihren Aufenthalt!</h3>
                <p>Nachdem wir die Bestätigung vom Hotel erhalten haben, erhalten Sie eine Benachrichtigung von uns, um die Buchung abzuschließen. Sie werden gebeten, zu bezahlen, auszuchecken und können sich darauf freuen, Ihren Aufenthalt im Hotel zu genießen.</p>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:40px 10px 40px 10px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a href="{{ env('APP_URL') }}/destinations" class="main-button" target="_blank">Reiseziele entdecken</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
