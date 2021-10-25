
 <div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Social Media Type</h5>
     </div>
    
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="createForm" onsubmit="event.preventDefault();" >
      @csrf
     <div class="row"> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text"  class="form-control"  placeholder="Name"  autocomplete="new-password"/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Alias</label>
                <input name="alias" type="text" class="form-control"  placeholder="Alias" autocomplete="new-password"/>
              </div>
            </div> 
            <div class="col-xl-4 col-md-10 col-12 mb-1">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Description"
                ></textarea>
              </div>
            </div>  
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="store()">Save</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>  
            
          </div>
     </form>
  </div>
 </div> 