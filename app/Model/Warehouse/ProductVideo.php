<?php

namespace App\Model\Warehouse;

use Cohensive\Embed\Facades\Embed;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
   protected $fillable =['product_id','url','width'];

   // public function getUrlAttribute($value){

   //    $embed = Embed::make($value)->parseUrl();

   //      if (!$embed)
   //          return '';

   //      $embed->setAttribute(['width' => 400]);
   //      return $embed->getHtml();
      
   // }

   public function getVideoWithWidth($url,$width){
      
      $embed = Embed::make($url)->parseUrl();

        if (!$embed)
            return 'saab';

        $embed->setAttribute(['width' => $width]);
        return $embed->getHtml();


   }
   
}
