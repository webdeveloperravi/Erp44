
@extends('layouts.admin.app')
@section('content')
<div class="container">
   
   
	<div id="edit_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                <div class="card-header">Edit Weight Range Unit Price</div>
                <div class="card-body">

				<h2 class="center">Edit Unit Price Form </h2>

				

				<form method="POST" action="{{ route('unit.price.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right">Price <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="ecolor" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}"  autocomplete="color" autofocus>

				                @error('price')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Save
                                </button>
                            </div>
                        </div>
				 </form>
				</div>
			</div>
		</div>
	</div>







   <h3>Weight Range Unit Price List</h3><br/>

	<table class="table table-striped"> 
		<tr>
			<thead>
				<th>Sr</th>
				<th>Price</th>
				<th>status</th>
				<th>Action</th>
			</thead>
		</tr>

		<tbody>
			@foreach($data as $ckey => $cval)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{ $cval->price }}</td>
				<td>{{ ($cval->status==1?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('unit.price.status',['id'=>$cval->id , 'status'=>$cval->status])}}">{{ ($cval->status==1?"In-active":"Active")}} </a> 
					<a href="{{route('unit.price.destroy',['id'=>$cval->id])}}"> Delete</a>  
					<button onclick="edit_color({{$cval->id}} , '{{$cval->price}}')"> edit </button> 
					
										</td>

			</tr>
			@endforeach
			
		</tbody>
</div>

@endsection
