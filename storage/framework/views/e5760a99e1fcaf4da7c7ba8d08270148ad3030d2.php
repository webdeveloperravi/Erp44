
<?php $__env->startSection('content'); ?>
 <h1 class="text-cneter">Dashboard <?php echo e(auth('store')->user()->name ?? ""); ?></h1>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.store.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/dashboard/index.blade.php ENDPATH**/ ?>