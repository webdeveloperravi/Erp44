<?php

namespace App\Model\Admin\Master;

use App\Model\Admin\Organization\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Store\StorePurchaseOrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Front\Service;

class ProductCategory extends Model
{
  use SoftDeletes;

  //  public  $fillable = [ 'name','alias', 'image', 'status',];
  public $guraded = [''];
  public $table = "product_category";


  function services()
  {
    return $this->belongsToMany(Service::class, 'category_services', 'category_id', 'service_id');
  }

  function addOns()
  {
    return $this->belongsToMany(Product::class, 'add_ons', 'category_id', 'add_on_product_id');
  }

  public function masterIds()
  {
    return $this->morphMany(MasterCreateUpdate::class, 'masterable');
  }


  public function Product()
  {

    return $this->hasMany('App\Model\Admin\Master\Product', 'type_id');
  }

  public function attribute()
  {

    return $this->belongsToMany('App\Model\Admin\Master\Attribute', 'attribute_metal', 'metal_id', 'attribute_id');
  }

  public function tax()
  {

    return $this->hasMany('App\Model\Admin\Master\ProductTaxProfile', 'hsn_code', 'hsn_code');
  }

  public function assignedProdcutCatUnit()
  {

    return $this->hasMany('App\Model\Admin\Master\ProductCategoryUnit', 'pro_cat_id', 'id');
  }

  public function units()
  {

    return $this->belongsToMany(Unit::class, 'product_category_unit', 'pro_cat_id', 'unit_id')->withTimestamps();
  }

  public function masters()
  {

    return $this->belongsToMany('App\Model\Admin\Master\Master', 'product_type_master', 'product_types_id', 'masters_id')->withTimestamps();
  }

  public function purchaseOrderDetail()
  {
    return $this->hasMany(StorePurchaseOrderDetail::class, 'product_category_id', 'id');
  }

  public function products()
  {
    return $this->hasMany(InvoiceDetailGradeProduct::class, 'product_category_id', 'id');
  }
}
