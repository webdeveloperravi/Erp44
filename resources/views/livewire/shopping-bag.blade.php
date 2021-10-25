<div>


    <div class="notification" wire:poll.visible.2000ms>

        {{ collect(session()->get('cart_items'))->count() ? collect(session()->get('cart_items'))->count() : 0 }}

        {{-- @includeWhen(session('items_added_to_cart'), 'component.front.popup') --}}


    </div>





</div>
