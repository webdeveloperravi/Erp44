@php
   $modules =   app\Model\admin\setting\Module::where('parent',$moduleId)->get();
@endphp
@foreach ($modules as $module)
 
<div class="car module ">
    <div class="card-heade py-" id="heading{{ $module->id }}">
      <h2 class="mb-0">
         <div class="row mt-2">
           <div class="col-md-1 pt-2">
            <input class="float-right " type="checkbox" name="modules[{{$module->id}}]"  {{ in_array($module->id,$module_ids) ? "checked" : "" }} value="{{$module->id}}" data-level='module'> 
           </div>
           <div class="col-md-11 pl-0">
            <button class="btn btn-block bg-inverse text-left"  style="pointer-events: none;"> {{ $module->title }}</button>
            @if ($module->sub_module->count()) 
            @includeWhen($module->sub_module->count() > 0,'admin.amaster.WarehouseRoleModule.modulecomponent',['moduleId'=>$module->id])
            @endif 
            @if($module->actions()->count() > 0) 
            @includeWhen($module->actions()->count() > 0,'admin.amaster.WarehouseRoleModule.actioncomponent',['actions'=>$module,'roleId'=> $role->id])
            @endif 
           </div>
         </div>
      </h2>
    </div>
  </div> 
@endforeach

