 <div class="card"> 
   <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Account
     </h5>
          </div>
       
<div class="card-body"> 
    
    <form id="editAccount" onsubmit="event.preventDefault();">
        @csrf
         <input type="hidden" name="accountId"  value="{{$store->id}}">
        <div class="row">
           @csrf
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Name</label>
              <input name="name" type="text" class="form-control"  placeholder="Owner Name" value="{{$store->name}}" autocomplete="off"/>
              </div>
           </div> 
           <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="parentId">Select Role</label>
              <select class="form-control" name="role_id">
                <option value="">Select Role</option>
              
              </select>
            </div> 
          </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Phone</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                <select class="form-control" name="phone_country_code_id" >
                @foreach ($countryCodes->sortBy('phonecode') as $code)
                @if($code->id == $store->phone_country_code_id)
                <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                @else    
                <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                @endif
                @endforeach   
                </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                 <input name="phone" type="number" value="{{ $store->phone }}" class="form-control" id="phone"autocomplete="new-password" {{$store->phone_verify == 1 ? 'readonly' : ''}} />
                </div>
            </div>
          </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Whats App</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                <select class="form-control" name="whats_app_country_code_id">
                @foreach ($countryCodes->sortBy('phonecode') as $code)
                @if($code->id == $store->whats_app_country_code_id)
                <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                @else    
                <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                @endif
                @endforeach   
                </select>
                </div>
                  <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                  <input name="whats_app" value="{{ $store->whats_app }}" type="number" class="form-control" autocomplete="new-password" {{$store->phone_verify == 1 ? 'readonly' : ''}}/>
                </div>
            </div>
          </div>
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Email</label>
                 <input name="email" type="text" class="form-control"  placeholder="Email" value="{{$store->email}}" autocomplete="off" {{$store->phone_verify == 1 ? 'readonly' : ''}} />
              </div>
           </div>
          
       <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group"> 
         <button class="btn btn-success saveZone   m-t-25" onclick="updateAccount()">Update</button> 
         <button class="btn btn-danger   m-t-25" onclick="$('#edit').html('')">Close</button>  
       </div>
      </div>
     </div> 
 </form>
        </div>  
 <script type="text/javascript">
    function updateAccount(){
    var formData =$("#editAccount").serialize();
    $.ajax({
        
         url : "{{route('subStore.managerAccount.update')}}",
         method : "POST",
         data   : formData,
         success : function(data)
         {   
           if(data.errors){
               $.each(data.errors,function(field_name,error){
                       $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                       $(document).find('[name='+field_name+']').addClass('input-error');
           }); 
           setTimeout(hideErrors,5000); 
         }else{
             $("#edit").html('');
            //swal(data.message);
            location.reload();
         }
         }
      });
    }
    
    function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error'); 
   $("select").removeClass('input-error'); 
 }
 



 </script>
