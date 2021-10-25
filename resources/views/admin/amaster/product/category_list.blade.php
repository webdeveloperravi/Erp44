 <div class="row">         
<h1 id="msg" style="right: 20px; position: fixed; z-index: 1; background-color: greenyellow; padding: 20px;"> </h1>
<!-- Color Open Accordion start -->
<div class="col-lg-12">

@foreach($product as $pkey => $pval)

@php
//
//  dump($pval->attribute);
@endphp
<div class="card" style="border: 1px solid grey;" >
<div class="card-header">
<h3 class="">{{$pval->name}}</h3>

<a onclick="show('pro_'+{{$pval->id}})" >  show detail 11</a>

</div>


<div id="pro_{{$pval->id}}"  class="card" style="display:none; margin-left: 45px; border: 1px solid grey;" >
<!-- 
<a onclick="show('cat_'+{{$pval->id}})" >+ Category</a>

<div id="cat_{{$pval->id}}" style="display:none;"> 
<form method="post" action="{{route('product.cat.store')}}">
@csrf
<input type="hidden" name="type_id" value="{{$pval->id}}">  
<input type="text" name="name" placeholder="category Name 12">
<input type="text" name="alias" placeholder="alias name">
<button type="submit"> Save Category</button>
</form>
</div> -->
@if($pval->category()->exists())
@foreach($pval->category->where('parent_id', 0) as $key => $val)
<div class="card-header">
<h5 class="card-header-text" onclick="show('child_'+{{$val->id}})" >  {{$val->name}}
</h5>


@if(!$val->subcat()->exists()) 


@include('admin.amaster.product.associate_links')  


<i class="fas fa-pencil-alt" onclick="updateCategory('edit_'+{{$val->id }})" style="cursor: pointer"></i>

<form id="edit_{{$val->id}}" style="display:none;" method="POST"  enctype="multipart/form-data" class="update_category">
@csrf
<div class="form-group row" style="margin-top:4px;">
<div class="col-md-3 col-sm-4">
<input type="hidden" name="id" value="{{ $val->id }}">
<input type="text" class="form-control" value="{{ $val->name }}" name="name">
</div>
<input type="submit" class="btn btn-sm btn-warning" style="border-radius: 10px;" value="Update">                          

</div>
</form> 

@else 

->

@endif

{{--   <a onclick="show('scat_'+{{$val->id}})"  style="cursor: pointer;" > Sub Category </a>
--}}
{{--    <div id="scat_{{$val->id}}" style="display:none;" >
<form method="post" action="{{route('product.cat.store')}}">
@csrf


<input type="hidden" name="type_id" value="{{$pval->id}}">	
<input type="hidden" name="parent_id" value="{{$val->id}}">	
<input type="text" name="name" placeholder="category Name 1213">
<input type="text" name="alias" placeholder="alias name">
<button type="submit"> Save Category</button>
</form>
</div> --}}

</div>
@if($val->subcat()->exists())

@if($val->subcat()->exists())
@include('admin.amaster.product.sub_category', ['sub' => $val->subcat, "parent_id"=>$val->id ])
@endif
@endif
@endforeach
@endif
</div>
@endforeach

</div>
</div>
                              <!-- Color Open Accordion ends -->
                                   
</div>








