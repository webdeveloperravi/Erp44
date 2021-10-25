 
@if($addresses->count() > 0)
<div class="row">
       @foreach($addresses as $address) 
        <div class="col-sm-4">
          <div class="card card-border-primary">
            <div class="card-header">
              <h5>{{ $address->addressType->name ?? ""}} </h5> 
            </div>
          <div class="card-block">
          <div class="row">
          <div class="col-sm-12">
          <ul class="list list-unstyled">
          <li>Country : &nbsp;{{ $address->country->name ?? ""}}</li> 
          <li>State : &nbsp;{{ $address->state->name ?? ""}}</li> 
          <li>Town : &nbsp;{{ $address->town->name ?? ""}}</li> 
        <li>City : &nbsp;{{ $address->city->name ?? ""}}</li> 
          <li>Address : &nbsp;{{ $address->address ?? ""}}</li> 
          <li>Locality : &nbsp;{{ $address->locality ?? ""}}</li> 
          <li>Landmark : &nbsp;{{ $address->landmark ?? ""}}</li> 
          <li>Pincode : &nbsp;{{ $address->pincode ?? ""}}</li> 
          </ul>
          </div> 
          </div>
          </div>
          <div class="card-footer">
          <div class="task-board m-0">
            {{-- <button  class="btn btn-inverse btn-sm b-none" onclick="editAddress({{$address->id}})">Set Primary</button> --}}
            <button  class="btn btn-success btn-sm b-none" onclick="editAddress({{$address->id}})">Edit</button>
            <button  class="btn btn-danger btn-sm b-none" onclick="deleteAddress({{$address->id}})">Delete</button> 
          </div>
          </div>
          
          </div>
          </div>
          @endforeach
        </div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
@endif