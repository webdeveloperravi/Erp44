<?php

namespace App\Http\Controllers\Store;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerZone;
use App\Model\Admin\Master\Country;
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Zone;
use App\Model\Admin\WhiteListIpAddress;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Master\CountryStateCity;

class ManagerAttachIpController extends Controller
{
    
    public function index($managerId)
    { 
        $manager = UserStore::find($managerId); 
        $ips = WhiteListIpAddress::where('store_id',StoreHelper::getStoreId())->latest()->get();
        return view('store.account.manager.managerView.IpAttach.index',compact('ips','manager'));
    } 
      
    public function attach(Request $request)
    { 
       
        $manager = UserStore::find($request->managerId);
        $manager->ip_blocking = $request->ip_blocking == 'on' ? 1 : 0 ;
        $manager->save();
        $manager->managerIps()->detach(); 
        $manager->managerIps()->attach($request->zones);
         
        return response()->json(['success'=> true],200);
    } 

}
