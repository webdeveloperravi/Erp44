<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BulkExport;

class InvoiceDetailGradeProductController extends Controller
{    
    
    protected $lastProductNumber;

    public function generateProducts($sort_id)
    {
      $this->lastProductNumber =  InvoiceDetailGradeProduct::max('gin')+1; 
      $invoiceDetailGrade = InvoiceDetailGrade::with('invoiceDetail')->where('id',$sort_id)->first();
      $invoiceDetailGrade->update(['generate_id'=>1]);  
      for($i=1; $i <= $invoiceDetailGrade->piece;  $i++){ 
        InvoiceDetailGradeProduct::create([ 
          'invoice_detail_grade_id' => $sort_id,
          'product_id' => $invoiceDetailGrade->invoiceDetail->product_cate_id,
          'grade_id' => $invoiceDetailGrade->grade->grade,
          ]);
        $this->lastProductNumber++;
      }
      return "Success";
    }  
    
    //Old
    // public function generateProducts($sort_id)
    // {
    // InvoiceDetailGrade::find($sort_id)->update(['generate_id'=>1]);
    // $oldNumber = InvoiceDetailGradeProduct::orderBy('id','desc')->first()->id ?? "112233"; 
    // $this->lastProductNumber = $oldNumber+1; 
    // $grade_pieces = InvoiceDetailGrade::find($sort_id)->piece;
    // $productAlias =InvoiceDetailGrade::find($sort_id)->invoiceDetail->product->alias ?? ""; 
    // $categoryAlias =InvoiceDetailGrade::find($sort_id)->invoiceDetail->assign_product->prefix_code ?? ""; 
    // $generated_number = $this->generateNumber($productAlias,$categoryAlias);
    // // dd($generated_number);
    // for($i=1; $i <= $grade_pieces; $i++){
    //     $generated_number = $this->generateNumber($productAlias,$categoryAlias);
    //     // $final_number = $this->checkIfNumberExists($generated_number,$productAlias,$categoryAlias);
    //     InvoiceDetailGradeProduct::create([
    //       'number' => $this->lastProductNumber,
    //       'alias' => $generated_number,
    //       'invoice_detail_grade_id' => $sort_id,
    //       'weight' => 0
    //     ]);
    //     $this->lastProductNumber++;
    // }

    public function printLabel($sort_id)
    { 
      try{
         // retreive all records from db
      $data = InvoiceDetailGradeProduct::with('grade')->where('invoice_detail_grade_id',$sort_id)->get();
      //grade->invoiceDetail->invoice->invoice_number

      // share data to view
      view()->share('products',$data);
      $pdf = PDF::loadView('warehouse.gradesort_product.printlabel');
      
      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
      }catch(DOMPDF_Exception $e){
          echo '<pre>',print_r($e),'</pre>';
      }
    }

    public function exportExcel($sort_id)
    { //   grade->invoiceDetail->invoice->invoice_number

      return Excel::download(new BulkExport($sort_id), 'bulkData.xlsx');

    }

    public function printPacketLabel($packetId)
    {
      
    }
}
