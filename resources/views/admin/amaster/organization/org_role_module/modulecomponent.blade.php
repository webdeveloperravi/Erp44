 
  <ul>
    @foreach ($modules as $module) 
      <li>
        <span> <input class="module-checkbox" type="checkbox" name="modules[{{$module->id}}]"  {{ in_array($module->id,$roleModulesIds) ? "checked" : "" }} value="{{$module->id}}" data-level='module'> {{ $module->title }}
          @if($module->route !== null )  
          <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][create]" {{ $module->getCreateOrg($roleId,$module->id) == '1' ? 'checked' : ""}}>Create 
          <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][read]" {{ $module->getReadOrg($roleId,$module->id) == '1' ? 'checked' : ""}}>Read 
          <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][update]" {{ $module->getUpdateOrg($roleId,$module->id) == '1' ? 'checked' : ""}}>Update 
          <input type="checkbox" class="ml-lg-5" name="modules[{{ $module->id }}][delete]" {{ $module->getDeleteOrg($roleId,$module->id) == '1' ? 'checked' : ""}}>Delete 
          @endif
        </span>
        @includeWhen($module->sub_module->count() > 0,'admin.amaster.organization.org_role_module.modulecomponent',[
          'modules'=>$module->sub_module,
          'roleId' => $role->id,
          'roleModulesIds ' => $roleModulesIds ,
          ])
      </li>   
      @endforeach
    </ul>