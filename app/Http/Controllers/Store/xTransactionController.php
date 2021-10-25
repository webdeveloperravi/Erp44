<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Model\Store\Transaction;
use App\Model\Admin\Master\Voucher;
use App\Model\Guard\UserStore;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
   
     public function index(){
      $accounts = UserStore::all();
   return view('store.transaction.index',compact('accounts'));

     }

     public function create(){
           $vouchers = Voucher::orderBy('name')->get();   
           $accounts = UserStore::all();
     return view('store.transaction.create',compact('vouchers','accounts'));
   
        }

     public function store(Request $request)
     {
      //  dd($request->all());
        $transaction = Transaction::create([
          'voucher_type_id' => $request->voucher_type,
          'voucher_number' => $request->voucher_number,
          'from_' => $request->from,
          'to_' => $request->to,
          'debit_amount' => $request->debitAmount,
          'credit_amount' => $request->creditAmount,
          'narration' => $request->narration,
        ]);

        $transaction = Transaction::create([
          'voucher_type_id' => $request->voucher_type,
          'voucher_number' => $request->voucher_number,
          'from_' => $request->from,
          'to_' => $request->to,
          'debit_amount' => $request->debitAmount,
          'credit_amount' => $request->creditAmount,
          
          'narration' => $request->narration,
        ]);
     
        return response()->json(['success'=>true]);

     }


    public function all($id){
       
     $transactions =   Transaction::where('to_',$id)->get();
     
      return view('store.transaction.all',compact('transactions'));

    }

}
