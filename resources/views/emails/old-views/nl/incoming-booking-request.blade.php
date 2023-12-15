@extends('emails.layouts.master')
@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <h1 class="header-title">INCOMING BOOKING REQUEST</h1>
                <p class="strong">Dear Migoda Hotel Partner!</p>
                <p>Mr(s) [[ guest_name ]] has sent a booking request to stay at your hotel for
                    the following dates: [[ date_checkin ]] to [[ date_checkout ]]. The meal
                    allowance you displayed through the Migoda Extranet includes
                    Half-Board with a daily price of &euro; [[ nightly_price ]]/ per person.</p>
                <p>According to your managed calendar in your Extranet account you
                    show these dates available.</p>
                <p>Please accept the booking - if you have availability and would
                    like to take these guests on!</p>
                <p>If your house is full - or at this point Migoda guests can not
                    come for whatever reason - please decline.</p>
            </div>
        </td>
    </tr>*
    <tr>
        <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-collapse:separate;width:100%;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#fa3440" role="presentation" style="border:none;border-radius:10px;cursor:auto;height:25px;padding:10px 25px;background:#fa3440;"
                        valign="middle"><a href="#" style="background:#fa3440;color:#ffffff;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:16px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;"
                                           target="_blank">Accept / Decline</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
            <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
                <p class="note-text-red">* You have 48 hours to respond!</p>
                <p class="note-text">A prompt response helps guests finalize their
                    trip and look forward coming to your house. If you don’t
                    respond to booking request within 48 hours you will lose this
                    guest/business opportunity.</p>
            </div>
        </td>
    </tr>
    @endsection

