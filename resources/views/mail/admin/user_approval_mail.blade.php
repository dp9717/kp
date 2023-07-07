<?php $data = $result['data'];
$h = \App\Models\Setting::first();
    $logo = $h->logo ?? 'img/logo/logo.png';
    $moblogo = $h->moblogo ?? 'img/logo/logosn.png';
    $fevicon = $h->fevicon ?? 'img/favicon.ico';
?>
<h1>Hello {{ $data->name ?? 'User' }}</h1>

<h2>Welcome to SSRDP’s Kaushal Path 1.0</h2>

<p>Please click the button  below to authenticate your account with us. The link will also let you set your password for further access to the application. Please complete your profile at within 7 days.</p>

<a href="{{ $result['link'] ?? ''}}" style="font-size32px; font-weight: bold;">Click Here</a>

<h3>Thank you!</h3>
<p>Sri Sri Rural Development Programme Trust! <span><img src="{{url('public/'.$moblogo)}}" /></span></p>
