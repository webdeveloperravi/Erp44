<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class MainSearchBar extends Component
{

    public $query = "";
    public $searchResults;
    public function render()
    {


        if (strlen($this->query) >= 3) {
            $keywords = collect(explode(' ', $this->query))->filter();


            $results = InvoiceDetailGradeProduct::with(['product', 'productCategory', 'grade.grade', 'ratti', 'color', 'shape'])
                ->select('id', 'iname', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $value) {
                        $q->orWhere('iname', 'like', '%' . $value . '%');
                        $q->orWhereHas('product', function (Builder  $query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('productCategory', function (Builder  $query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('grade.grade', function (Builder  $query) use ($value) {
                            $query->where('grade', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('color', function (Builder  $query) use ($value) {
                            $query->where('color', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('shape', function (Builder  $query) use ($value) {
                            $query->where('shape', 'like', '%' . $value . '%');
                        });
                        $q->orWhereHas('ratti', function (Builder  $query) use ($value) {
                            $query->where('rati_standard', 'like', '%' . $value . '%');
                        });
                    }
                })->where('in_stock', 1)->take(30)->get();

            $this->searchResults = $results;
        }
        return view('livewire.main-search-bar');
    }
}
