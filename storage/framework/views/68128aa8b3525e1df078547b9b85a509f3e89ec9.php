<?php $__currentLoopData = $ledgers->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $ledger->ledgerDetails->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ledgerDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
            // dd($ledgerDetail->productStock);
            $rateProfileId = App\Helpers\Helper::getRateProfile($ledgerDetail->productStock->product_id, $ledgerDetail->productStock->grade_id);
            $productPrice = App\Helpers\Helper::getProductPrice($ledgerDetail->productStock->weight, $rateProfileId);
            
        ?>

        <!-- hot deals item start -->
        <div class="hot-deals-item product-item">

            <figure class="product-thumb">
                <a
                    href="<?php echo e(route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id])); ?>">
                    <img src="<?php echo e(asset('public/front/assets/front/img/product/product-details-img')); ?>1.jpg"
                        alt="product">
                </a>

                <div class="product-badge">
                    <div class="product-label new">
                        <span>sale</span>
                    </div>
                    <div class="product-label discount">
                        <span>new</span>
                    </div>
                </div>

                <?php if(session('user_login')): ?>
                    <div class="button-group">
                        <?php
                            $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $ledgerDetail->productStock->id])->exists();
                        ?>

                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-wishlist', ['item_id' =>
                        $ledgerDetail->productStock->id,'wishlishted'=>$wishlishted])->html();
} elseif ($_instance->childHasBeenRendered($key)) {
    $componentId = $_instance->getRenderedChildComponentId($key);
    $componentTag = $_instance->getRenderedChildComponentTagName($key);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($key);
} else {
    $response = \Livewire\Livewire::mount('user-wishlist', ['item_id' =>
                        $ledgerDetail->productStock->id,'wishlishted'=>$wishlishted]);
    $html = $response->html();
    $_instance->logRenderedChild($key, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                <?php endif; ?>

                <div class="cart-hover">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('add-to-cart-button', ['product_qty' =>
                    '1','product_id'=>$ledgerDetail->productStock['id'],'price' => $productPrice])->html();
} elseif ($_instance->childHasBeenRendered($key)) {
    $componentId = $_instance->getRenderedChildComponentId($key);
    $componentTag = $_instance->getRenderedChildComponentTagName($key);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($key);
} else {
    $response = \Livewire\Livewire::mount('add-to-cart-button', ['product_qty' =>
                    '1','product_id'=>$ledgerDetail->productStock['id'],'price' => $productPrice]);
    $html = $response->html();
    $_instance->logRenderedChild($key, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </figure>
            <div class="product-caption">
                <div class="product-identity">
                    <p class="manufacturer-name"><a
                            href="product-details.html"><?php echo e($ledgerDetail->productStock->product->name); ?></a>
                    </p>
                </div>
                <h6 class="product-name">
                    <a href="product-details.html"><?php echo e($ledgerDetail->productStock->product->alias); ?>

                        -
                        <?php echo e($ledgerDetail->productStock->productGrade->alias); ?> -
                        <?php echo e($ledgerDetail->productStock->ratti->rati_standard); ?>+</a>
                </h6>
                <div class="price-box">
                    <span class="price-regular">INR. <?php echo e($productPrice); ?></span>
                    
                </div>
                
            </div>
        </div>
        <!-- hot deals item end -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/components/front/get-products.blade.php ENDPATH**/ ?>