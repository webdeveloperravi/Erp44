<?php

namespace App\Exports;
 
use App\Helpers\StoreHelper;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class MagentoPriceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        // $products = InvoiceDetailGradeProduct::limit(2)->get();
        $finalProducts[] = ['icode'=> 'icode' ,'price'=> 'price'];
        // foreach($products as $product){
        //     $result = StoreHelper::getProductGradeRattiRattiRateMrpAmount($product);
        //     $finalProducts[] = ['icode' => $product->gin,'mrp'=> $result['mrpAmount']];
        // } 
        
        // InvoiceDetailGradeProduct::chunk(5000,function($products){
        //     foreach($products as $product){
        //         $result = StoreHelper::getProductGradeRattiRattiRateMrpAmount2($product) ?? false;
        //         if($result){
        //             $finalProducts[] = ['icode' => $product->gin,'mrp'=> $result['mrpAmount']];
        //         }
        //     }
        // });
        $products =  InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','weight')->get();
        foreach($products as $product){
            $result = StoreHelper::getProductGradeRattiRattiRateMrpAmount2($product);
            if($result){
                $finalProducts[] = ['icode' => $product->gin,'mrp'=> $result['mrpAmount']];
            }
        }
        return collect($finalProducts);
    }
}