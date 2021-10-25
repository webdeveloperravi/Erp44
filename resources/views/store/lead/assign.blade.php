<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Lead Assign </h5>
       </div>
      <div class="modal-body">
        <form id="leadAssignForm" onsubmit="event.preventDefault();" class="pt-3"> 
                @csrf
                <input type="hidden" name="leadId"  value="{{$lead->id}}"> 
                 <div class="col-xl-12 col-md-6 col-12 mb-1">
              <div class="form-group">
                  <label for="parentId">Select Manager</label>
                    <select class="form-control" name="manager_id" > 
                      @foreach ($managers as $manager)
                      @if ($lead->store_user_id == $manager->id)
                      @continue
                      @else
                      @if ($manager->type == 'lab' || $manager->type == 'org')
                      <option value="{{ $manager->id }}">{{ $manager->name ?? "" }} - ({{ $manager->role->name ?? "" }})</option>
                      @elseif($manager->type == 'user')
                      <option value="{{ $manager->id }}">{{ $manager->name ?? "" }} - ({{ $manager->managerRole->name ?? "" }})</option>
                      @endif
                   
                      @endif
                    @endforeach
                     
                    </select>
                </div>
              </div>
        </form>        
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="assignSave()">Assign</button>
        <button type="button" class="btn btn-secondary" onclick="$('#assign').html('')">Close</button>
      </div>
    </div>
  </div>
</div>

 <div class="md-overlay"></div>

 