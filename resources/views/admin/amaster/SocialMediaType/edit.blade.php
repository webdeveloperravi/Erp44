<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Type </h5>
       </div>
       <form id="editForm" onsubmit="event.preventDefault();" class="pt-3"> 
      <div class="modal-body">
                @csrf
                <input type="hidden" name="typeId"  value="{{$type->id}}"> 
                <div class="col-xl-12 col-md-12 col-12 mb-1">
                  <div class="form-group">
                    <label for="basicInput">Name</label>
                    <input name="name" type="text"  class="form-control"  placeholder="Name" value="{{ $type->name ?? '' }}"  autocomplete="new-password"/>
                  </div>
                </div> 
                <div class="col-xl-12 col-md-12 col-12 mb-1">
                  <div class="form-group">
                    <label for="basicInput">Alias</label>
                    <input name="alias" type="text" class="form-control" value="{{ $type->alias ?? '' }}" placeholder="Alias" autocomplete="new-password"/>
                  </div>
                </div> 
                <div class="col-xl-12 col-md-12 col-12 mb-1">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea name="description" class="form-control" id="description"  rows="3" placeholder="Description"
                    >{{ $type->description }}</textarea>
                  </div>
                </div>    
               
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="update()">Update</button>
        <button type="button" class="btn btn-secondary" onclick="$('#edit').html('')">Close</button>
      </div>
    </form> 
    </div>
  </div>
</div>

 <div class="md-overlay"></div>

 