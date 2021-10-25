 
  <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Store Role</h5>
     </div> 
    <div class="md-content"> 
    <div class="card-body">
    <form onsubmit="event.preventDefault()" id="editStoreRoleForm"> 
      @csrf 
       <input type="hidden" name="storeId"  value="{{$store->id}}">
       <div class="form-group">
        <label for="state">Store Role</label> 
        <select class="form-control" name="storeRole"> 
        
           @foreach ($storeRoles as $role)
           @if ($role->id == $store->role->id)
           <option value="{{ $role->id }}" selected>{{ $role->name }} - {{ $role->retailModel->retailType->name ?? "" }}</option>  
           @else
           <option value="{{ $role->id }}">{{ $role->name }} - {{ $role->retailModel->retailType->name ?? "" }}</option>  
           @endif
           @endforeach
        </select>
     </div>
        <div class="form-group row py-3 justify-content-right" >
          <div class="col">
               <button onclick="updateStoreRole()" class="btn btn-success float-right m-0 mr-4 ">Update</button>
        <button onclick="($('#editStoreRole').html(''))" class="btn btn-danger float-right m-0 mr-2">Close</button>
          </div>
      
      </div> 
 

     </form>
    </div>
    </div>

  </div>
  <div class="md-overlay"></div> 