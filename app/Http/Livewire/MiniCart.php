<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\wishlist;

class MiniCart extends Component
{

    protected $listeners = [
        'addtocart' => 'addToCart',
        'removeCartItem',

    ];

    function addToCart($product_item_id, $product_item_qty, $price, $addOn = null)
    {



        $product['product_id'] = $product_item_id;
        $product['product_qty'] = $product_item_qty;
        $product['price'] = $price;
        $product['addOns'] = $addOn;



        // dd(session('items_added_to_cart'));

        if (Session::has('cart_items')) {
            $oldItems = Session::get('cart_items');
            $found_item_key = collect($oldItems)->pluck('product_id')->search($product_item_id);

            if ($found_item_key === false) {
                $oldItems = Session::get('cart_items');
                $newItems = collect($oldItems)->push($product);
                Session::put('cart_items', $newItems);
                $this->emit('pop', 'Item successfully added to cart', 'Item added Successfully');
                Session::flash('items_added_to_cart', 1);
            } else {



                $newItems = collect($oldItems)->filter(function ($item, $key) use ($found_item_key) {
                    if ($key == $found_item_key) {
                        return 0;
                    } else {
                        return 1;
                    }
                });

                $newItems = collect(array_values($newItems->toArray()));

                Session::put('cart_items', $newItems);
                $this->emit('pop', 'Item successfully removed from cart', 'Item removed Successfully');
            }
        } else {

            $arr = [];
            Session::put('cart_items', collect($arr)->push($product));
            Session::flash('items_added_to_cart', 1);
            $this->emit('pop', 'Item successfully added to cart', 'Item added Successfully');
        }
    }


    function removeCartItem($index)
    {

        $cartItems = collect(Session::get('cart_items'));
        $filteredItems = $cartItems->except($index)->toArray();
        $reindexed_array = collect(array_values($filteredItems));
        Session::put('cart_items', $reindexed_array);
    }




    public function render()
    {

        return view('livewire.mini-cart');
    }
}
