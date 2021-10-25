<ul class="pcoded-submenu">  
    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($module->route !== null && in_array($module->id,$myModules)): ?>
    <li class="">
    <?php if(Route::has($module->route)): ?>
    <a href="<?php echo e(route($module->route) ?? ""); ?>">
    <span class="pcoded-mtext"><?php echo e($module->title); ?></span> 
    </a>
    <?php endif; ?>
    </li>
    <?php elseif($module->route == null && in_array($module->id,$myModules)): ?>
    <li class="pcoded-hasmenu" >
     <a href="javascript:void(0)">
       <span class="pcoded-micon"><i class="feather icon-box"></i></span>
     <span class="pcoded-mtext"><?php echo e($module->title); ?></span>
     </a>
     <?php echo $__env->renderWhen(count($module->sub_module) > 0,'layouts.store.submodule',['modules' =>$module->sub_module,'myModules'=>$myModules ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    </li>   
     <?php endif; ?> 
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
 
    

 <?php /**PATH E:\newxampp\htdocs\erp2\resources\views/layouts/store/submodule.blade.php ENDPATH**/ ?>