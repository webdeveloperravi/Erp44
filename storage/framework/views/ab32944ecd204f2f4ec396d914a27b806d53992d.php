<?php
$count = 0;
?>

<?php $__currentLoopData = $ledgers->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $ledger->ledgerDetails->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledgerDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $ledgerDetail->productStock->productCategory->Product->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($count == 0): ?>
                <div class="tab-pane fade show active" id="<?php echo e(str_replace(' ', '', $product->name)); ?>">
                <?php else: ?>
                    <div class="tab-pane fade" id="<?php echo e(str_replace(' ', '', $product->name)); ?>">

            <?php endif; ?>
            <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                <?php $__currentLoopData = $product->products()->take(20)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $productItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        
                        $rateProfileId = App\Helpers\Helper::getRateProfile($productItem->product_id, $productItem->grade_id);
                        $productPrice = App\Helpers\Helper::getProductPrice($productItem->weight, $rateProfileId);
                        
                    ?>
                    <!-- product item start -->
                    <div class="product-item">
                        <figure class="product-thumb">
                            <a
                                href="<?php echo e(route('9gem_product_details', ['product_name' => $productItem->product->name, 'product_item_id' => $productItem->id])); ?>">
                                <img class="pri-img"
                                    src="<?php echo e(asset('public/front/assets/front/img/product/product-1.jpg')); ?>"
                                    alt="product">
                                <img class="sec-img"
                                    src="<?php echo e(asset('public/front/assets/front/img/product/product-18.jpg')); ?>"
                                    alt="product">
                            </a>
                            <div class="product-badge">
                                <div class="product-label new">
                                    <span>new</span>
                                </div>
                                <div class="product-label discount">
                                    <span>10%</span>
                                </div>
                            </div>
                            <?php if(session('user_login')): ?>
                                <div class="button-group">
                                    <?php
                                        $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $productItem->id])->exists();
                                    ?>

                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-wishlist', ['item_id' =>
                                    $productItem->id,'wishlishted'=>$wishlishted])->html();
} elseif ($_instance->childHasBeenRendered($key)) {
    $componentId = $_instance->getRenderedChildComponentId($key);
    $componentTag = $_instance->getRenderedChildComponentTagName($key);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($key);
} else {
    $response = \Livewire\Livewire::mount('user-wishlist', ['item_id' =>
                                    $productItem->id,'wishlishted'=>$wishlishted]);
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
                                '1','product_id'=>$productItem['id'],'price' =>
                                $productPrice])->html();
} elseif ($_instance->childHasBeenRendered($key)) {
    $componentId = $_instance->getRenderedChildComponentId($key);
    $componentTag = $_instance->getRenderedChildComponentTagName($key);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($key);
} else {
    $response = \Livewire\Livewire::mount('add-to-cart-button', ['product_qty' =>
                                '1','product_id'=>$productItem['id'],'price' =>
                                $productPrice]);
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
                                        href="product-details.html"><?php echo e($productItem->product()->get()[0]->name); ?></a>
                                </p>
                            </div>
                            <h6 class="product-name">
                                <a href="product-details.html"><?php echo e($productItem->product->alias); ?>

                                    -
                                    <?php echo e($productItem->productGrade->alias); ?> -
                                    <?php echo e($productItem->ratti->rati_standard); ?>+</a>
                            </h6>
                            <div class="price-box">
                                <span class="price-regular">INR.
                                    <?php echo e($productPrice); ?></span>
                                
                            </div>
                        </div>
                    </div>
                    <!-- product item end -->
                    <?php
                        $count++;
                    ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





            </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/components/front/get_tab_products.blade.php ENDPATH**/ ?>