<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Product;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMShape;
use App\Model\Admin\Master\ProductMColour;

class ProductItemsList extends Component
{
    public $proItems = [];
    public $proName = "";
    public $totalProducts = "";
    public $rateProfileId = "";
    public $productPrice = "";
    public $products = [];
    public $colors = [];
    public $shapes = [];
    public $shapes_filtered_data = [];
    public $colors_filtered_data = [];




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

        $shapes_filtered_data = Session::get('filterColor')->toArray();


        if (count($optimizedData) > 0) {
            $this->totalProducts = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->whereIn('color_id', $optimizedData)->count();
            $this->proItems = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->whereIn('color_id', $optimizedData)->take(80)->get();
        } else {
            $this->totalProducts = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->count();
            $this->proItems  = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->take(80)->get();
        }
    }

    function filterShape($shape_id)
    {


        $data = Session::get('filterShape');


        if (count($data) > 0) {


            if ($data->contains($shape_id)) {

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






        $optimizedData = Session::get('filterShape')->toArray();
    }


    function applyFilter()
    {

        if (count($optimizedData) > 0) {
            $this->totalProducts = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->whereIn('shape_id', $optimizedData)->count();
            $this->proItems = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->whereIn('shape_id', $optimizedData)->take(80)->get();
        } else {
            $this->totalProducts = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->count();
            $this->proItems  = Product::where('name', $this->proName)->first()->assignCategoryGradeItem()->take(80)->get();
        }
    }


    function mount(Request $request)
    {

        Session::put('filterColor', collect([]));
        Session::put('filterShape', collect([]));

        $this->colors = ProductMColour::all();
        $this->shapes = ProductMShape::all();
        $this->products = Product::all();
        $this->proName = $request['product_name'];
        $this->totalProducts = Product::where('name', $request['product_name'])->first()->assignCategoryGradeItem()->count();
        $this->proItems  = Product::where('name', $request['product_name'])->first()->assignCategoryGradeItem()->take(80)->get();
    }


    public function render()
    {

        return view('livewire.product-items-list');
    }
}
