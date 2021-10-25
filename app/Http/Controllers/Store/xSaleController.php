<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //StockLedger
    public function index(){
        return view('store.sale.index');
    }

    public function index1(){

         return view('store.sale.index1');

    }
    
    
}
