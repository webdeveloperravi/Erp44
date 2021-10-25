<?php

namespace App\Http\Livewire;

use App\Model\Front\Wishlist;
use Livewire\Component;

class UserWishListNoty extends Component
{
    public $count = 0;
    public $userWishlistItems;
    protected $listeners = [
        'refreshWishlistItemsCount' => 'render',
    ];

    function refreshWishlistItemsCount()
    {
        $this->count = Wishlist::where('user_id', session('user_id'))->count();
    }


    public function render()
    {
        if (session()->has('user_login')) {
            $this->refreshWishlistItemsCount();
        }

        return view('livewire.user-wish-list-noty');
    }
}
