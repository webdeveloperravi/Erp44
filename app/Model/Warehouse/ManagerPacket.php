<?php

namespace App\Model\Warehouse;

use App\Model\Guard\UserWarehouse;
use Illuminate\Database\Eloquent\Model;
use App\Model\Warehouse\InvoiceDetailGradePacket;

 

class ManagerPacket extends Model
{
   protected $fillable = ['manager_id','super_id','date','packet_id','status'];
   
   protected $table = "manager_packets";

   public function packet(){
       return $this->belongsTo(InvoiceDetailGradePacket::class,'packet_id','id');
   }

   public function manager(){
       return $this->belongsTo(UserWarehouse::class,'manager_id','id');
   }

   public function super(){
    return $this->belongsTo(UserWarehouse::class,'super_id','id');
   }

}