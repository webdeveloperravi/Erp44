    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Contact</h5>
       </div>
      
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
          <button type="button" class="close" data-dismiss="alert">×</button>
        <ul id="res"></ul>
      </div>
      <form id="updateForm" onsubmit="event.preventDefault();" >
        @csrf
       <div class="row">
                @csrf
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <input type="hidden" name="contactId" value="{{$contact->id}}">
                <div class="form-group">
                  <label for="basicInput">Name</label>
                  <input name="name" type="text"  class="form-control" value="{{$contact->name}}"  autocomplete="new-password"/>
                </div>
              </div> 
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Phone</label>
                  <div class="input-group input-group-dropdow">
                    <div class="input-group-bt">
                    <select class="form-control" name="phone_country_code_id" style="width: 80px" >
                    @foreach ($countryCodes->sortBy('phonecode') as $code)
                    @if($code->id == $contact->phone_country_code_id)
                    <option value="{{ $code->id }}" selected>+{{$code->phonecode }}</option>
                    @else    
                    <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                    @endif
                    @endforeach   
                    </select>
                    </div>
                    <input name="phone" type="number" class="form-control" id="phone"autocomplete="new-password" value="{{$contact->phone ?? ''}}" />
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
                    @if($code->id == $contact->whats_app_country_code_id)
                    <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                    @else    
                    <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                    @endif
                    @endforeach   
                    </select>
                    </div>
                    <input name="whats_app" type="number" class="form-control" value="{{$contact->whats_app ?? ''}}" autocomplete="new-password"/>
                    </div>
                </div>
              </div>  
              
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Email</label>
                  <input name="email" type="text" class="form-control"  placeholder="Email" autocomplete="new-password" value="{{$contact->email}}" />
                </div>
              </div>  
              <div class="col-xl-4 col-md-6 col-12 my-auto">
                  <div class="form-group mt-lg-4"> 
                      <button class="btn btn-warning" onclick="update()">Update Contact</button>
                      <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                    </div>
              </div>  
              
            </div>
       </form>
    </div>
   </div> 
<div class="md-overlay"></div>

 