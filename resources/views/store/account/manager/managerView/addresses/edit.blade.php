{{-- <div class="card" id="form"> --}}
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Address</h5>
     </div> 
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="editForm" onsubmit="event.preventDefault();">
      @csrf
     <div class="row">
              @csrf
              <input type="hidden" name="addressId" value="{{$address->id}}">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Address Type</label>
                <select class="form-control" name="address_type_id"> 
                  @foreach ($addressTypes as $type)
                  @if ($type->id == $address->address_type_id)
                  <option value="{{ $type->id}}" selected>{{ $type->name }}</option>    
                  @else
                  <option value="{{ $type->id}}">{{ $type->name }}</option>    
                  @endif
                  @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Country</label>
                <select class="form-control" name="country_id" id="countryId" onchange="getState()">
                  <option value="0" selected>Select Country</option> 
                  @foreach ($countries as $country)
                  <option value="{{ $country->id }}" {{$address->country_id==$country->id? 'selected' : ''}}>{{ $country->name }}</option>    
                  @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="state">
                <label for="parentId">State</label>
                <select class="form-control" name="state_id"  onchange="getCity(),getTown()">
                  @foreach ($states as $state)
                  @if ($state->id == $address->state_id)
                  <option value="{{ $state->id }}" selected>{{$state->name }}</option> 
                  @else
                  <option value="{{ $state->id }}">{{ $state->name }}</option> 
                  @endif
                  @endforeach
                </select>
              </div> 
            </div>  
            
            
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="city">
                <label for="parentId">City</label>
                <select class="form-control" name="city_id"  >
                @foreach ($cities as $city)
                @if ($city->id == $address->city_id) 
                <option value="{{ $city->id }}" selected>{{ $city->name }}</option> 
                @else 
                <option value="{{ $city->id }}">{{ $city->name }}</option> 
                @endif
                @endforeach
                </select>
              </div> 
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="town">
                <label for="parentId">Town</label>
                <select class="form-control" name="town_id"  >
                  @foreach ($cities as $city)
                  @if ($city->id == $address->town_id) 
                  <option value="{{ $city->id }}" selected>{{ $city->name }}</option> 
                  @else 
                  <option value="{{ $city->id }}">{{ $city->name }}</option> 
                  @endif
                  @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Address</label>
                  <input name="address" type="text" class="form-control"  value="{{ $address->address }}"/>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Locality</label>
                  <input name="locality" type="text" class="form-control"  value="{{ $address->locality }}"/>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Landmark</label>
                  <input name="landmark" type="text" class="form-control"  value="{{ $address->landmark }}" />
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Pincode</label>
                  <input name="pincode" type="text" class="form-control"  value="{{ $address->pincode }}" />
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="updateAddress()">Update Address</button>
                    <button class="btn btn-danger" onclick="($('#createAddress').html(''))">Close</button>
                  </div>
            </div>  
          </div>
     </form>
  </div>
 {{-- </div> --}}
 <script>
    

   function getState(){
         var countryId = $("#countryId").val();
         var url = "{{ route('lead.get.state',['/']) }}/"+countryId;
         $.get(url,function(data){
            $("#state").html(data);
         });
     }

     function getCity(){

         var stateId = $("#stateId").val();
         var url = "{{ route('lead.get.city',['/']) }}/"+stateId;
         $.get(url,function(data){
            $("#city").html(data);
         });
     }
     
     function getTown(){

        var stateId = $("#stateId").val();
        var url = "{{ route('lead.get.town',['/']) }}/"+stateId;
        $.get(url,function(data){
          $("#town").html(data);
        });
        }
 </script>