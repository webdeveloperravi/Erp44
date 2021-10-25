<ul class="listree-submenu-items">
                          @foreach ($group->subGroups as $group)
                          <li style="margin-left:30px;" class="saab">
                            <div class="listree-submenu-heading btn btn-block {{ $group->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1">{{ $group->name }}
                              @if ($group->user_store_id == auth('store')->user()->id)
                              <button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$group->id}})"  style="width:60px;">{{($group->status==1?"Disable":"Enable")}}</button>
                              <button class="btn btn-sm btn-warning mr-1 p-1 float-right" onclick="edit({{$group->id}})" style="width:60px;"> edit</button>
                              @endif
                            
                            </div> 
                        </li> 
          @includeWhen($group->subGroups->count() > 0,'store.account_group.sub_group',['group'=>$group])

    @endforeach
   </ul>