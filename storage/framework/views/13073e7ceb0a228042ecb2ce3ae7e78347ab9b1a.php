<div>


    <div class="notification" wire:poll.visible.2000ms>

        <?php echo e(collect(session()->get('cart_items'))->count() ? collect(session()->get('cart_items'))->count() : 0); ?>


        


    </div>





</div>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/livewire/shopping-bag.blade.php ENDPATH**/ ?>