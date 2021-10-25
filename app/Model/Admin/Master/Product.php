<?php

namespace App\Model\Admin\Master;

use App\Model\Admin\Master\HSNCode;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductMGrade;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Store\StorePurchaseOrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class Product extends Model
{
    use SoftDeletes;

    // protected $fillable = ['id','type_id', 'parent_id', 'name', 'alias', 'status','ri','sg','hsn_code'];
    protected $guarded = [''];
    protected $table = "products";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }


    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


    public function colors()

    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMColour', 'categoryables');
    }

    public function clarity()
    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMClarity', 'categoryables')->orderBy('id', 'desc');
    }

    public function shape()
    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMShape', 'categoryables');
    }

    public function origin()
    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMOrigin', 'categoryables');
    }

    public function grade()
    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMGrade', 'categoryables')->orderBy('id', 'asc');
    }

    public function unit()
    {

        return $this->morphedByMany('App\Model\Admin\Organization\Unit', 'categoryables')->orderBy('name', 'asc');
    }

    public function specie()
    {

        return $this->belongsTo('App\Model\Admin\Master\ProductMSpecie', 'specie');
    }

    public function treatment()
    {

        return $this->morphedByMany('App\Model\Admin\Master\ProductMTreatment', 'categoryables');
    }

    public function SG()
    {

        return $this->belongsTo('App\Model\Admin\Master\ProductMSg', 'sg');
    }

    public function RI()
    {

        return $this->belongsTo('App\Model\Admin\Master\ProductMRi', 'ri');
    }

    public function hsnCode()
    {

        return $this->belongsTo(HSNCode::class, 'hsn_code', 'id');
    }


    public function subcat()
    {

        return $this->hasMany('App\Model\Admin\Master\Product', 'parent_id');
    }

    public function assignProductGradeRateProfile()
    {
        return $this->hasMany('App\Model\Admin\Master\ProductGradeRateProfile', 'product_id')->where('status', 1);
    }
    public function assignCategoryGradeItem($limit = null)
    {
        return $this->hasMany(InvoiceDetailGradeProduct::class, 'product_id', 'id')->select('id', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')->where('in_stock', 1)->limit($limit);
    }


    public function purchaseOrderDetail()
    {
        return $this->hasMany(StorePurchaseOrderDetail::class, 'product_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(InvoiceDetailGradeProduct::class, 'product_id', 'id');
    }

    public function getUniqueGrades($product, $productStockIds)
    {
        return ProductMGrade::select('id', 'alias')->whereHas('productStocks', function ($q) use ($productStockIds, $product) {
            $q->whereIn('id', $productStockIds)->where('product_id', $product);
        })->get();
    }
    public function getUniqueRattis($product, $productStockIds)
    {
        return ProductMWeightRange::select('id', 'rati_standard')->whereHas('invoiceDetailGradeProduct', function ($q) use ($productStockIds, $product) {
            $q->whereIn('id', $productStockIds)->where('product_id', $product);
        })
            ->orderBy('rati_standard')
            ->get();
    }
}
