<ul  id="sortable" class="list-group list-group-flush" onmousemove="mouseFn('sortable')">
  @foreach($menu_list->sortBy('parent_sort') as $menu_key =>$menu_val)
  
  
  @if($menu_val->parent==0)
  
  <li class="list-group-item m-b-10 m-t-10 z-depth-0" id="parent_id_{{$menu_val->id}}">{{$menu_val->title}}{{-- -{{$menu_val->id}} --}}
    
    <strong class="float-left m-r-10">{{$menu_val->parent_sort}}</strong> @if($menu_val->guard_id!='0')<label class="text-primary"> Guard : {{ $menu_val->assign_guard->name }}</label> @endif
  {{--   @foreach($guard as $key => $guard_val)
    <label class="checkbox-inline">
      <input type="checkbox" value={{$key}}> {{$guard_val}}
    </label>
    @endforeach --}}
    <button class="btn btn-sm btn-primary p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Edit</button>
    <button class="btn btn-sm btn-success p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Save</button>
    {{--  <button class="btn btn-danger btn-sm p-1  float-right m-r-10" onclick="messageDelete({{$menu_val->id}})"  style="width:60px;">Save</button> --}}
  </li>
  
  <ul class="childsort" onmousemove="sortchild('childsort')">
    @foreach($menu_val->sub_module as $key => $val)
    <li class="offset-md-1 offset-sm-1 m-t-10 m-b-10 z-depth-bottom-1 list-group-item"  id="child_id_{{$val->id}}">{{$val->title}}{{-- -{{ $val->id }} --}}
      <strong class="float-left m-r-10">{{$val->child_sort}}</strong>
      {{-- @foreach($guard as $key => $guard_val)
      <label class="checkbox-inline">
        <input type="checkbox" value={{$key}}> {{$guard_val}}
      </label>
      @endforeach --}}
      <button class="btn btn-sm btn-primary p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$val->id}}">Edit</button>
      <button class="btn btn-sm btn-success p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Save</button>
      {{--  <button class="btn btn-danger btn-sm p-1  float-right m-r-10" onclick="messageDelete({{$val->id}})"  style="width:60px;">Delete</button> --}}
    </li>
    <ul  class="subchildsort" onmousemove="sortchild('subchildsort')">
      @foreach($val->sub_module as $key => $sub_val)
      
      <li class="offset-md-2 offset-sm-2 m-t-10 m-b-10 z-depth-bottom-1 list-group-item"  id="sub_child_id_{{$sub_val->id}}">{{$sub_val->title}}{{-- -{{ $val->id }} --}}
        <strong class="float-left m-r-10">{{$sub_val->child_sort}}</strong>
        {{-- @foreach($guard as $key => $guard_val)
        <label class="checkbox-inline">
          <input type="checkbox" value={{$key}}> {{$guard_val}}
        </label>
        @endforeach --}}
        <button class="btn btn-sm btn-primary p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$sub_val->id}}">Edit</button>
        <button class="btn btn-sm btn-success p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Save</button>
        {{-- <button class="btn btn-danger btn-sm p-1  float-right m-r-10" onclick="messageDelete({{$sub_val->id}})"  style="width:60px;">Delete</button> --}}
      </li>
      <ul class="subsubchildsort" onmousemove="sortchild('subsubchildsort')">
        @foreach($sub_val->sub_module as $key => $sub_sub_val)
        <li class="offset-md-3 offset-sm-3 m-t-10 m-b-10 z-depth-bottom-1 list-group-item"  id="sub_sub_child_id_{{$sub_sub_val->id}}">{{$sub_sub_val->title}}{{-- -{{ $val->id }} --}}
          <strong class="float-left m-r-10">{{$sub_sub_val->child_sort}}</strong>
          {{-- @foreach($guard as $key => $guard_val)
          <label class="checkbox-inline">
            <input type="checkbox" value={{$key}}> {{$guard_val}}
          </label>
          @endforeach --}}
          <button class="btn btn-sm btn-primary p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$sub_sub_val->id}}">Edit</button>
          <button class="btn btn-sm btn-success p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Save</button>
          {{-- <button class="btn btn-danger btn-sm p-1  float-right m-r-10" onclick="messageDelete({{$sub_sub_val->id}})"  style="width:60px;">Delete</button> --}}
        </li>
        <ul class="subsubsubchildsort" onmousemove="sortchild('subsubsubchildsort')">
          @foreach($sub_sub_val->sub_module as $key => $sub_sub_sub_val)
          <li class="offset-md-4 offset-sm-4 m-t-10 m-b-10 z-depth-bottom-1 list-group-item"  id="sub_sub_child_id_{{$sub_sub_sub_val->id}}">{{$sub_sub_sub_val->title}}{{-- -{{ $val->id }} --}}
            <strong class="float-left m-r-10">{{$sub_sub_sub_val->child_sort}}</strong>
            {{-- @foreach($guard as $key => $guard_val)
            <label class="checkbox-inline">
              <input type="checkbox" value={{$key}}> {{$guard_val}}
            </label>
            @endforeach --}}
            <button class="btn btn-sm btn-primary p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$sub_sub_sub_val->id}}">Edit</button>
            <button class="btn btn-sm btn-success p-1 float-right m-r-10 btn_edit_module" style="width:60px;" value="{{$menu_val->id}}">Save</button>
            {{-- <button class="btn btn-danger btn-sm p-1  float-right m-r-10" onclick="messageDelete({{$sub_sub_sub_val->id}})"  style="width:60px;">Delete</button> --}}
          </li>
          @endforeach
        </ul>
        @endforeach
      </ul>
      @endforeach
    </ul>
    @endforeach
    @endif
    
    @endforeach
  </ul>