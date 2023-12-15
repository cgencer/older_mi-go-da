@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">Şifrenizi mi unuttunuz?</h1>
                <h2 class="header-subtitle" style="margin-bottom:10px;font-weight:500">Endişelenmeyiniz,</h2>
                <h3 class="header-subsubtitle" style="margin-top:10px">  size yardım etmek için buradayız!<br><br>Size yeni bir şifre oluşturalım.
                </h3>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" class="main-button-holder" valign="middle">
                        <a href="{{ $resetUrl  }}" class="main-button"  target="_blank">Şifreyi Sıfırla</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="note-text">Şifrenizi sıfırlamak istemediyseniz - bu e-postayı göz ardı edebilirsiniz. <br> Şifreniz değişmeyecektir.</p>

            </div>
        </td>
    </tr>
@endsection
