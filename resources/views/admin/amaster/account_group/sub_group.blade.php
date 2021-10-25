<ul class="listree-submenu-items">
                          @foreach ($group->subGroups as $group)
                          <li style="" class="saab">
                            <div class="listree-submenu-heading btn btn-block {{ $group->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1">{{ $group->name }}
                              @if ($group->status == '1')
                              <button class="btn btn-danger btn-sm p-1 float-right" onclick="updateStatus({{$group->id}},'0')"   ><i class="fa fa-ban"></i></button>
                              @else
                              <button class="btn btn-success btn-sm p-1 float-right" onclick="updateStatus({{$group->id}},'1')"  ><i class="fa fa-check"></i></button>
                              @endif   
                              <button class="btn btn-sm btn-warning mr-1 p-1 float-right" onclick="edit({{$group->id}})"  > <i class="fa fa-edit"></i></button>
                            
                            </div> 
                        </li> 
          @includeWhen($group->subGroups->count() > 0,'admin.amaster.account_group.sub_group',['group'=>$group])

    @endforeach
   </ul>