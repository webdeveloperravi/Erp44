<ul class="listree-submenu-items">
                          @foreach ($role->subRoles as $role)
                          <li style="margin-left:30px;" class="saab">
                            <div class="listree-submenu-heading btn btn-block {{ $role->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1">{{ $role->name }}  
                              {{-- <button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$role->id}})"  style="width:60px;">{{($role->status==1?"Disable":"Enable")}}</button> --}}
                              <button class="btn btn-warning mr-1 p-1 float-right" onclick="edit({{$role->id}})" style="width:60px;"> <i class="fa fa-edit"></i></button>
                              {{-- <a href="{{route('manager.role.module.edit',['id'=>$role->id])}}" class='btn btn-sm btn-success mr-1 mb-1 p-1 float-right'  style="width:82px;">Modules</a> --}}
                              <button class="btn btn-sm btn-primary p-1 float-right mr-1" onclick="editModules({{$role->id}})" style="width:60px;"> Modules</button>
                            </div> 
                        </li> 
          @includeWhen($role->subRoles->count() > 0,'store.manager_role.subrole',['role'=>$role])
    @endforeach
   </ul>