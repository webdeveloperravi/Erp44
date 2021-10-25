<div>
    <div id="main_search_container" class="position-relative" x-data="{isOpen:true}"
        @keydown.escape.window="isOpen=false" @keydown.window="

        if(event.keyCode == 191){
            event.preventDefault();
            $refs.main_search_bar.focus();
        }
    
    ">
        <!-- Custom rounded search bars with input group -->
        <form action="<?php echo e(route('9gem_search_results')); ?>" method="get">
            <div class="p-1 bg-light rounded rounded-sm shadow-sm">
                <div class="input-group">
                    <input type="search" placeholder="What're you searching for?" aria-describedby="button-addon1"
                        class="form-control border-0 bg-light" name="query" autocomplete="off" minlength="3"
                        wire:model.debounce.0ms="query" @click="isOpen=true" x-ref="main_search_bar"
                        @click.away="isOpen = false" @focus="isOpen=true"
                        @keydown.escape="$refs.main_search_bar.blur()">



                    <div class="input-group-append" style="margin-right:18px;margin-left:10px;">
                        <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                class="fa fa-search" style="font-size:1.5rem;color:#000"></i></button>
                    </div>
                </div>
            </div>

        </form>
        <!--ends-->

        <?php if(strlen($query) >= 3): ?>
            <?php if(count($searchResults)): ?>


                <div id="main_search_results" x-show="isOpen">
                    <ul>
                        <?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                            <a
                                href="<?php echo e(route('9gem_product_details', ['product_item_id' => $item->id, 'product_name' => $item->product->name])); ?>">
                                <li>
                                    <img src="<?php echo e(asset('public/front/assets/front/img/product/product-6.jpg')); ?>"
                                        alt="product img" class="img-responsive">
                                    <div class="product-content">
                                        <h6><?php echo e($item->iname); ?></h6>
                                        <small>in gemstone</small>

                                    </div>
                                </li>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php else: ?>
                <div style="background:#fff;padding:10px;border-radius:2px">
                    <span>Oops, seems no result for "<?php echo e($query); ?>"</span>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/livewire/main-search-bar.blade.php ENDPATH**/ ?>