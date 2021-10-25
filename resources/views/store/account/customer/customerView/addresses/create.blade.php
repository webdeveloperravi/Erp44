  
    
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
     <div class="row">
              @csrf
              <input type="hidden" name="account_id" value="{{$accountId}}">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Address Type</label>
                <select class="form-control" name="address_type_id" onchange="getState()"> 
                  @foreach ($addressTypes as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>    
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
                  <option value="{{ $country->id }}">{{ $country->name }}</option>    
                  @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="state">
                <label for="parentId">State</label>
                <select class="form-control" name="state_id"  >
                  <option value="0" selected>Select State</option> 
                </select>
              </div> 
            </div>  
            
           
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="city">
                <label for="parentId">City</label>
                <select class="form-control" name="city_id"  >
                  <option value="0" selected>Select City</option> 
                </select>
              </div> 
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="town">
                <label for="parentId">Town</label>
                <select class="form-control" name="town_id"  >
                  <option value="0" selected>Select Town</option> 
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Address</label>
                  <input name="address" type="text" class="form-control"  placeholder="Address" />
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Locality</label>
                  <input name="locality" type="text" class="form-control"  placeholder="Locality" />
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Landmark</label>
                  <input name="landmark" type="text" class="form-control"  placeholder="Landmark" />
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Pincode</label>
                  <input name="pincode" type="text" class="form-control"  placeholder="Pincode" />
                </div>
              </div>  
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="saveAddress()">Add Address</button>
                    <button class="btn btn-danger" onclick="($('#createAddress').html(''))">Close</button>
                  </div>
            </div>  
          </div>
     </form>
  </div> 
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