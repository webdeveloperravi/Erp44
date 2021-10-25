<div class="card"> 
<div class="card-footer p-0" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Lead</h5>
    </div>
       
<div class="card-body"> 
    
    <form id="editLead" onsubmit="event.preventDefault();">
        @csrf
         <input type="hidden" name="leadId"  value="{{$lead->id}}">
        <div class="row">
           @csrf
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Name</label>
              <input name="name" type="text" class="form-control"  placeholder="Owner Name" value="{{$lead->name}}" autocomplete="new-password"/>
              </div>
           </div>
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Company</label>
                 <input name="company" type="text" class="form-control"  placeholder="Company Name"  value="{{$lead->company}}" autocomplete="new-password"/>
              </div>
           </div>
        <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            
                <label for="basicInput">Phone</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="phone_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $lead->phone_country_code_id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="phone" type="number" class="form-control" id="phone" autocomplete="new-password" value="{{$lead->phone ?? ''}}"  {{$lead->phone_verify == 1 ? 'readonly' : ''}} />
                  </div>
                </div>
                </div>
         <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            
                <label for="basicInput">Whats App</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="whats_app_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $lead->phone_country_code_id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="whats_app" type="number" class="form-control" id="phone" autocomplete="new-password" value="{{$lead->whats_app ?? ''}}"  {{$lead->phone_verify == 1 ? 'readonly' : ''}}/>
                  </div>
                </div>
                </div>  
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Email</label>

                 <input name="email" type="text" class="form-control"  placeholder="Email" value="{{$lead->email}}" autocomplete="new-password" {{$lead->email_verify == 1 ? 'readonly' : ''}}/>
              </div>
           </div>
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="parentId">Lead Type</label>
                 <select class="form-control" name="lead_type_id"  >
                    <option value="0" selected>Select Lead type</option>
                     @foreach($leadTypes  as $type)
                      <option value="{{$type->id}}" {{$type->id==$lead->lead_type_id ? 'selected' : ''}}>{{$type->name}}</option>
                     @endforeach
                 </select>
              </div>
           </div>
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="parentId">Lead Status</label>
                 <select class="form-control" name="lead_status_id"  >
                    <option value="0" selected>Select Status</option>
                     @foreach($leadStatuses  as $status)
                      <option value="{{$status->id}}" {{$status->id==$lead->lead_status_id ? 'selected' : ''}}>{{$status->name}}</option>
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
                @if ($source->id == $lead->lead_source_id)
                   <option value="{{ $source->id }}" selected>{{ $source->name }}</option> 
                @endif
                <option value="{{ $source->id }}">{{ $source->name }}</option>
              @endforeach
               
              </select>
            </div> 
          </div>  
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="parentId">Address Type</label>
              <select class="form-control" name="address_type_id"> 
                @foreach ($addressTypes as $type)
                 @if ($type->id == $lead->address_type_id ?? '')
                <option value="{{ $type->id }}"  selected>{{ $type->name }}</option>  
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
                @if ($country->id == $lead->country_id)
                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>    
                @else
                <option value="{{ $country->id }}">{{ $country->name }}</option>    
                @endif
                @endforeach
              </select>
            </div> 
          </div>  
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group" id="state">
              <label for="parentId">State</label>
              <select class="form-control" name="state_id" id="stateId" onchange="getCity(),getTown()">
               @foreach ($states as $state)
               @if ($state->id == $lead->state_id)
               <option value="{{ $state->id }}" selected>{{ $state->name }}</option>    
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
               @if ($city->id == $lead->city_id)
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
               @if ($city->id == $lead->town_id)
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
                <textarea name="address" class="form-control" autocomplete="new-password">{{$lead->address}}</textarea>
                <!-- <input name="address" type="text" class="form-control" value="{{ $lead->address }}"  placeholder="Address" /> -->
              </div>
            </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Locality</label>
                <input name="locality" type="text" class="form-control" value="{{ $lead->locality }}"  autocomplete="new-password" />
              </div>
            </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Landmark</label>
                <input name="landmark" type="text" class="form-control" value="{{ $lead->landmark }}"  autocomplete="new-password"/>
              </div>
            </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Pincode</label>
                <input name="pincode" type="text" class="form-control" value="{{ $lead->pincode }}"  placeholder="Pincode" autocomplete="new-password" />
              </div>
            </div>  
           
           </div>
          
          <div class="form-group row py-3 justify-content-right" >
         <div class="col">
         <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateLead()">Update</button> 
         <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
       </div>
     
     </div> 
 </form>
        </div>  
    </div>
 <script type="text/javascript">
    function updateLead(){
    
    var formData =$("#editLead").serialize();
    $.ajax({
        
         url : "{{route('lead.update')}}",
         method : "POST",
         data   : formData,
         success : function(data)
         {   
           if(data.errors){
               $.each(data.errors,function(field_name,error){
                       $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                      $(document).find('[name='+field_name+']').addClass('input-error');
                      var offset = $("#editLead").offset();
                      $('html, body').animate({
                     scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
           }); 
           setTimeout(hideErrors,5000); 
         }else{
            notify('Lead Updated','success');
            location.reload();
                $("#edit").html('');
         }
         }
      });
    }

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

 function hideErrors(){ 
  $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  $('textarea').removeClass('input-error');
  $('select').removeClass('input-error');


}
 </script>
