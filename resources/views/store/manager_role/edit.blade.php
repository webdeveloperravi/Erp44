
<section id="basic-input">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit</h5>
         </div>
        <div class="card-body">
            <form  onsubmit="event.preventDefault();" id="updateForm">
          <div class="row">
              @csrf
              <input type="hidden" name="roleId" value="{{ $role->id }}">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text" class="form-control" value="{{ $role->name }}" id="name" placeholder="Enter Name" />
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Alias</label>
                <input name="alias" type="text" class="form-control" value="{{ $role->alias }}" id="alias" placeholder="Enter Alias" />
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Basic Select</label>
                {{-- <select class="form-control" name="parent_id" id="parentId">
                  <option value="0">Select parent</option>
                  @foreach ($parentRoles as $parentRole)
                      @if($parentRole->id == $role->parent_id)
                      <option value="{{ $parentRole->id }}" selected>{{ $parentRole->name }}</option>
                      @elseif($parentRole->id == $role->id)
                       @continue
                      @else
                      <option value="{{ $parentRole->id }}">{{ $parentRole->name }}</option>
                      @endif
                  @endforeach
                </select> --}}
                <select class="form-control" name="parent_id" id="parentId">
                  <option value="0">Select parent</option>
                  @foreach ($parentRoles as $parentRole)
                      @continue(in_array($parentRole->id,$childrenRoles))
                      @continue($parentRole->id == $role->id)
                      @if($parentRole->id == $role->parent_id)
                      <option value="{{ $parentRole->id }}" selected>{{ $parentRole->name }}</option>
                      @else
                      <option value="{{ $parentRole->id }}">{{ $parentRole->name }}</option>
                      @endif
                  @endforeach
                </select>
              </div> 
            </div> 
            <div class="col-12">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Description"
                >{{ $role->description }}</textarea>
              </div>
            </div>  
            <div class="col-12">
              <div class="form-group">
                <button class="btn btn-primary" onclick="update()">Submit</button>
                <button class="btn btn-danger" onclick="closeUpdate()">Close</button>
              </div>
            </div> 
          </div>
      </form>  
        </div>
      </div>
    </div>
  </div>
</section>
