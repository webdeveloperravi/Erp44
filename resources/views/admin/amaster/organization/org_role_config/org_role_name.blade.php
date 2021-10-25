<div id="new">
      <select   id="org_role_name" name="role_name" class="form-control  @error('tax_type') is-invalid @enderror" onchange="get_roleid()" >
                      <option >Select Role Name </option>
            @foreach($org_role as $role_key => $org_val )
             @if(in_array($org_val->id, $assign_org_role_name->toArray()))
             @else
           <option value="{{$org_val->id}}" title="{{$org_val->description}}">
                {{$org_val->name}} 
             @endif
            @endforeach
        </select>
     </div>
     @php  
  echo "<script> $('#div_org_role_name').html($('#new').html()); $('#new').hide();
      </script>";
     @endphp