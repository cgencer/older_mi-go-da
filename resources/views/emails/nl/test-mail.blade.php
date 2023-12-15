@extends('emails.layouts.master')
@section('content')

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;padding-top:0;padding-bottom:0;word-break:break-word;">
        <div style="font-family:Arial, sans-serif;font-size:16px;line-height:1;text-align:left;color:#6d6f7e;">
            <h1 class="header-title">This is a test <br> for cronjob scheluded mails ...</h1>
            <p>Your booking with reference number  has been cancelled in our system. We have also informed the hotel that you will not come.</p> <br>
            <p>

                <img src='https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap
                &markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318
                &markers=color:red%7Clabel:C%7C40.718217,-73.998284
                &key=AIzaSyBEFxTnVZhS0XrqiOuoiQ7Kp1HBNo2DK-Q' width="800" height="600"/>

            </p>

            <br><br>
            <p><strong>Your Migoda Team</strong></p> <br><br><br><br>
        </div>
    </td>
</tr>
    @endsection

