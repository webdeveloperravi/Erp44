 <div class="card">
    <div class="card-footer " style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-center">Edit User</h5>
           </div> 
     
    <div class="card-body">
      <form id="editVoucher" onsubmit="event.preventDefault();">
         @csrf
          <input type="hidden" name="userId"  value="{{$user->id}}">
         <div class="row">
            @csrf 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                 <label for="parentId">Select Role</label>
                 <select class="form-control" name="role">
                   <option value="0" selected>Select Role</option> 
                   @foreach ($roles as $role)
                   @if ($role->id == $user->role_id)
                   <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                   @else
                   <option value="{{ $role->id }}">{{ $role->name }}</option>
                   @endif
                 @endforeach
                 </select>
               </div> 
             </div> 
             <div class="col-xl-6 col-md-6 col-12 mb-1">
             <div class="form-group">
               <label for="basicInput">Name</label>
               <input name="name" type="text" class="form-control" value="{{ $user->name ?? "" }}">
             </div>
           </div>  
           <div class="col-xl-4 col-md-6 col-12 mb-1 ">
             <label for="basicInput">Phone</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="phone_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $user->phone_country_code_id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="phone" type="number" class="form-control" value="{{ $user->phone ?? "" }}" autocomplete="new-password"/>
                  </div>
                </div>
                </div> 
            
                <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Whats App</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="whats_app_country_code_id" >
                  @foreach ($countryCodes->sortBy('phonecode') as $code)
                  @if($code->id == $user->whats_app_country_code_id)
                  <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                  @else    
                  <option value="{{ $code->id}}">{{ $code->phonecode }}</option>    
                  @endif
                  @endforeach   
                  </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="whats_app" type="number" class="form-control" value="{{ $user->whats_app ?? "" }}" autocomplete="new-password"/>
                  </div>
                </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12 mb-1 ">
              <div class="form-group">
                <label for="basicInput">Email</label>
                <input name="email" type="text" class="form-control"  value="{{ $user->email ?? "" }}" autocomplete="new-password"/>
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
     let url ="{{route('adminUser.update')}}";
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
