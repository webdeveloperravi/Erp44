<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Master\Product;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMShape;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Admin\Master\ProductMColour;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductItemsList extends Component
{
    public $proName;
    public $proId = null;
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

        if (empty($this->query)) {
            $rawItems  = Product::where('id', $this->proId)->first()->assignCategoryGradeItem(500)->get();
        } else {
            // $rawItems  = InvoiceDetailGradeProduct::with(['product', 'productCategory'])
            //     ->where('iname', 'like', '%' . $this->query . '%')
            //     ->orWhereHas('product', function (Builder  $q) {
            //         $q->where('name', 'like', '%' . $this->query . '%');
            //     })
            //     ->orWhereHas('productCategory', function (Builder  $q) {
            //         $q->where('name', 'like', '%' . $this->query . '%');
            //     })->get();
        }

        $this->proItems = $this->getCompleteProductItems($rawItems);
        $filteredItems = $this->proItems->whereBetween('productPrice', [$this->minRange, $this->maxRange]);
        $this->proItems = $filteredItems->take(200);
        $this->totalProducts =  $filteredItems->count();
    }


    function sortFilter($sortType)
    {
        $proItems = $this->proItems;

        if ($sortType == "Name (A - Z)") {

            $this->proItems = collect($proItems)->sortBy('iname');
        } elseif ($sortType == "Name (Z - A)") {

            $this->proItems = collect($proItems)->sortByDesc('iname');
        } elseif ($sortType == "Price (Low > High)") {

            $this->proItems  =  collect($proItems)->sortBy('productPrice');
        } else {

            $this->proItems  =  collect($proItems)->sortByDesc('productPrice');
        }
        $this->proItems  = $this->proItems->values();
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

        if (empty($this->query)) {

            $rawItems = InvoiceDetailGradeProduct::select('id', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')
                ->where('in_stock', 1)
                ->where('product_id', $this->proId)
                ->when(count($colors_filtered_data) > 0, function ($query) use ($colors_filtered_data) {
                    $query->whereIn('color_id', $colors_filtered_data);
                })
                ->when(count($shapes_filtered_data) > 0, function ($query) use ($shapes_filtered_data) {
                    $query->whereIn('shape_id', $shapes_filtered_data);
                })->get();



                
        } else {

            $keywords = collect(explode(' ', $this->query))->filter();
            $rawItems = InvoiceDetailGradeProduct::with(['product', 'productCategory', 'grade.grade', 'ratti'])
                ->select('id', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $value) {
                        $q->orWhere('iname', 'like', '%' . $value . '%');
                        $q->orWhereHas('product', function (Builder  $query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('productCategory', function (Builder  $query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('grade.grade', function (Builder  $query) use ($value) {
                            $query->where('grade', 'like', '%' . $value . '%');
                        });

                        $q->orWhereHas('ratti', function (Builder  $query) use ($value) {
                            $query->where('rati_standard', 'like', '%' . $value . '%');
                        });
                    }
                })->when(count($colors_filtered_data) > 0, function ($query) use ($colors_filtered_data) {
                    $query->whereIn('color_id', $colors_filtered_data);
                })
                ->when(count($shapes_filtered_data) > 0, function ($query) use ($shapes_filtered_data) {
                    $query->whereIn('shape_id', $shapes_filtered_data);
                })->where('in_stock', 1)->get();
        }
        $this->proItems = $this->getCompleteProductItems($rawItems->take(200));
        $this->totalProducts = $rawItems->count();
    }


    function mount(Request $request)
    {
        Session::put('filterColor', collect([]));
        Session::put('filterShape', collect([]));

        if ($request->has('query')) {
            $this->query = $request['query'];

            if (strlen($this->query) >= 3) {

                $keywords = collect(explode(' ', $this->query))->filter();

                $rawItems = InvoiceDetailGradeProduct::with(['product', 'productCategory', 'grade.grade', 'ratti'])
                    ->select('id', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')
                    ->where(function ($q) use ($keywords) {
                        foreach ($keywords as $value) {

                            $q->where('iname', 'like', '%' . $value . '%');
                            $q->orWhereHas('product', function (Builder  $query) use ($value) {
                                $query->where('name', 'like', '%' . $value . '%');
                            });
                            $q->orWhereHas('productCategory', function (Builder  $query) use ($value) {
                                $query->where('name', 'like', '%' . $value . '%');
                            });
                            $q->orWhereHas('grade.grade', function (Builder  $query) use ($value) {
                                $query->where('grade', 'like', '%' . $value . '%');
                            });

                            $q->orWhereHas('ratti', function (Builder  $query) use ($value) {
                                $query->where('rati_standard', 'like', '%' . $value . '%');
                            });
                        }
                    })->where('in_stock', 1)->get();

                $this->proName = $request['query'];
                $this->proItems = $this->getCompleteProductItems($rawItems->take(200));
                $this->products = Product::all();
                $this->colors = ProductMColour::all()->sortBy('color');
                $this->shapes = ProductMShape::all()->sortBy('shape');
                $this->totalProducts = $rawItems->count();
            } else {
                return abort(404);
            }
        } else {

            $rawItems  = Product::where('name', $request['product_name'])->first()->assignCategoryGradeItem(200)->get(); //store specific to be implemented
            $this->proName = $request['product_name'];
            $this->proItems = $this->getCompleteProductItems($rawItems);
            $product = Product::select('id', 'name')->with('colors', 'shape')->where(['name' => $this->proName, 'status' => 1])->first();
            $this->proId = $product->id;
            $this->products = Product::select('id', 'name')->where('status', 1)->get();
            $this->colors = $product->colors->sortBy('color');;
            $this->shapes = $product->shape->sortBy('shape');
            $this->totalProducts = $product->assignCategoryGradeItem->count();
        }
    }


    function getCompleteProductItems($rawItems)
    {
        $proItems = $rawItems->map(function ($item, $key) {
            $rateProfileId = Helper::getRateProfile($item->product_id, $item->grade_id);
            $productPrice = Helper::getProductPrice($item->weight, $rateProfileId);
            return collect($item)->merge(['productPrice' => $productPrice, 'product_alias' => $item->product->alias, 'product_grade_alias' => $item->productGrade->alias, 'product_item_ratti_std' => $item->ratti->rati_standard, 'product_name' => $item->product->name]);
        });
        return $proItems;
    }


    public function render()
    {
        return view('livewire.product-items-list');
    }
}
