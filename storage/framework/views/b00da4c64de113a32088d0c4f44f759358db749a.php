
<?php $__env->startSection('content'); ?>
<div class="card">
 <div class="card-body">
    <div class="row">
    <div class="col col-xl-4 col-md-3">
        <div class="form-group">
            <label for="parentId">Enter GIN Number:</label>
            <input  type="number" id="gin" class="form-control" onkeypress="javascript: if(event.keyCode == 13) getTimeline();" autocomplete="off">
        </div>
    </div> 
    <div class="col col-xl-4 col-md-4">
<div class="form-group">
<label for="parentId" class="invisible d-block">Hidden</label>
<button class="btn btn-sm btn-dark"  onclick="getTimeline()">Get Details</button>
</div>
</div>  
   
</div>  
</div> 
<div id="view">
</div>    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $("#gin").focus();
    function getTimeline(){ 
        var gin  = $("#gin").val();
        if(gin > 0){

        var url = "<?php echo e(route('productStockDetail.getDetail',['/'])); ?>/"+gin;
        $.get(url,function(data){ 
            $("#gin").val('');
            $("#view").html(data);
        });
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.store.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/ProductStockDetail/index.blade.php ENDPATH**/ ?>