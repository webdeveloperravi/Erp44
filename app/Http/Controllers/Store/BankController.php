<?php
namespace App\Http\Controllers\Store;

use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\AccountGroup;
use Illuminate\Support\Facades\Validator;

 

class BankController extends Controller
{
   
    public function index()
    {
        return view('store.bank.index');
    }

    public function all()
    {
        $bankAccounts = UserStore::with('accountGroup')->where('org_id',auth('store')->user()->id)->whereIn('account_group_id',[12])->get();
        return view('store.bank.all',compact('bankAccounts'));
    }

    public function create()
    {
        //  $accountGroups = AccountGroup::all();
         return view('store.bank.create');
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(),[
                    'accountName' => 'required', 
                     ]);
        if($validator->passes()){
            $bankAccountLink = UserStore::create([
                'name' => $request->accountName, 
                'account_group_id' => 12, 
                'org_id' => StoreHelper::getStoreId(),
                'created_by' => auth('store')->user()->id,
                'type' => 'bank'
            ]);
            return response()->json(['success'=>true]);
        }
        else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
        }
    } 
    
  

   
    public function edit($id)
    {
        $bankAccountEdit = UserStore::findorfail($id); 
        return view('store.bank.edit',compact('bankAccountEdit'));

    }
  
    public function update(Request $request)
    {
        $bank = UserStore::where(['id'=>$request->bankAccountId])->first();
         
        $validator = Validator::make($request->all(),[
            'name' => 'required', 
        ]);

        if($validator->passes()){
           
            $bank->update([
            'name' =>$request->name,  
            ]);
           return response()->json(['success' => true]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
        }
  } 
}
