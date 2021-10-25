<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Admin\Master\Product;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\AccountGroup;
use App\Services\GetUserDebitCreditAmount;
use App\Model\Admin\Master\ProductMWeightRange;

class ProductStockPositionController extends Controller
{
    public function index()
    {   
        $products = Product::all(); 

        return view('store.ProductStockPosition.index',compact('products'));

        
    }

    public function getProductProperties($productId)
    {   
        if(!$productId  == 0){
            $product = Product::with('grade','colors','clarity','shape','origin')->whereId($productId)->first(); 
            $rattis = ProductMWeightRange::all();
    
            return view('store.ProductStockPosition.productProperties',compact('product','rattis'));
        }
       
    }

    public function getReport(Request $request)
    {   
        $accounts = UserStore::where('org_id',StoreHelper::getStoreId())
                            ->whereIn('account_group_id',[1,17])
                            ->with('headOfficeAddress.city:id,name')
                            ->orderBy('company_name') 
                            ->get()->groupBy('account_group_id');  
        // $accounts = UserStore::whereIn('id',[1054])
        //                 ->whereIn('account_group_id',[1,17])
        //                 ->with('headOfficeAddress.city:id,name')
        //                 // ->orderBy('company_name')
        //                 // ->limit(5)
        //                 ->get()->groupBy('account_group_id'); 

        $accountGroups = AccountGroup::whereIn('id',[1,17])
                         ->get();
        
        $authUserStore = UserStore::find(StoreHelper::getStoreId());
        $requestData = $request->all();
        return view('store.ProductStockPosition.view',compact('accounts','accountGroups','requestData','authUserStore'));
    }

    public function view(Request $request){
         
        

        
        $gradeId = $request->value;
        $rattiId = $request->value;
        $weight = $request->value;
        $shape = $request->value;
        $clarity = $request->value;
        $origin = $request->value;
        return view('store.ProductStockPosition.view',compact('accounts','accountGroups')); 

    } 

    public function viewStock($accountId,$voucherTypeId){
         dd($accountId,$voucherTypeId);
         $ledger = new Ledger;
         $vouchers = Voucher::all();
         $user = UserStore::find($accountId);
         return view('store.ProductStockPosition.viewStock',compact('vouchers','ledger','accountId','user'));
    }

   
}