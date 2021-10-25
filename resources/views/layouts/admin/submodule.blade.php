<ul class="pcoded-submenu"> 
    @foreach ($modules as $module)
    @if ($module->route == null && in_array($module->id,$myModules))
    
    <li class="pcoded-hasmenu {{ in_array($module->id,$activeModuleParents) ? 'pcoded-trigger' : '' }}" >
      <a href="javascript:void(0)">
      <span class="pcoded-micon"><i class="feather icon-box"></i></span>
      <span class="pcoded-mtext">{{ $module->title }}</span>
      </a>
      @includeWhen(count($module->sub_module) > 0,'layouts.admin.submodule',['modules' =>$module->sub_module,'myModules'=> $myModules,'activeModuleParents'=> $activeModuleParents])
     </li>  
    @elseif($module->route !== null && in_array($module->id,$myModules))
    <li class="{{ Route::currentRouteName() == $module->route ? 'active' : '' }}">
      @if (Route::has($module->route))
      <a href="{{ route($module->route) ?? "" }}">
      <span class="pcoded-mtext">{{ $module->title }}</span> 
      </a>
      @endif
    </li>
     @endif 
    @endforeach
</ul>
  
    
 