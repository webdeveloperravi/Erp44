 <div class="card">
    <div class="card-footer " style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-center">Edit Store View Master</h5>
           </div> 
     
    <div class="card-body">
       
      <form id="editVoucher" onsubmit="event.preventDefault();">
         @csrf
          <input type="hidden" name="masterId"  value="{{$master->id}}">
         <div class="row">
            @csrf   
            
                <div class="col-xl-6 col-md-6 col-12 mb-1">
                  <div class="form-group">
                    <label for="basicInput">Domain</label>
                    <input name="domain" type="text" value="{{ $master->domain }}" class="form-control"  placeholder="Enter Domain" />
                  </div>
                </div>  
                <div class="col-xl-4 col-md-6 col-12 mb-1 ">
                  <label for="basicInput">Phone</label>
                     <div class="row row-no-padding">
                       <div class="col-xl-3 col-3 p-r-0">
                       <select class="form-control" name="phone_country_code_id" >
                       @foreach ($countryCodes->sortBy('phonecode') as $code)
                       @if($code->id == $master->phone_country_code_id)
                       <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                       @else    
                       <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                       @endif
                       @endforeach   
                       </select>
                     </div>
                       <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                       <input name="phone" type="number" value="{{ $master->phone }}" class="form-control" value="{{ $master->phone ?? "" }}" autocomplete="new-password"/>
                       </div>
                     </div>
                     </div> 
                 <div class="col-xl-4 col-md-6 col-12 mb-1">
                   <div class="form-group">
                     <label for="basicInput">Email</label>
                     <input name="email" type="text" value="{{ $master->email }}" class="form-control"  placeholder="Email" autocomplete="new-password"/>
                   </div>
                 </div> 
                 
                <div class="col-xl-6 col-md-6 col-12 mb-1">
                  <div class="form-group">
                    <label for="basicInput">Address</label>
                    <input name="address" type="text" value="{{ $master->address }}" class="form-control"  placeholder="Enter Address" />
                  </div>
                </div>   
        </div>
           
           <div class="form-group row py-3 justify-content-right" >
          <div class="col">
          <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="update()">Update</button> 
          <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
        </div>
        </div>
     
     
  </form>
    </div>
   </div>
  <script type="text/javascript">
     
     function update(){
     let url ="{{route('storeViewMaster.update')}}";
  let formData = $("#editVoucher").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#edit").html('');
                all();
               }else{
                  $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
               }
            }, 
        });
    }


    function hideErrors(){ 
   $(".text-danger").remove(); 
 }
 

  </script>
