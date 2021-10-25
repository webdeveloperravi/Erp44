
<section id="basic-input">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create</h5>
         </div>
        <div class="card-body">
            <form  onsubmit="event.preventDefault();" id="createForm">
          <div class="row">
              @csrf
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" />
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Alias</label>
                <input name="alias" type="text" class="form-control" id="alias" placeholder="Enter Alias" />
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Select parent</label>
                <select class="form-control" name="parent_id" id="parentId"> 
                  <option value="0">{{ auth('store')->user()->name }}</option>
                  @foreach ($parentRoles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
              </div> 
            </div> 
            <div class="col-12">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Description"
                ></textarea>
              </div>
            </div>  
            <div class="col-12">
              <div class="form-group">
                <button class="btn btn-primary" onclick="store()">Submit</button>
                <button class="btn btn-danger" onclick="closeCreate()">Close</button>
              </div>
            </div> 
          </div>
      </form>  
        </div>
      </div>
    </div>
  </div>
</section>
