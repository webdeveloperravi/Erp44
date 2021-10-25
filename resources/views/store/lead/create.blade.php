
 <div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Lead</h5>
     </div>
    
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="createForm" onsubmit="event.preventDefault();" >
      @csrf
     <div class="row"> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text"  class="form-control"  placeholder="Name"  autocomplete="new-password"/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Company</label>
                <input name="company" type="text" class="form-control"  placeholder="Company Name" autocomplete="new-password"/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1 ">
             <label for="basicInput">Phone</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="phone_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $countryCode->id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="phone" type="number" class="form-control" id="phone" autocomplete="new-password"/>
                  </div>
                </div>
                </div> 
            
            <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Whats App</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="whats_app_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $countryCode->id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="whats_app" type="number" class="form-control" id="phone" autocomplete="new-password"/>
                  </div>
                </div>
                </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Email</label>
                <input name="email" type="text" class="form-control"  placeholder="Email" autocomplete="new-password"/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Lead Type</label>
                <select class="form-control" name="lead_type_id">
                  <option value="0" selected>Select Lead type</option> 
                  @foreach ($leadTypes as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
                </select>
              </div> 
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Lead Status</label>
                <select class="form-control" name="lead_status_id">
                  <option value="0" selected>Select Status</option> 
                  @foreach ($leadStatuses as $status)
                  <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Lead Source</label>
                <select class="form-control" name="lead_source_id"  >
                  <option value="0" selected>Select Source</option>
                  @foreach ($leadSources as $source)
                  <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
                 
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Address Type</label>
                <select class="form-control" name="address_type_id"> 
                  @foreach ($addressTypes->sortBy('name') as $type)
                  @if ($type->id == '1')
                  <option value="{{ $type->id }}" selected>{{ $type->name }}</option>    
                  @else
                  <option value="{{ $type->id }}">{{ $type->name }}</option>    
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
                  <option value="{{ $country->id }}">{{ $country->name }}</option>    
                  @endforeach
                </select>
              </div> 
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group" id="state">
                <label for="parentId">State</label>
                <select class="form-control" name="state_id" id="stateId" onchange="getCity()">
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
                  <textarea name="address" class="form-control" placeholder="address" autocomplete="new-password" ></textarea>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Locality</label>
                  <input name="locality" type="text" class="form-control"  placeholder="Locality" autocomplete="new-password"/>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Landmark</label>
                  <input name="landmark" type="text" class="form-control"  placeholder="Landmark" autocomplete="new-password"/>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Pincode</label>
                  <input name="pincode" type="text" class="form-control"  placeholder="Pincode" autocomplete="new-password"/>
                </div>
              </div>  
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="saveLead()">Save Lead</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>  
            
          </div>
     </form>
  </div>
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

     
 
// $("input").on('focus',function(){
//   //  alert('saab');
//         hideErrors();
//      });
 </script>