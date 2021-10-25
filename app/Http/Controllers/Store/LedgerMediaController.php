<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper; 
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Store\LedgerDetail;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class LedgerMediaController extends Controller
{
    public function index($ledgerId){
          
        $ledger = Ledger::find($ledgerId);
         return view('store.LedgerMedia.index',compact('ledgerId','ledger'));
    }
   
    public function create($ledgerId)
    {    
        return View('store.LedgerMedia.create',compact('ledgerId'));
    }
    
    public function all($ledgerId){
        
        $ledger =  Ledger::with('mediaImages')->where('id',$ledgerId)->first();
        return View('store.LedgerMedia.all',compact('ledger'));

    }
    
    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(),[
                'images' => 'required',
        ]);

        if($validator->passes()){ 
            $ledger = Ledger::with('mediaImages')->where('id',$request->ledgerId)->first();

            $storeId = StoreHelper::getStoreId();
            $directory = 'images/opening-stock-images/'.$storeId.'/'.$ledger->voucher_number.'/';
            
            for($x=0;$x < count($request->images); $x++){ 
                $file = $request->file('images'.$x); 
                $extension = $file->getClientOriginalExtension();  
                $record =  Ledger::with('mediaImages')->where('id',$request->ledgerId)->first();
                $imageCountNumber = $record->mediaImages->count() > 0 ? $record->mediaImages->count() + 1 : 1;
                $fileName =  $imageCountNumber.".".$extension;   
                $file->storeAs($directory,$fileName,'images');
                $ledger->mediaImages()->create(['url'=> $directory,'name'=>$fileName,'store_user_id'=>auth('store')->user()->id]);
            }

            return response()->json(['success',true]); 
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);  
        } 
     }
    
    public function randomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
    public function finishUploading($ledgerId = null){ 
        if($ledgerId == null){
            return redirect()->route('store.openingStock.index');
        }else{
            $ledger =  Ledger::findOrFail($ledgerId);
            if($ledger->to == auth('store')->user()->id){
                return redirect()->route('receiveChallan.view',$ledgerId);
            }
            if($ledger->voucher_type == 1){
                return redirect()->route('store.openingStock.view',$ledgerId);
            }elseif($ledger->voucher_type == 2){
                return redirect()->route('saleChallan.view',$ledgerId);
                
            }elseif($ledger->voucher_type == 3){
                return redirect()->route('saleInvoice.view',$ledgerId);
                
            }elseif($ledger->voucher_type == 4){
                return redirect()->route('saleReturn.view',$ledgerId);
                
            }elseif($ledger->voucher_type == 5){
                return redirect()->route('openingStock.view',$ledgerId);

            }
        }
    }
}
