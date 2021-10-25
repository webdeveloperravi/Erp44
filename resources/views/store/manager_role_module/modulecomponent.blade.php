<ul>
@foreach ($modules as $module)
@if (in_array($module->id,$roleModulesIds))
  <li>
    <span> <input class="module-checkbox" type="checkbox" name="modules[{{$module->id}}]"  {{ in_array($module->id,$roleModulesIds) ? "checked" : "" }} value="{{$module->id}}" data-level='module'> {{ $module->title }}
      @if($module->route !== null )  
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][create]" {{ $module->getCreateManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Create 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][read]" {{ $module->getReadManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Read 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][update]" {{ $module->getUpdateManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Update 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][delete]" {{ $module->getDeleteManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Delete 
      @endif
    </span>
    @includeWhen($module->sub_module->count() > 0,'store.manager_role_module.modulecomponent',['modules'=>$module->sub_module,'roleId' => $role->id])
  </li>  
@elseif(in_array($module->id,$storeModuleIds)) 
  <li>
    <span> <input class=" module-checkbox" type="checkbox" name="modules[{{$module->id}}]"  {{ in_array($module->id,$roleModulesIds) ? "checked" : "" }} value="{{$module->id}}" data-level='module'> {{ $module->title }} 
      @if($module->route !== null ) 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][create]" {{ $module->getCreateManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Create 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][read]" {{ $module->getReadManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Read 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][update]" {{ $module->getUpdateManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Update 
      <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][delete]" {{ $module->getDeleteManager($roleId,$module->id) == '1' ? 'checked' : ""}}>Delete  
      @endif
    </span>
    @includeWhen($module->sub_module->count() > 0,'store.manager_role_module.modulecomponent',['modules'=>$module->sub_module,'roleId' => $role->id])
  </li> 
  @else
  @endif
  @endforeach
</ul>