
 <div class="card">
    <!--Header ---->
    <div class="card-footer " style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-center">Add Admin User</h5>
     </div>
    
    <div class="card-body">
   
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
     <div class="row">
              @csrf
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="parentId">Select Role</label>
                  <select class="form-control" name="role">
                    <option value="0" selected>Select Role</option> 
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                  </select>
                </div> 
              </div> 
            <div class="col-xl-6 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text" class="form-control"  placeholder="Enter Name" />
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
                 <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="store()">Save</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>  
     </form>
  </div>
 </div>
 <script>
    
    function store(){

  let url ="{{route('adminUser.store')}}";
  let formData = $("#createForm").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#create").html('');
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