<?php

namespace app\Model\Warehouse;

use app\Model\Warehouse\Invoice;
use App\Model\Guard\UserWarehouse;
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
                                   
    // protected $table='invoice';
    protected $fillable=['id','total_amount','invoice_number','vendor_id','dept_id_receive','user_id_receive','date','status','created_by','complete','authorization','authorized_by'];


    public function invoiceDetail(){

        return $this->hasMany('App\Model\Warehouse\InvoiceDetail','invoice_id','id');

    }

    public function store(){

    	return $this->belongsTo("App\Model\Admin\Organization\Store",'org_id_issue','id');
    }  


    public function vendor(){

      return $this->belongsTo('App\Model\Warehouse\Vendor','vendor_id','id');
    }

    public function totalPiece($invoice_id){

      $countPiece = InvoiceDetail::where('invoice_id',$invoice_id)->pluck("piece")->all();

      $countPiece = collect($countPiece);
      $countPiece = $countPiece->reduce(function ($carry, $item) {
        return $carry + $item;
     });  
      return $countPiece; 
     }

    public function totalWeight($invoice_id){

      $countWeight = InvoiceDetail::where('invoice_id',$invoice_id)->pluck("carat")->all();

      $countWeight = collect($countWeight);
      $countWeight = $countWeight->reduce(function ($carry, $item) {
        return $carry + $item;
     });  
      return $countWeight; 
     }

    public function totalItems($invoice_id){

      // return InvoiceDetail::where('invoice_id',$invoice_id)->count();
      // return $countItems->count();
      $countWeight = InvoiceDetail::where('invoice_id',$invoice_id)->pluck("piece")->all();

      $countWeight = collect($countWeight);
      $countWeight = $countWeight->reduce(function ($carry, $item) {
        return $carry + $item;
     });  
      return $countWeight;  
     }
    public function totalAmount($invoice_id){

      // return InvoiceDetail::where('invoice_id',$invoice_id)->count();
      // return $countItems->count();
      $countWeight = InvoiceDetail::where('invoice_id',$invoice_id)->pluck("amount")->all();

      $countWeight = collect($countWeight);
      $countWeight = $countWeight->reduce(function ($carry, $item) {
        return $carry + $item;
     });  
      return $countWeight;  
     }

     public function user(){
       return $this->belongsTo(UserWarehouse::class,'user_id_receive','id'); 
     }

     public function gradeSortStatus($invoiceId)
     {
             return  Invoice::whereHas('invoiceDetail',function($query){
                                  return $query->where('complete',0);   
               })->where('id',$invoiceId)->exists(); 
     }



                               


}
