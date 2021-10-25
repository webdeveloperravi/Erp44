<div class="card">
  <!--Header ---->
  <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Admin Role</h5>
  </div>
  
  <div class="card-body"> 
    <form id="editForm" onsubmit="event.preventDefault()">
      @csrf
      <input type="hidden" name="id" value="{{ $role->id }}"> 
      <div class="row"> 
      <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
          <label for="parentId">Parent Role</label>
          <select name="parent_id"  class="form-control">
            <option value="0" selected="">Select Parent Role</option>
            @foreach($parent_roles as $parentRole)
            @if ($parentRole->id == $role->parent_id)
            <option value="{{ $parentRole->id }}" selected>{{ $parentRole->name }}</option>   
            @elseif($parentRole->id == $role->id)
            @continue
            @else
            <option value="{{$parentRole->id}}">{{$parentRole->name}}</option>
            @endif
            @endforeach
          </select>
        </div> 
      </div>  
      <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
          <label for="basicInput">Role Name</label>
          <input name="name" type="text" class="form-control" placeholder="Role Name" value="{{ $role->name }}"/>
        </div>
      </div> 
      <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
          <label for="basicInput">Alias</label>
          <input name="alias" type="text" class="form-control" placeholder="Alias" value="{{ $role->alias }}"/>
        </div>
      </div> 
       
      <div class="col-xl-4 col-md-6 col-12 my-auto">
          <div class="form-group mt-lg-4"> 
              <button class="btn btn-primary" onclick="updateConfigRole()">Update</button>
              <button class="btn btn-danger" onclick="closeForm()">Close</button>
            </div>
      </div>  
    </div> 
    </form>
  </div>
  
</div>