<div>
    <?php
        $grandTotal = 0;
    ?>

    <!-- offcanvas mini cart start -->
    <div class="offcanvas-minicart-wrapper">
        <div class="minicart-inner">
            <div class="offcanvas-overlay"></div>
            <div class="minicart-inner-content">
                <div class="minicart-close">
                    <i class="pe-7s-close"></i>
                </div>
                <div class="minicart-content-box">
                    <div class="minicart-item-wrapper">
                        <ul>
                            <?php if(session('cart_items') && count(session('cart_items'))): ?>
                                <?php $__currentLoopData = session('cart_items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <?php
                                        $product_item = App\Model\Warehouse\InvoiceDetailGradeProduct::find($item['product_id']);
                                        $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                        $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                        
                                    ?>
                                    <li class="minicart-item">
                                        <div class="minicart-thumb">
                                            <a
                                                href="<?php echo e(route('9gem_product_details', ['product_name' => $product_item->product->name, 'product_item_id' => $item['product_id']])); ?>">
                                                <img src="<?php echo e(asset('public/front/assets/front/img/product/gem.jpg')); ?>"
                                                    alt="product">
                                            </a>
                                        </div>
                                        <div class="minicart-content">
                                            <h3 class="product-name">
                                                <a
                                                    href="<?php echo e(route('9gem_product_details', ['product_name' => $product_item->product->name, 'product_item_id' => $item['product_id']])); ?>"><?php echo e($product_item->product->alias); ?>

                                                    -
                                                    <?php echo e($product_item->productGrade->alias); ?> -
                                                    <?php echo e($product_item->ratti->rati_standard); ?>+</a>
                                            </h3>
                                            <p>
                                                <span class="cart-quantity"> <?php echo e($item['product_qty']); ?>

                                                    <strong>&times;</strong></span>
                                                <span class="cart-price">INR. <?php echo e($item['price']); ?></span>
                                            </p>
                                        </div>
                                        <button class="minicart-remove" type="button"
                                            wire:click.prevent="removeCartItem('<?php echo e($loop->index); ?>')"><i
                                                class="pe-7s-close"></i></button>
                                    </li>
                                    <?php
                                        $grandTotal += $item['price'] * $item['product_qty'];
                                    ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        </ul>
                    </div>

                    <div class="minicart-pricing-box">
                        <ul>
                            
                            <li class="total">
                                <span>total</span>
                                <span><strong>INR. <?php echo e($grandTotal ?? 0); ?></strong></span>
                            </li>
                        </ul>
                    </div>


                    <div class="minicart-button">
                        <a href="<?php echo e(route('9gem_user_cart')); ?>"><i class="fa fa-shopping-cart"></i> View Cart</a>
                        <a href="<?php echo e(route('9gem_user_checkout')); ?>"><i class="fa fa-share"></i> Checkout</a>
                    </div>
                <?php else: ?>
                    <img src="<?php echo e(asset('public/front/icons/empty-cart.svg')); ?>" alt="" height="180"
                        class="img-responsive mx-auto d-block ">
                    <h4 class="text-center mt-5 block">Your Shopping Cart Is Empty</h4>
                    <a href="<?php echo e(route('9gemhome')); ?>" class="btn  btn-hero text-center mx-auto block"
                        style="display:block;max-width:200px">Continue
                        Shopping</a>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas mini cart end -->
</div>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/livewire/mini-cart.blade.php ENDPATH**/ ?>