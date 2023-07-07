@if($type=='state')
<label for="city">City</label>
{{ Form::select('city',$data,[],['class'=>'form-control address','id'=>'city','placeholder'=>'Choose City'])}}
<span class="text-danger">{{ $errors->first('city') }}</span>
@elseif($type=='city')
<label for="taluk">Taluk</label>
{{ Form::select('taluk',$data,[],['class'=>'form-control address','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
<span class="text-danger">{{ $errors->first('taluk') }}</span>
@elseif($type=='taluk')
<label for="pincode">Pin code</label>
{{ Form::select('pincode',$data,[],['class'=>'form-control address','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
<span class="text-danger">{{ $errors->first('pincode') }}</span>
@endif