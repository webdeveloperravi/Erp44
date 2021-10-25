<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Model\Front\Blog_Post;

class addToCartButton extends Component
{
    public $product_id = "";
    public $product_qty = "";
    public $price = "";
    // public $in_cart = 0;



    function emitAddToCartEvent()
    {
        $this->emit('addtocart', $this->product_id, $this->product_qty, $this->price);
        // $this->in_cart = $this->in_cart == 1 ? 0 : 1;
    }


    // function mount()
    // {
    //     // $items = collect(session('cart_items'));
    //     // $found = $items->search(function ($item, $key) {
    //     //     return $item['product_id'] == $this->product_id;
    //     // });

    //     // if ($found == false) {
    //     //     $this->in_cart = 0;
    //     // } else {
    //     //     $this->in_cart = 1;
    //     // }
    // }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
