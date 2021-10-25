{{-- @php 
   $role_action_ids =   App\Model\Admin\Setting\AdminRoleAction::where('role_id',$roleId)->pluck('action_id')->toArray();
   
@endphp
@foreach ($actions->actions as $action)
 
<div class="car action">
    <div class="card-heade py-" id="heading{{ $module->id }}">
      <h2 class="mb-0">
         <div class="row mt-2">
           <div class="col-md-1 pt-2">
            <input class="float-right"  data-level='action' type="checkbox" name="actions[{{$action->id}}][allow]"  {{ in_array($action->id,$role_action_ids) ? "checked" : "" }} > 
           </div>
           <div class="col-md-11 pl-0">
            <button class="btn btn-block bg-primary text-left"  style="pointer-events: none;"> {{ $action->action }}</button>
         
           </div>
         </div>
      </h2>
    </div>
  </div> 
@endforeach
 --}}
