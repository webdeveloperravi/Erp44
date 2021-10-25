<div class="card" id="form">
  <!--Header ---->
  <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Manager Account</h5>
   </div>
  
  <div class="card-body">
    <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
      <button type="button" class="close" data-dismiss="alert">×</button>
    <ul id="res"></ul>
  </div>
  <form id="createForm" onsubmit="event.preventDefault();">
    @csrf
   <div class="row">
            @csrf
          @if (auth('store')->user()->type == "lab")
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group" id="state">
              <label for="parentId">Create Manager For</label>
              <select class="form-control" name="store_id" onchange="getManagerRoles(this.value)">
                @foreach ($stores as $store)
                @if(auth('store')->user()->id == $store->id)
                <option value="{{ $store->id }}" selected>{{ $store->name }}</option>
                @else
                <option value="{{ $store->id }}">{{ $store->name }}</option> 
                @endif
                @endforeach
              </select>
            </div> 
          </div> 
          @endif
          <div class="col-xl-4 col-md-6 col-12 mb-1" id="managerRoles">
              <div class="form-group" id="state">
                <label for="parentId">Manager Role</label>
                <select class="form-control" name="manager_role_id">
                  @foreach ($managerRoles as $role) 
                  <option value="{{ $role->id }}">{{ $role->name }}</option> 
                  @endforeach
                </select>
              </div> 
          </div>     
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Name</label>
              <input name="name" type="text" class="form-control"  placeholder="Manager Name" />
            </div>
          </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Phone</label>
              <input name="phone" type="number" class="form-control" id="phone"/ placeholder="Phone">
            </div>
          </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Email</label>
              <input name="email" type="text" class="form-control"  placeholder="Email" />
            </div>
          </div>   
          <div class="col-xl-4 col-md-6 col-12 my-auto">
              <div class="form-group mt-lg-4"> 
                  <button class="btn btn-primary" onclick="saveManager()">Create Manager</button>
                  <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                </div>
          </div>  
        </div>
   </form>
</div>
</div>
<script>
  
</script>