<!DOCTYPE html>
<html style="margin: 0;">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }}</title>
	<style>
		@font-face {
		    font-family: 'Vampire Calligraphy';
		    src:url('fonts/VampireCalligraphy-GgoA.ttf') format('truetype'), 
		    	url('fonts/VampireCalligraphy.woff2') format('woff2'),
		        url('fonts/VampireCalligraphy.woff') format('woff');
		    font-weight: normal;
		    font-style: normal;
		    font-display: swap;
		}
		@font-face {
		    font-family: 'Calibri';
		    src: url('fonts/calibri-regular.ttf') format('truetype'),
		    	url('fonts/Calibri.woff2') format('woff2'),
		        url('fonts/Calibri.woff') format('woff');
		    font-weight: normal;
		    font-style: normal;
		    font-display: swap;
		}
		@font-face {
		    font-family: 'Calibri';
		    src: url('fonts/calibri-bold.ttf') format('truetype'),
		    	url('fonts/Calibri-Bold.woff2') format('woff2'),
		        url('fonts/Calibri-Bold.woff') format('woff');
		    font-weight: bold;
		    font-style: normal;
		    font-display: swap;
		}
		@font-face {
		    @font-face {
		    font-family: 'Stylish Calligraphy Demo';
		    src: url('fonts/StylishCalligraphyDemo-XPZZ.ttf') format('truetype'),	
		    	url('fonts/StylishCalligraphyDemo.woff2') format('woff2'),
		        url('fonts/StylishCalligraphyDemo.woff') format('woff');
		    font-weight: normal;
		    font-style: normal;
		    font-display: swap;
		}

	</style>
</head>

<body style="color: #8f3402;font-family: 'Calibri'; margin: 0;">
	<table style="background-image: url('images/Certificate-plane-background.jpg');
		box-sizing: border-box;width: 100%;background-size: 100%;background-repeat: no-repeat;
		margin: auto;text-align: center;padding:70px 80px; padding-bottom: 60px;">
		<tbody>
			<tr>
				<td style="width: 25%;text-align: left;">
					@if($certificate->logo1_file)
						<img style="height: 70px;" src="{{ asset('public/'.$certificate->logo1_file) }}">
					@endif	
				</td>
				<td style="width: 50%;text-align: center;">
					@if($certificate->logo2_file)
						<img style="height: 90px;" src="{{ asset('public/'.$certificate->logo2_file) }}">
					@endif
				</td>
				<td style="width: 25%;text-align: right;">
					@if($certificate->logo3_file)
						<img style="height: 70px; " src="{{ asset('public/'.$certificate->logo3_file) }}">
					@endif
				</td>
			</tr>
			<tr>
				<td colspan="3" >
					<span style="font-family: 'Stylish Calligraphy Demo';font-size: 26px;margin: 0; line-height: 1; padding: 20px 0px 10px 0px;text-transform: uppercase;display: block;">
						@if($certificate->certi_heading == 1)
							<img style="height: 50px; " src="{{ asset('public/images/certificate_of_achievement.png') }}">
						@elseif($certificate->certi_heading == 2)
							<img style="height: 50px; " src="{{ asset('public/images/certificate-of_participation.png') }}">
						@endif
					</span>

					<p style="margin: 0;font-size: 20px;line-height: 1;">This is to certify that</p>

					<div style="width: 60%;margin: 10px auto; margin-bottom: 0;">
						<span style="font-size: 18px;color: #8f3402;width: 100%;text-align: center;display: inline-block;text-transform: capitalize;font-family: 'Helvetica';">
							<span style="padding-right: 10px;text-transform: capitalize;">Mr./Ms.</span><strong style="font-family: 'Helvetica';font-size: 16px;">{{ $student->name }}</strong>
						</span>
		            </div>

		            <p style="font-size: 18px;margin: 0;">has sucessfully completed online training program on <br> <strong style="text-transform: capitalize;font-family: 'Helvetica';font-size: 14px; line-height: 28px;">"{{ json_decode($batch->module_ary)->name }}"</strong></p>

		            <div style="font-size: 18px;margin: 0;line-height: 1;">
						<span style="font-size: 18px;color: #8f3402;background-color: transparent; text-align: center;display: inline-block;">conducted from 
							<strong style="font-family: 'Helvetica';font-size: 14px;line-height: 30px; margin: 0;">{{ Helper::date($batch->start_date, 'd-m-Y') }}</strong> to <strong style="font-family: 'Helvetica';font-size: 14px;">{{ Helper::date($batch->end_date, 'd-m-Y') }}</strong>
						</span>
						<p style="margin: 10px 0;">	
						<span style="font-size: 18px;color: #8f3402;background-color: transparent; text-align: center;display: inline-block;line-height: 1;">He/She has been awarded
							<strong style="font-family: 'Helvetica';font-size: 14px;text-transform: uppercase;">
								{{\App\Models\Assesment::grade($assesment->grade ?? '-1') }}
							</strong>
						grade.</span> 
						</p>
		            </div>
		            <p style="font-size: 18px;display: inline-block;border-bottom: solid 1px; margin-top: 0;">Training Partner:
		            	<strong style="font-family: 'Helvetica';font-size: 14px;">SRI SRI RURAL DEVELOPMENT PROGRAMME TRUST</strong>
		            </p>

			        <p style="font-size: 18px;margin-top: -10px;line-height: 1;">
			        	Training facilitated by
			        	<strong style="text-transform: capitalize;font-family: 'Helvetica';font-size: 16px;	">{{ ucfirst(implode(',', $partners)) }}
			            </strong>
			        </p>
				</td>
			</tr>

			<tr>
				<td>
					<p style="margin:0px 0px 0px 0px;line-height: 1;font-size: 18px;">
						<span style="font-size: 18px;color: #8f3402;	background-color:transparent;text-align: center;display: inline-block;line-height: 1;">
							Certificate ID: <strong style="font-family: 'Helvetica';font-size: 16px;">{{ 	$certificate->slug }}</strong>
						</span>
					</p>
				</td>
				<td>
					
				</td>
				<td>
					<p style="margin:0px 0px 0px 0px;line-height: 1;font-size: 18px;">
						<span style="font-size: 18px;color: #8f3402;background-color:transparent;text-align: center;display: inline-block;line-height: 1;">
							Issued On : <strong style="font-family: 'Helvetica';font-size: 16px;">{{ Helper::date($certificate->issued_on, 'd-m-Y') }}</strong>
						</span>
					</p>
				</td>
			</tr>

			<tr>
				<td style=" font-size: 16px;line-height: 16px; padding-top: 25px;">
					@if($certificate->name1 && $certificate->designation1 && $certificate->company1 && $certificate->signature1)
						<strong style="text-align: center;display: inline-block;text-transform: capitalize;font-size: 16px;font-family: 'Helvetica';">
							<img style="height: 70px;" src="{{ asset('public/'.$certificate->signature1) }}">
							<span style="display: block;">{{ $certificate->name1 }}</span> 
							  {{ $certificate->designation1 }}, {{ $certificate->company1 }}.
						</strong>
					@endif
				</td>
				<td style=" font-size: 16px;line-height: 16px; padding-top: 25px;">
					@if($certificate->name2 && $certificate->designation2 && $certificate->company2 && $certificate->signature2)
						<strong style="text-align: center;display: inline-block;text-transform: capitalize;font-size: 16px;font-family: 'Helvetica';">
							<img style="height: 70px;" src="{{ asset('public/'.$certificate->signature2) }}"> 
							<span style="display: block;">{{ $certificate->name2 }}</span> 
							{{ $certificate->designation2 }}, {{ $certificate->company2 }}.
						</strong>
					@endif
				</td>
				<td style=" font-size: 16px;line-height: 16px; padding-top: 25px;">
					@if($certificate->name3 && $certificate->designation3 && $certificate->company3 && $certificate->signature3)
						<strong style="text-align: center;display: inline-block;text-transform: capitalize;font-size: 16px;font-family: 'Helvetica';">
							<img style="height: 70px;width: 110px;object-fit: cover;" src="{{ asset('public/'.$certificate->signature3) }}"> 
							<span style="display: block;">{{ $certificate->name3 }}</span>  
							{{ $certificate->designation3 }}, {{ $certificate->company3 }}.
						</strong>
					@endif
				</td>
			</tr>

			<tr>
				<td colspan="3">
					<p style="margin:20px 0px 0px 0px;line-height: 1;font-size: 16px">
						@if($certificate->certificate_type == '2')
							This certificate has <span style="text-transform: lowercase;">{{ \App\Models\Certificate::certificateValidities($certificate->certificate_type) }}.</span> Terms and Conditions May Apply*
						@elseif($certificate->certificate_type == '1')
							This certificate is vaild till {{ Helper::date($certificate->validity_date, 'jS F Y') }}. Terms and Conditions May Apply
						@endif
					</p>
				</td>
			</tr>
		</tbody>
		
	</table>

</body>
</html>