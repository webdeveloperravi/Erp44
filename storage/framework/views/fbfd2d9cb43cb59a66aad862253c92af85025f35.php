
                                <?php $__currentLoopData = $ledgers->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $ledger->ledgerDetails->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledgerDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        
                                        $rateProfileId = App\Helpers\Helper::getRateProfile($ledgerDetail->productStock->product_id, $ledgerDetail->productStock->grade_id);
                                        $productPrice = App\Helpers\Helper::getProductPrice($ledgerDetail->productStock->weight, $rateProfileId);
                                        
                                    ?>

                                    <!-- group list item start -->
                                    <div class="group-slide-item">
                                        <div class="group-item">
                                            <div class="group-item-thumb">
                                                <a
                                                    href="
                                                                                                                                                                                                                                                    <?php echo e(route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id])); ?>">
                                                    <img src="<?php echo e(asset('public/front/assets/front/img/product/product-17.jpg')); ?>"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="group-item-desc">
                                                <h5 class="group-product-name"><a
                                                        href="
                                                                                                                                                                                                                                                        <?php echo e(route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id])); ?>">
                                                        <?php echo e($ledgerDetail->productStock->product->alias); ?>

                                                        -
                                                        <?php echo e($ledgerDetail->productStock->productGrade->alias); ?> -
                                                        <?php echo e($ledgerDetail->productStock->ratti->rati_standard); ?>+</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">INR. <?php echo e($productPrice); ?></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- group list item end -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/components/front/get_on_sale&best_seller_products.blade.php ENDPATH**/ ?>