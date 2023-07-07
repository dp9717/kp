<div class="vander_dataview">
    <ul>
        <li>
            <strong>Name: </strong> 
            <p>{{ $data->name }}</p>
        </li>
        <li>
            <strong>Duration: </strong> 
            <p>{{ $data->duration }}</p>
        </li>
        <li>
           <strong>Status: </strong>
            <p> @if($data->status == 1)
                <span class="label-success label-3 label">Active</span>
            @elseif($data->status == 2)
                <span class="label-purple label-7 label">Inactive</span>
            @endif</p>
        </li>

    </ul>
</div>
 @if($data->description)
    <div class="form-group additional_info">
    <strong>Description</strong> 
    <p>{{ $data->description }}</p>
    </div>
@endif
