<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Product;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMShape;
use App\Model\Admin\Master\ProductMColour;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductItemsList extends Component
{
    public $proName;
    public $productPrice;
    public $totalProducts;
    public $rateProfileId;
    public $colors = [];
    public $shapes  = [];
    public $products  = [];
    public $proItems  = [];
    public $sortType;
    public $minRange;
    public $maxRange;
    public $query = "";


    function priceFilter($price)
    {
        $ranges = explode(' - ', $price);
        $ranges  = collect($ranges)->map(function ($v) {
            $val = str_replace(' ', '', $v);
            $val = substr($val, 2);
            return $val;
        });

        $this->minRange = $ranges[0];
        $this->maxRange = $ranges[1];

        if ($this->query == "") {
            $rawItems  = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->take(200)->get();
        } else {
            $rawItems  = InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->take(200)->get();
        }
        $this->proItems = $this->getCompleteProductItems($rawItems);
        $this->totalProducts = collect($this->proItems)->whereBetween('productPrice', [$this->minRange, $this->maxRange])->count();
        $this->proItems = collect($this->proItems)->whereBetween('productPrice', [$this->minRange, $this->maxRange]);
    }


    function sortFilter($sortType)
    {
        $proItems = $this->proItems;

        if ($sortType == "Name (A - Z)") {

            $this->proItems = collect($proItems)->sortBy('iname')->toArray();
        } elseif ($sortType == "Name (Z - A)") {

            $this->proItems = collect($proItems)->sortByDesc('iname')->toArray();
        } elseif ($sortType == "Price (Low > High)") {

            $this->proItems  =  collect($proItems)->sortBy('productPrice')->toArray();
        } else {

            $this->proItems  =  collect($proItems)->sortByDesc('productPrice')->toArray();
        }
        $this->proItems  = array_values($this->proItems);
        $this->sortType  = $sortType;
    }


    function filterColor($color_id)
    {
        $data = Session::get('filterColor');
        if (count($data) > 0) {
            if ($data->contains($color_id)) {

                $key = $data->search($color_id);
                $newFilteredData = $data->except($key);
                Session::put('filterColor', $newFilteredData);
            } else {

                $newData = $data->push($color_id);
                Session::put('filterColor', $newData);
            }
        } else {

            $newData = $data->push($color_id);
            Session::put('filterColor', $newData);
        }

        $this->applyFilter();
    }


    function filterShape($shape_id)
    {
        $data = Session::get('filterShape');
        if (count($data) > 0) {
            if (collect($data)->contains($shape_id)) {

                $key = $data->search($shape_id);
                $newFilteredData = $data->except($key);
                Session::put('filterShape', $newFilteredData);
            } else {

                $newData = $data->push($shape_id);
                Session::put('filterShape', $newData);
            }
        } else {

            $newData = $data->push($shape_id);
            Session::put('filterShape', $newData);
        }
        $this->applyFilter();
    }


    function applyFilter()
    {
        $shapes_filtered_data = Session::get('filterShape');
        $colors_filtered_data = Session::get('filterColor');
        $product = Product::where('name', $this->proName)->first();

        if ($this->query == "") {
            if (count($colors_filtered_data) > 0 && count($shapes_filtered_data) == 0) {

                $this->totalProducts = InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('color_id', $colors_filtered_data)->count();
                $rawItems =   InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('color_id', $colors_filtered_data)->get()->take(200);
            } elseif (count($colors_filtered_data) == 0 && count($shapes_filtered_data) > 0) {

                $this->totalProducts =  InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('shape_id', $shapes_filtered_data)->count();
                $rawItems =  InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('shape_id', $shapes_filtered_data)->get()->take(200);
            } elseif (count($colors_filtered_data) > 0 && count($colors_filtered_data) > 0) {

                $this->totalProducts =  InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('shape_id', $shapes_filtered_data)->whereIn('color_id', $colors_filtered_data)->count();
                $rawItems =  InvoiceDetailGradeProduct::where('product_id', $product->id)->whereIn('shape_id', $shapes_filtered_data)->whereIn('color_id', $colors_filtered_data)->get()->take(200);
            } else {

                $this->totalProducts = $product->assignCategoryGradeItem()->count();
                $rawItems  = $product->assignCategoryGradeItem()->take(200)->get();
            }
        } else {

            if (count($colors_filtered_data) > 0 && count($shapes_filtered_data) == 0) {

                $this->totalProducts = InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('color_id', $colors_filtered_data)->count();
                $rawItems =   InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('color_id', $colors_filtered_data)->get()->take(200);
            } elseif (count($colors_filtered_data) == 0 && count($shapes_filtered_data) > 0) {

                $this->totalProducts =  InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('shape_id', $shapes_filtered_data)->count();
                $rawItems =  InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('shape_id', $shapes_filtered_data)->get()->take(200);
            } elseif (count($colors_filtered_data) > 0 && count($colors_filtered_data) > 0) {

                $this->totalProducts =  InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('shape_id', $shapes_filtered_data)->whereIn('color_id', $colors_filtered_data)->count();
                $rawItems =  InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->whereIn('shape_id', $shapes_filtered_data)->whereIn('color_id', $colors_filtered_data)->get()->take(200);
            } else {


                $this->totalProducts = InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->count();
                $rawItems  = InvoiceDetailGradeProduct::where('iname', 'like', '%' . $this->query . '%')->take(200)->get();
            }
        }
        $this->proItems = $this->getCompleteProductItems($rawItems);
    }


    function mount(Request $request)
    {


        Session::put('filterColor', collect([]));
        Session::put('filterShape', collect([]));

        if ($request->has('query')) {
            if (strlen($request['query']) > 3) {

                $rawItems = InvoiceDetailGradeProduct::select('product_stocks.*', 'products.name as product_name', 'product_category.name as product_cat_name')->join('products', 'product_stocks.product_id', '=', 'products.id')->join('product_category', 'product_stocks.product_category_id', '=', 'product_category.id')->where('iname', 'like', '%' . $request['query'] . '%')->orWhere('products.name', 'like', '%' . $request['query'] . '%')->orWhere('product_category.name', 'like', '%' . $request['query'] . '%')->take(200)->get();
                $totalCount = InvoiceDetailGradeProduct::select('product_stocks.*', 'products.name as product_name', 'product_category.name as product_cat_name')->join('products', 'product_stocks.product_id', '=', 'products.id')->join('product_category', 'product_stocks.product_category_id', '=', 'product_category.id')->where('iname', 'like', '%' . $request['query'] . '%')->orWhere('products.name', 'like', '%' . $request['query'] . '%')->orWhere('product_category.name', 'like', '%' . $request['query'] . '%')->count();

                $this->proName = $request['query'];
                $this->proItems = $this->getCompleteProductItems($rawItems);
                $this->products = Product::all();
                $this->colors = ProductMColour::all();
                $this->shapes = ProductMShape::all();
                $this->totalProducts = $totalCount;
                $this->query = $request['query'];
            } else {

                return abort(404);
            }
            
        } else {

            $rawItems  = Product::where('name', $request['product_name'])->first()->assignCategoryGradeItem()->take(200)->get(); //store specific to be implemented
            $this->proName = $request['product_name'];
            $this->proItems = $this->getCompleteProductItems($rawItems);
            $this->products = Product::all();
            $this->colors = Product::where('name', $this->proName)->first()->colors;
            $this->shapes = Product::where('name', $this->proName)->first()->shape;
            $this->totalProducts = Product::where('name', $request['product_name'])->first()->assignCategoryGradeItem()->count();
        }
    }


    function getCompleteProductItems($rawItems)
    {
        $proItems = $rawItems->map(function ($item, $key) {
            $rateProfileId = Helper::getRateProfile($item->product_id, $item->grade_id);
            $productPrice = Helper::getProductPrice($item->weight, $rateProfileId);
            return collect($item)->merge(['productPrice' => $productPrice, 'product_alias' => $item->product->alias, 'product_grade_alias' => $item->productGrade->alias, 'product_item_ratti_std' => $item->ratti->rati_standard, 'product_name' => $item->product->name]);
        });
        return $proItems->toArray();
    }


    public function render()
    {
        return view('livewire.product-items-list');
    }
}
