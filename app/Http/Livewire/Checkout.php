<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Country;
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\Organization\AddressType;

class Checkout extends Component
{
    public $userDetails;
   



    public function render()
    {
        $result['addressTypes'] = AddressType::pluck('name', 'id');
        $result['countries'] = Country::pluck('name', 'id');
        $result['phoneCodes'] = CountryCode::pluck('phonecode', 'id');

        if (session('user')) {
            $user = session('user');
            $this->userDetails = UserStore::with('addresses', 'addresses.addressType', 'addresses.city', 'addresses.state', 'addresses.country')->where('id', $user['id'])->first();
        }

        return view('livewire.checkout', $result);
    }
}
