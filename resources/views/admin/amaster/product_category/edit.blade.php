@extends('layouts.admin.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-12 col-sm-12">
<div class="card" class="showForm" >

 

<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Product Category</h5>
      </div> 
<div class="card-body">
<form method="POST" action="{{route('product.type.update')}}" enctype="multipart/form-data">
@csrf
<input id="edit" type="hidden" name="product_type_id" value="{{$product_edit['id']}}">
<div class="form-group row">
<label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Product Category Name <span class="alert-danger">*</span></label>
<div class="col-md-6">
<input id="ecolor" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$product_edit['name']}}"  autocomplete="name" autofocus>

@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>

<div class="form-group row" id="read_prefix_code">
<label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Alias</label>
<div class="col-md-6">

<input id="ecolor" type="text" class="form-control @error('name') is-invalid @enderror" name="alias" value="{{$product_edit['alias']}}"  autocomplete="name" autofocus>
</div>
</div>



<!----------Prefix Write Code ---------Div Close------->

{{-- <div class="form-group row">
<label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Master<span class="alert-danger">*</span></label>
<div class="col-md-6">
<select class="form-control" name='masters[]' multiple="">
<option>Select Master</option>
@foreach($masters as $master)

<option value="{{ $master->id }}"   @foreach($product_edit->masters as $list){{$list->id == $master->id ? 'selected': ''}}   @endforeach> {{ $master->name }}</option>

@endforeach
</select>

</div>
</div> --}}

<div class="form-group row">
<label for="image" class="col-md-4 col-form-label text-md-right text-secondary">preview</label>
<div class="col-md-6">
<input type="hidden" name="preview_image" value="{{$product_edit->image}}">
<img src="{{url('admin/'.$product_edit->image)}}" class="img img-circle" alt="No Image" width="100" class="form-control">
<button type="button" onclick="showForm()" class="btn btn-primary btn-sm  btn-out-dashed">Change Image</button>
</div>

</div>
<div class="edit_image" style="display: none;">
<div class="form-group row">
<label for="image" class="col-md-4 col-form-label text-md-right text-secondary">Image</label>
<div class="col-md-6">
<input id="edesc" type="file"   name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}"  autocomplete="name" autofocus >

@error('image')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror

</div>
</div>
</div>



<div class="form-group row mb-0">
<div class="col-md-6 offset-md-4">
<button type="submit" class="btn btn-success">Update                                </button>
<a href="{{ url()->previous()}}" class="btn btn-warning">Cencel</a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
@section('script')
<script type="text/javascript">
	function valuechange(){
      
      if($("#check_prefix_rewrite").is(':checked'))
      {
      	 
         $("#write_prefix_code").show();
         $("#read_prefix_code").hide();
      }		
	}
	
</script>
  

@endsection
@endsection