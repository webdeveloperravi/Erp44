<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //StockLedger
    public function index(){
        return view('store.purchase.index');
    }
    
}
