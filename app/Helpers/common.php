<?php

use App\Model\Store\Ledger;
use Illuminate\Support\Str;
use App\Model\Store\Pages\Page;
use App\Model\Front\Blog_Category;
use App\Model\Admin\Master\Product;
use App\Model\Store\blogs\BlogCategory;
use Illuminate\Support\Facades\Storage;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

function getProductCategories()
{
    $productCategories = ProductCategory::with(['Product'])->where('status', 1)->take(4)->get();
    return $productCategories;
}


function getBlogCategories()
{
    $blogCategories = BlogCategory::where('status', 1)->get();
    return $blogCategories;
}

function getPages()
{
    $pages = Page::where('status', 1)->get();
    return $pages;
}

function getProducts()
{
    $products = InvoiceDetailGradeProduct::with(['productCategory', 'product'])->select('id', 'iname', 'gin', 'ratti_id', 'primary_image', 'primary_video', 'product_id', 'product_category_id')->where('product_category_id', '2')->take(20)->get();
    // dd($products);
    return $products;
}


function getOriginalProducts()
{
    $products = Product::select('id', 'name')->where('status', 1)->get();
    // dd($products);
    return $products;
}

function uploadOnAws($file, $path, $filename = 'file')
{
    $ext  = $file->extension();

    $uploadedFileName = basename($file->storePubliclyAs($path, $filename . '.' . $ext, 's3'));
    $url = Storage::disk('s3')->url($path . '/' . $uploadedFileName);


    $uploaded_file_path = $path . '/' . $uploadedFileName;
    dd($url, $uploaded_file_path);


    // return Storage::disk('s3')->response('images/' . $filename); //preview file
}
