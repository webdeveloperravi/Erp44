<section id="basic-input">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit</h5>
         </div>
        <div class="card-body">
            <form  onsubmit="event.preventDefault();" id="updateform">
          <div class="row">
              @csrf
              <input type="hidden" name="groupId" value="{{$groupEdit->id}}">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text" class="form-control" id="name" value="{{$groupEdit->name}}" />
              </div>
            </div> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Alias</label>
                <input name="alias" type="text" class="form-control" id="alias" value="{{$groupEdit->alias}}" />
              </div>
            </div> 

            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Select Primary</label>
                <select class="form-control" name="primary" id="primary" onchange="addGroup(this.value)">
                <option  value="1" {{$groupEdit->account_primary == '1' ? "selected" : ""}}>Yes</option>
                <option  value="0" {{$groupEdit->account_primary == '0' ? "selected" : ""}}>No</option>
                </select>
              </div> 
            </div>

            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Select Parent</label>
               <select class="form-control" name="parent_id" id="parentId"> 
                @foreach($accountGroups as $group)
                  @if($groupEdit->parent_id == $group->id)
                 <option value="{{$group->id}}" selected="">{{$group->name}}</option>
                 @elseif($groupEdit->id==$group->id)
                 @continue
                 @else
                  <option value="{{$group->id}}" >{{$group->name}}</option>
                  @endif
                 
                @endforeach
                </select>
              </div> 
            </div>
                     
           <div class="col-xl-4 col-md-10 col-12 mb-1">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3"
                >{{$groupEdit->description}}</textarea>
              </div>
            </div>  
            <div class="col-12">
              <div class="form-group">
                <button class="btn btn-primary" onclick="update()">Update Group</button>
                <button class="btn btn-danger" onclick="$('#edit').html('')">Close</button>
              </div>
            </div> 
          </div>
      </form>  
        </div>
      </div>
    </div>
  </div>
  
</section>
<script type="text/javascript">
  
     addGroup({{$groupEdit->account_primary}});
    
    function update(){
              $.ajax({
             method:"POST",
            url : "{{ route('account.group.update') }}",
            data :  $("#updateform").serialize(),
            success : function(data){
                $("#edit").html("");
                all();
            },
        });
    }

  
      
</script>