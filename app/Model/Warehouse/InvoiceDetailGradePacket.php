<?php

namespace App\Model\Warehouse;

use App\Model\Warehouse\ManagerPacket;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\PacketProcessingChallan;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class InvoiceDetailGradePacket extends Model
{  
    protected $fillable = ['invoice_detail_grade_id','number','total_piece','ratti_id','return_to_super','authorization','authorized_by'];

    public function invoiceDetailGrade()
    {
        return $this->belongsTo('App\Model\Warehouse\InvoiceDetailGrade','invoice_detail_grade_id','id');
    }

    public function ratti()
    {
        return $this->belongsTo(ProductMWeightRange::class,'ratti_id','id');
    }

    public function packetChallans()
    {
        return $this->hasOne('App\Model\Warehouse\PacketProcessingChallan','packet_id','id');
    }

    public function packedIssuedToManager($packet_id)
    {
        return $managerPacket = PacketProcessingChallan::where('packet_id',$packet_id)->exists();
    }

    public function managerPackets()
    {
        return $this->hasMany(ManagerPacket::class,'packet_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\Model\Warehouse\InvoiceDetailGradeProduct','invoice_detail_grade_packet_id','id');
    }

    



    
     
}
