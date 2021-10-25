<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\ProductImage;
use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Support\Facades\Storage;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductImageController extends Controller
{
    
    public function index($productId)
    {
        $images = ProductImage::where('product_id',$productId)->get();
        // dd($images);
        return view('warehouse.images.index',compact('images')); 
    }

   
    public function create($productId)
    {    
        
        return View('warehouse.images.create',compact('productId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    
    public function store(Request $request)
    {
        // $image       = $request->file('image');
        // $filename    = $image->getClientOriginalName();

        // //Fullsize
        // $image->move(public_path().'/full/',$filename);

        // $image_resize = Image::make(public_path().'/full/'.$filename);
        // $image_resize->fit(300, 300);
        // $image_resize->save(public_path('thumbnail/' .$filename));

        // $product= new Product();
        // $product->name = $request->name;
        // $product->image = $filename;
        // $product->save();
        
        
        
        $product = InvoiceDetailGradeProduct::where('id',$request->productId)->first();
        $productCategory = $product->productCategory->name; //Gemstone
        $productName = $product->product->name;
        $directory = strtolower($productCategory)."/".strtolower($productName)."/";  
        
        for($x=0;$x < count($request->images); $x++){ 
            
            $file = $request->file('images'.$x); 
            $extension = $file->getClientOriginalExtension();
            $fileName = "GEM".$product->gin.$this->randomString().".".$extension;
            $path = $file->storeAs($directory,$fileName,'public_uploads');
            // dd($path);
            // Storage::disk('public_uploads')->put($directory, $fileName); 
            $insert[$x]['name'] = $fileName;
            $insert[$x]['url'] = $directory;
            $insert[$x]['product_id'] = $product->id; 
        }
        $products =  ProductImage::insert($insert); 
     }


    // public function store(Request $request)
    // {
        
    //     $product = InvoiceDetailGradeProduct::where('id',$request->productId)->first();
    //     $productCategory = $product->grade->invoiceDetail->assign_product->name; //Gemstone
    //     $productName = $product->grade->invoiceDetail->product->name;
    //     $directory = strtolower($productCategory)."/".strtolower($productName)."/";  
        
    //     for($x=0;$x < count($request->images); $x++){ 
            
    //         $file = $request->file('images'.$x); 
    //         $extension = $file->getClientOriginalExtension();
    //         $fileName = "GEM".$product->gin.$this->randomString().".".$extension;
    //         $file->storeAs($directory,$fileName,'public_uploads');
    //         // Storage::disk('public_uploads')->put($directory, $fileName); 
    //         $insert[$x]['name'] = $fileName;
    //         $insert[$x]['url'] = $directory;
    //         $insert[$x]['product_id'] = $product->id; 
    //     }
    //     $products =  ProductImage::insert($insert); 
    //  }

    function randomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 
}
