<?php

namespace App\Exports;
use App\Bulk;
use App\Model\DataMigration\TblItem;
use App\Model\DataMigration\TblIfvalue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class TestingExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    
    // use Exportable;
     function __construct() {
         
 }


    public function headings(): array
    {   
        //Missig Items
        // return [ 
        //     'Item ID',  
        // ];

        //Missing Gins
        return [ 
            'Missing Gins',  
        ];
    }


    public function collection()
    {   
        //Missing Items
        // return  TblIfvalue::doesntHave('item')->get(); 

        //Missing Gins
        $gins = TblItem::select('id','icode')->get()->groupBy(['icode']); 
        for($i = 11213153; $i <= 11330721;$i++){
             
            if(isset($gins[$i])){
            }else{
                $missing[] =[
                    'gin' => $i,
                ];  
            } 
        } 
        $missingGins = collect($missing)->pluck('gin'); 
       
        return collect($missingGins); 
        
    }


    public function map($bulk): array
    {   
        //Missing Items
        // return [ 
        //     $bulk->item_id, 
        // ];

        //Missing Gins
        return [ 
            $bulk 
        ];

    }

}

