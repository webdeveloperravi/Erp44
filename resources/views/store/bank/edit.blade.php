<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
   
    <div class="card">
      <div class="card-footer " style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-center">Edit Bank Account</h5>
       </div>
     <div class="card-body">

       <form id="editBankAccount" onsubmit="event.preventDefault();">
           @csrf
            <input type="hidden" name="bankAccountId"  value="{{$bankAccountEdit->id}}">
           <div class="row">
              @csrf
              
              {{-- <div class="col-xl-4 col-md-6 col-12 mb-1">
                 <div class="form-group">
                   <label for="parentId">Select Account Group</label>
                   <select class="form-control" name="account_group_id">
                     @foreach ($accountGroups as $group)
                     @if ($group->id == 12 || $group->id == 13)
                     @if ($group->id == $bankAccountEdit->account_group_id)
                     <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                     @else
                     <option value="{{ $group->id }}">{{ $group->name }}</option>
                     @endif
                     @endif
                     @endforeach
                   </select>
                 </div> 
               </div>   --}}
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                 <div class="form-group">
                    <label for="basicInput">Account Name</label>
                 <input name="name" type="text" id="name" class="form-control" value="{{$bankAccountEdit->name}}" autocomplete="off"/>
                 </div>
              </div>  
            </div>
            <div class="row justify-content-end">
              <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateAccount()">Update</button> 
              <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
            </div>
             
             {{-- <div class="form-group row py-3 justify-content-right" >
            <div class="col">
            <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateAccount()">Update</button> 
            <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
          </div>
        
        </div>  --}}
    </form>
     </div>
         </div>
    </div>
  <div class="md-overlay"></div>

  <script type="text/javascript">
      $(document).ready(function(data){
        $("#name").focus();
      });
      
     function updateAccount(){
     let url ="{{route('bank.account.update')}}";
  let formData = $("#editBankAccount").serialize();
 
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
