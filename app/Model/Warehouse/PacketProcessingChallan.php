<?php

namespace App\Model\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class PacketProcessingChallan extends Model
{
    protected $table = "packet_processing_challans";

    use SoftDeletes;

    protected $fillable = ['packet_id','challan_number','date','manager_id','super_id','status','created_at','updated_at','authorization','authorized_by'];
    

    public function packet(){
        return $this->belongsTo("App\Model\Warehouse\InvoiceDetailGradePacket",'packet_id','id');
    }

    public function manager(){
        return $this->belongsTo("App\Model\Guard\UserWarehouse",'manager_id','id');
    }

    public function super(){
        return $this->belongsTo("App\Model\Guard\UserWarehouse",'super_id','id');
    }

    public function packetProcessStatus($packetId){
        
        return InvoiceDetailGradeProduct::where('invoice_detail_grade_packet_id',$packetId)->where('gin',null)->exists();
    }

    

}
