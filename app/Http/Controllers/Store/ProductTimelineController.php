<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Store\LedgerDetail;
use App\Http\Controllers\Controller;

class ProductTimelineController extends Controller
{
    public function index(){
        return view('store.ProductTimeline.index');
    }

    public function getTimeline($gin)
    {    
        $timelines = LedgerDetail::with('ledger','ledger.voucher','ledger.userReceipt','ledger.userIssue','ledger.storeReceipt')->where('gin',$gin)->latest()->get(); 
        
        if(count($timelines) > 0){
            return view('store.ProductTimeline.view',compact('timelines'));
        }else{
            return view('store.ProductTimeline.viewEmpty',compact('timelines')); 
        } 
    }
}
