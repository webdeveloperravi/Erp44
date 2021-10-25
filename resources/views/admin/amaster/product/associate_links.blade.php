    @php 
        $product = App\Model\Admin\Master\ProductCategory::where(['id'=>$product_type])->first();
    @endphp

		@foreach ($product->masters->sortBy('name') as  $value) 
		@php
			// dump($val->id);
		@endphp
                   	    <a  class="m-l-10" onclick="show1('{{$value->name}}'+'_'+'{{$val->id}}')" style="cursor: pointer;" >{{$value->name}} | </a>
        @endforeach
          
     @include('admin.amaster.product.color',['cat_id'=>$val->id, 'color'=>$color,'assigned_color'=>$val->colors])
	@include('admin.amaster.product.clarity',['cat_id'=>$val->id, 'clarity'=>$clarity,'assigned_clarity'=>$val->clarity])

	@include('admin.amaster.product.shape',['cat_id'=>$val->id, 'shape'=>$shape,'assigned_shape'=>$val->shape])

  	@include('admin.amaster.product.origin',['cat_id'=>$val->id, 'origin'=>$origin,'assigned_origin'=>$val->origin])

  	@include('admin.amaster.product.grade',['cat_id'=>$val->id, 'grade'=>$grade,'assigned_grade'=>$val->grade, 'cat'=>$cat])

  	@include('admin.amaster.product.specie',['cat_id'=>$val->id, 'specie'=>$specie,'assigned_specie'=>$val->specie])

  	@include('admin.amaster.product.ri', ['cat_id'=>$val->id, 'ri'=>$master['ri'], 'assigned_ri'=>$val->ri])

  	@include('admin.amaster.product.sg', ['cat_id'=>$val->id, 'sg'=>$master['sg'], 'assigned_sg'=>$val->sg])

  @include('admin.amaster.product.treatment',['cat_id'=>$val->id, 'treatment'=>$master['treatment'],'assigned_treatment'=>$val->treatment])
  
  @include('admin.amaster.product.hsn_code',['cat_id'=>$val->id, 'hsncode'=>$hsn_code,'assigned_hsncode'=>$val->hsn_code])

