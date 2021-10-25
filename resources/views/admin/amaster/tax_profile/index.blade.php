@extends('layouts.admin.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-12">
    <div class="card" class="showForm" >
      
        <div class="card-body">
		<h2 class="center"> Tax Profile Form </h2>
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
    @if(Session::has('error'))
  {{-- <h3 class="alert alert-danger"> {{Session::get('error')}} </h3> --}}
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
   {{Session::get('error')}} .
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

		<form method="POST" action="{{ route('taxprofile.store') }}" enctype="multipart/form-data">
		    @csrf
		        <div class="form-group row">
		            <label for="country" class="col-md-4 col-form-label text-md-right">Product <span class="alert-danger">*</span>  </label>

		            <div class="col-md-6">
		                <select name="hsn_code"  class="form-control" > 
		                	<option value="">Select Product</option>

		                	@foreach($productType as $id => $name)
		                	  <option value="{{$id}}">{{$name}} - ({{$id}})</option>
		                	@endforeach
		                </select>
		            </div>
		        </div>

		        


				<div class="form-group row">
		            <label for="igst" class="col-md-4 col-form-label text-md-right">IGST % <span class="alert-danger">*</span> </label>
		            <div class="col-md-6">
		                <input id="igst" type="text" class="form-control @error('igst') is-invalid @enderror" name="igst" value="{{ old('igst') }}"  autocomplete="quantity" autofocus>

		                @error('igst')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		        </div>
<div class="form-group row">
		            <label for="cgst" class="col-md-4 col-form-label text-md-right">CGST %</label>
		            <div class="col-md-6">
		                <input id="cgst" type="text" class="form-control @error('cgst') is-invalid @enderror" name="cgst" value="{{ old('cgst') }}"  autocomplete="quantity" autofocus>

		                @error('cgst')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		        </div>
<div class="form-group row">
		            <label for="sgst" class="col-md-4 col-form-label text-md-right">SGST %</label>
		            <div class="col-md-6">
		                <input id="sgst" type="text" class="form-control @error('sgst') is-invalid @enderror" name="sgst" value="{{ old('sgst') }}"  autocomplete="quantity" autofocus>

		                @error('sgst')
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
 
<table class="table"> 
		<thead>
			<tr>
				<th>Sr</th>
				<th>Product</th>
				<th>HSN Code</th>
				<th>IGST %</th>
				<th>CGST %</th>
				<th>SGST %</th>
				<th>created On</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tax as $key => $val)
			<tr>
				<!-- <td>{{ $val->id }}</td> -->
				<td>{{$loop->iteration}}</td>
				 <td>{{$val->product->name}}</td> 
				<td>{{$val->hsn_code}}</td>
				<td>{{$val->igst}}</td>
				<td>{{$val->cgst}}</td>
				<td>{{$val->sgst}}</td>
				<td>{{date('d-m-Y',strtotime($val->created_at)) }}</td>
				<td>{{($val->status==0?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('taxprofile.status',['id'=>$val->id , 'status'=>$val->status])}}">{{ ($val->status==0?"In-Active":"Active")}} </a> 
					 </td>
			</tr>
			@endforeach
		</tbody>
	</table>




	</div>


@endsection