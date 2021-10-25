<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ProductVideo;

class ProductVideoController extends Controller
{

    public function index($productId)
    {
        $videos = ProductVideo::where('product_id',$productId)->get();
        // dd($videos);
        return view('warehouse.videos.index',compact('videos')); 
    }

     
    public function create($productId)
    {    
        
        return View('warehouse.videos.create',compact('productId'));
    }

    public function store(Request $request){
        
        
        $video = ProductVideo::create(['url'=>$request->url,'width'=> $request->width,'product_id'=>$request->productId]);
        return "success";
        
    }
}
