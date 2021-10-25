

{{-- <div class="md-modal md-effect-1 modal-lg md-show" id="modal-1">
  <div class="md-content">
  <h3>Modal Dialog</h3>
  <div>
  <p>This is a modal window. You can do the following things with it:</p>
  <ul>
  <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
  <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
  <li><strong>Close:</strong> click on the button below to close the modal.</li>
  </ul>
  <button type="button" class="btn btn-primary waves-effect md-close">Close</button>
  </div>
  </div>
  </div> --}}
  
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Contact</h5>
       </div>
      
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
          <button type="button" class="close" data-dismiss="alert">×</button>
        <ul id="res"></ul>
      </div>
      <form id="createForm" onsubmit="event.preventDefault();" >
        @csrf
       <div class="row">
                @csrf
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <input type="hidden" name="leadId" value="{{$leadId}}">
                <div class="form-group">
                  <label for="basicInput">Name</label>
                  <input name="name" type="text"  class="form-control"  placeholder="Name"  autocomplete="new-password"/>
                </div>
              </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Phone</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                  <select class="form-control" name="phone_country_code_id">
                    @foreach ($countryCodes->sortBy('phonecode') as $code)
                    @if($code->id == $countryCode->id)
                    <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                    @else    
                    <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                    @endif
                    @endforeach   
                    </select>
                    </div>
            
                     <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                    <input name="phone" type="number" class="form-control" id="phone"autocomplete="new-password"/>
                    </div>
                </div>
              </div> 
  
  
               <div class="col-xl-4 col-md-6 col-12 mb-1 ">
            <label for="basicInput">Whats App</label>
                <div class="row row-no-padding">
                  <div class="col-xl-3 col-3 p-r-0">
                    <select class="form-control" name="whats_app_country_code_id">
                    @foreach ($countryCodes->sortBy('phonecode') as $code)
                    @if($code->id == $countryCode->id)
                    <option value="{{ $code->id }}" selected>+{{ $code->phonecode }}</option>
                    @else    
                    <option value="{{ $code->id }}">{{ $code->phonecode }}</option>    
                    @endif
                    @endforeach   
                    </select>
                    </div>
                     <div class="col-xl-9 col-9 m-l-0 p-l-0"> 
                    <input name="whats_app" type="number" class="form-control" autocomplete="new-password"/>
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
                      <button class="btn btn-primary" onclick="save()">Save Contact</button>
                      <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                    </div>
              </div>  
              
            </div>
       </form>
    </div>
   </div> 
  

 
<div class="md-overlay"></div>