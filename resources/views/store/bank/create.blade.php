
 <div class="card">
    <!--Header ---->
    <div class="card-footer " style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-center">Link Bank Account</h5>
     </div>
    
    <div class="card-body">
   
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
              <div class="row">
              {{-- <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Select Account Group</label>
                <select class="form-control" name="account_group_id">
                  @foreach ($accountGroups as $group)
                  @if ($group->id == 12)
                  <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                  @endif
                  @endforeach
                </select>
              </div> 
            </div>   --}}
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Account Name</label>
                <input name="accountName" type="text" id="name" class="form-control"  placeholder="Account Name" />
              </div>
            </div> 
            {{-- <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Account Number</label>
                <input name="accountNumber" type="text" class="form-control"  placeholder="Account Number" />
              </div>
            </div>  --}}
            {{-- <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="ifscCode">IFSC Code</label>
                <input name="ifscCode" type="number" class="form-control" id="phone"  placeholder="IfSC Code "/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Swift Code (optional)</label>
                <input name="swiftCode" type="text" class="form-control"  placeholder="Swift Code " />
              </div>
            </div>  --}}
                 <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="linkAccount()">Submit</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>  
     </form>
  </div>
 </div>
 <script>
    $("#name").focus();
    function linkAccount(){

  let url ="{{route('bank.account.store')}}";
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