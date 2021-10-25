<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Model\Front\Wishlist;

class UserWishlist extends Component
{
    public $item_id;
    public $wishlishted;
    protected $listeners = [
        'wishlist',
    ];



    function wishlist()
    {

        $user_id = session('user_id');

        if (session()->has('user_login')) {
            if (!$this->wishlishted) {
                //add
                Wishlist::create([
                    'user_id' => $user_id,
                    'product_item_id' => $this->item_id,
                ]);
                $this->wishlishted = true;
            } else {
                //remove
                Wishlist::where([
                    'user_id' => $user_id,
                    'product_item_id' => $this->item_id,
                ])->delete();
                $this->wishlishted = false;
            }


            $this->emitTo('user-wish-list-noty', 'refreshWishlistItemsCount');
        } else {
            //
        }
    }

    public function render()
    {
        return view('livewire.wishlist');
    }
}
