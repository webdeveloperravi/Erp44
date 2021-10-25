<?php

namespace App\Exports;
use App\Bulk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Model\Warehouse\InvoiceDetailGradeProduct;

class BulkExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
     protected $sort_id;
    // use Exportable;
     function __construct($sort_id) {
        $this->sort_id = $sort_id;
 }


    public function headings(): array
    {
        return [
            'Sr.',
            'Product Number', 
            'Product', 
            'Product Category', 
            'Grade',
            'Invoice Number'
            
        ];
    }


    public function collection()
    {
       return InvoiceDetailGradeProduct::with('grade')->where('invoice_detail_grade_id',$this->sort_id)->get();
        /*you can use condition in query to get required result
         return Bulk::query()->whereRaw('id > 5');*/
    }


    public function map($bulk): array
    {
        return [
        	$bulk->id,
            $bulk->number,
            $bulk->grade->invoiceDetail->assign_product->name,
            $bulk->grade->invoiceDetail->product->name, 
            $bulk->grade->grade->grade, 
            $bulk->grade->invoiceDetail->invoice->invoice_number, 
            // Date::dateTimeToExcel($bulk->created_at),
            // Date::dateTimeToExcel($bulk->updated_at),
        ];
    }

}

