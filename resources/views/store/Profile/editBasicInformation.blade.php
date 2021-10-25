<div class="md-modal md-effect-1 md-show editModal" id="modal-1"> 
   <div class="card">
       <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Basic Information</h5>
       </div> 
       <div class="card-body">
         <form id="basicInformationForm" onsubmit="event.PreventDefault(0)"> 
            @csrf 
            <input type="hidden" name="authUserId" value="{{ $authUser->id }}">
            <input type="hidden" name="authUserType" value="{{ $authUser->type }}">
            @if ($authUser->type == 'org' || $authUser->type == 'lab')
            <div class="row">
            <div class="col col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Name</label>
              <input name="name" type="text" class="form-control"   value="{{$authUser->name}}" autocomplete="off"/>
              </div>
           </div>
            <div class="col col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Company Name</label>
              <input name="company_name" type="text" class="form-control"   value="{{$authUser->company_name}}" autocomplete="off"/>
              </div>
           </div> 
            @endif
  
            @if ($authUser->type == 'user')
            <div class="col col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                 <label for="basicInput">Name</label>
              <input name="name" type="text" class="form-control"   value="{{$authUser->name}}" autocomplete="off"/>
              </div>
           </div>
            @endif 
            <div class="col col-xl-4 col-md-6 col-12 mb-1"> 
               
                        <label for="parentId" class="invisible d-block">Hidden</label>
                  <button type="button" class="btn btn-success" onclick="updateBasicInformation()">Update</button> 
           
                  <button type="button" name="cancel" class="btn btn-danger" onclick="($('#editBasicInformation').html(''))">Close</button>
               </div>
               </div>
            </div> 
            
         </form>
       </div>
       </div>
 </div>
 <div class="md-overlay"></div> 