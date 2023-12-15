<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <style>body {font-family: 'FuturaNDCn', sans-serif;}</style>
    <title>Reservation Invoice at {{$hotel->name}}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Responsive and mobile friendly stuff -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="375">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="	sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<head>
<body>
    <a name="top"></a>
    <div class="mg-section mg-group">
        <div class="mg-col mg-span_3_of_12 logo_wrapper">
            <a href="/" title="{{\Illuminate\Support\Facades\Config::get('app.name')}}" class="header-logo"><img src="front/assets/images/logo-header.png" alt="{{\Illuminate\Support\Facades\Config::get('app.name')}}"/></a>
        </div>
    </div>
    <div style="padding-top:60px;">
		<h3>Invoice for {{$reservation->main_guest}}<h3>
		<h4>at {{$hotel->name}} for {{ $dates }}</h4>
    </div>
    <table width="100%" style="border:1px solid #ccc;">
    	<tr>
    		<td>{{ $dates }}</td>
    		<td>{{ $pppDay }} person(-s) / days</td>
    		<td align="right">{{$reservation->stripe_data['fees']['hotel']/100}} {{$reservation->stripe_data['fees']['currency']}}</td>
    	</tr>
    	<tr>
    		<td>Fees:</td>
    		<td></td>
    		<td align="right">{{$reservation->stripe_data['fees']['migoda']/100}} {{$reservation->stripe_data['fees']['currency']}}</td>
    	</tr>
    	<tr>
    		<td>Taxes:</td>
    		<td></td>
    		<td align="right">0 {{$reservation->stripe_data['fees']['currency']}}</td>
    	</tr>
    	<tr>
    		<td>Total:</td>
    		<td></td>
    		<td align="right">{{ $hotel->price * $pppDay }} {{$reservation->stripe_data['fees']['currency']}}</td>
    	</tr>
    </table>
<br />
<br />
</body>
</html>
