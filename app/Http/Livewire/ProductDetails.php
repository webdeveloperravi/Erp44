<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use App\Model\Front\Service;
use Illuminate\Http\Request;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductDetails extends Component
{
    public $proItem;
    public $proName;
    public $services;
    public $addOn;
    public $relatedProItems;
    // public $productQty;





    function addToCartInit($data)
    {
        $arr = [];
        parse_str($data, $arr); //unserialize the js serialize method
        $arr['service'] = collect($arr['service'])->filter(function ($service_item) {
            return $service_item;
        });

        if (!empty($arr['service'])) {
            $this->addOn = $arr['service'];
        }

        // $this->productQty = $arr['qty']; //for non-gemstone category
        // dd($this->addOn);
        $this->emit('addtocart', $this->proItem['id'], 1, $this->proItem['productPrice'], $this->addOn ?? null);
    }



    function mount(Request $request)
    {


        $this->proItem = InvoiceDetailGradeProduct::find($request['product_item_id']);


        //gettings services
        $servs = $this->proItem->productCategory->services;

        foreach ($servs as $service) {
            $master = $service->master;
            $services[] = $service->name;
            $services_vals[] = $master::select('id', 'name', 'price')->get();
        };

        $this->services = collect($services)->combine($services_vals)->toArray();
        //gettings addOns

        // $this->addOns  = $this->proItem->productCategory->addOns; //addOn-acronym of product

        // foreach ($this->addOns as $addOne) {
        //     $masters =  $addOne->productCategory->masters;
        //     dd($masters);
        // }



        $rateProfileId = Helper::getRateProfile($this->proItem->product_id, $this->proItem->grade_id);
        $productPrice = Helper::getProductPrice($this->proItem->weight, $rateProfileId);

        $this->relatedProItems =  InvoiceDetailGradeProduct::where(['product_id' =>  $this->proItem->product_id, 'shape_id' => $this->proItem->shape_id, 'color_id' => $this->proItem->color_id])->get()->take(50);
        $this->proItem = collect($this->proItem)->merge(['productPrice' => $productPrice, 'product_alias' => $this->proItem->product->alias, 'product_grade_alias' => $this->proItem->productGrade->alias, 'product_item_ratti_std' => $this->proItem->ratti->rati_standard, 'product_name' => $this->proItem->product->name, 'shape' => $this->proItem->shape->shape, 'color' => $this->proItem->color->color]);
        $this->proName = $request['product_name'];
    }

    public function render(Request $request)
    {


        return view('livewire.productdetails');
    }
}
