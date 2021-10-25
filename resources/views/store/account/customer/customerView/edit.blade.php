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
              <label for="basicInput">Phone</label>
              <div class="input-group input-group-dropdow">
                <div class="input-group-bt">
                <select class="form-control" name="phone_country_code_id" style="width: 80px" >
                @foreach ($countryCodes->sortBy('phonecode') as $code)
                @if($code->id == $store->phone_country_code_id)
                <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                @else    
                <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                @endif
                @endforeach   
                </select>
                </div>
                <input name="phone" type="number" value="{{ $store->phone }}" class="form-control" id="phone"autocomplete="new-password"/>
                </div>
            </div>
          </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Whats App</label>
              <div class="input-group input-group-dropdow">
                <div class="input-group-bt">
                <select class="form-control" name="whats_app_country_code_id" style="width: 80px" >
                @foreach ($countryCodes->sortBy('phonecode') as $code)
                @if($code->id == $store->whats_app_country_code_id)
                <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                @else    
                <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                @endif
                @endforeach   
                </select>
                </div>
                <input name="whats_app" value="{{ $store->whats_app }}" type="number" class="form-control" autocomplete="new-password"/>
                </div>
            </div>
          </div>
           <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Email</label>
                 <input name="email" type="text" class="form-control"  placeholder="Email" value="{{$store->email}}" autocomplete="off"/>
              </div>
           </div>  
          
          
          <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group"> 
         <button class="btn btn-success saveZone   m-0 mr-4" onclick="updateAccount()">Update</button> 
         <button class="btn btn-danger  m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
       </div>
      </div>
     </div> 
 </form>
        </div>  
    </div>
 <script type="text/javascript">
  

  function updateAccount(){
    var formData =$("#editAccount").serialize();
    $.ajax({
        
         url :"{{route('customerAccount.update')}}",
         method : "POST",
         data   : formData,
         success : function(data)
         {   
           if(data.errors){
               $.each(data.errors,function(field_name,error){
                       $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
           }); 
           setTimeout(hideErrors,5000); 
         }else{
           $("#edit").html('');
            swal(data.message);
              location.reload();
         }
         }
      });
    }


 </script>
