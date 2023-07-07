<div class="col-md-12"> <h1>Vendor Detail ( {{ $data->slug }} )</h1></div> 
<div class="row">
    <div class="col-md-12 vander_dataview">
        <ul>
            <li>
                <strong>Address: </strong>
                <p>  {{ json_decode($data->full_address)->address ?? '' }}</p>
            </li>
            <li>
                <strong>Taluk: </strong>
                <p>  {{ json_decode($data->full_address)->taluk ?? '' }}</p>
            </li>
     
            <li>
                <strong>City: </strong>
                <p>  {{ json_decode($data->full_address)->city ?? '' }}</p>
            </li>
            <li>
                <strong>State: </strong>
                <p>  {{ json_decode($data->full_address)->state ?? '' }}</p>
            </li>

            <li>
                <strong>PinCode: </strong>
                <p>  {{ json_decode($data->full_address)->pincode ?? '' }}</p>
            </li>
        </ul>
    </div>
</div>
<div class="col-md-12"><h1>Point Of Contact (POC)</h1></div> 
<div class="row">
    @if($data->poc) 
        <div class="col-md-12  vander_dataview">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                </tr>
                @php
                    $pocs = json_decode($data->poc);
                @endphp
                @forelse($pocs as $key => $val)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $val->poc_name }}</td>
                        <td>{{ $val->poc_email }}</td>
                        <td>{{ $val->poc_contact }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Poc not found</td>
                    </tr>
                @endforelse
            </table>
        </div>
    @endif
</div>