@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">Tut uns leid, von Ihrer Stornierung <br> in letzter Minute zu erfahren ...</h1>
                Ihre Buchung mit der Referenznummer  {{ $reference }} wurde in unserem System storniert. Wir haben das Hotel darüber informiert, dass Sie nicht kommen werden. Nur zu Ihrer Information - Ihre Gutscheine sind wieder auf Ihrem Konto gutgeschrieben. Wir hoffen, Sie können bald wieder eine Reise mit uns machen!
            </p>
            <p>Mit freundlichen Grüßen,</p>
            <br>
            <br>
            <p><strong>Ihr Migoda Team</strong></p>
            <br>
            <br>
            <br>
        </div>
    </td>
</tr>
    @endsection

