
@extends('layouts.admin.app')
@section('content')
<div class="container">
     
       @if ($errors->any())
    <div class="alert alert-danger lert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!--- Show Message When we save record or update ---->

 @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
       <h4>{{Session::get('success')}}</h4>
   </div>
@endif

    <div id="new_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                <div class="card-header text-secondary"><h2> Weight Range</h2></div>
                <div class="card-body">

				


			<form method="POST" action="{{ route('weight.range.store') }}" enctype="multipart/form-data">
				    @csrf
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right">From <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="color" type="text" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}"  autocomplete="clarity" autofocus>

				                @error('from')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right">To <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="alias" type="text" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="name" autofocus>

				                @error('to')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>


				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right">Rati Code <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="alias" type="text" class="form-control @error('rati') is-invalid @enderror" name="rati_code" value="{{ old('rati_code') }}"  autocomplete="name" autofocus>

				                @error('rati_code')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div

				       

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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

	<div id="edit_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                <div class="card-header">Edit Weight Range</div>
                <div class="card-body">

				<h2 class="center">Edit Weight Range Form </h2>

				

				<form method="POST" action="{{ route('weight.range.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right">From <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="ecolor" type="text" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}"  autocomplete="from" autofocus>

				                @error('from')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right">To <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="ealias" type="text" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="to" autofocus>

				                @error('to')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
                    
                      <div class="form-group row">
				            <label for="eraticode" class="col-md-4 col-form-label text-md-right">Rati Code <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="eraticode" type="text" class="form-control @error('rati_code') is-invalid @enderror" name="rati_code" value="{{ old('rati_code') }}"  autocomplete="name" autofocus>

				                @error('rati_code')
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

	@php


	@endphp

	
	

	<div class="row float-right">
     <div class="col-md-4">
	<a class="btn btn-success m-b-20"  href="{{route('weight.new.range')}}">Add New Weight Range</a>
    </div>
</div>

<h2 class="text-left text-info">Weight Range List</h2>
<div class='table-responsive'>
	<table class="table table-stripped" style="margin-top: 20px;" cellspacing="0" width="100%" id="weight_ranges_table">  
		<thead class="bg-primary text-white">
				<tr>
				<th>Sr</th>
				
				<th>From <br>(mg)</th>
				<th>To<br>(mg)</th>
				<th>Rati Standard<br>(From - To / 120 mg)</th>
				<th>Rati Big<br>(From - To / 180 mg)</th>
				<th>Carat<br>(From - To / 200 mg)</th>
			</thead>
		</tr>

		<tbody>
			   @if($data->isNotEmpty())
			@foreach($data as $ckey => $cval)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{ $cval->from }}</td>
				<td>{{ $cval->to}}</td>
				@php 
                 // From Division code
		 $from_rati_standard = round($cval->from/120,2);
         $from_rati_big = round($cval->from/180,2);
         $from_carat =round ($cval->from/200,2); 

            // to Divison code
         $to_rati_standard = round($cval->to/120,2);
         $to_rati_big = round($cval->to/180,2);
         $to_carat =round ($cval->to/200,2);

				@endphp
				<td><span class="text-gray-dark">({{$from_rati_standard}} - {{$to_rati_standard}})</span> <span class=" font-weight-bold m-l-5">{{ $cval->rati_standard}}+</span></td>
				<td><span class="text-gray-dark">({{$from_rati_big}} - {{$to_rati_big}})</span> <span class=" font-weight-bold m-l-5">{{ $cval->rati_big}}+</span></td>
				<td><span class="text-gray-dark">({{$from_carat}} - {{$to_carat}}) </span><span class=" font-weight-bold m-l-5">{{ $cval->carat}}+</span></td>
			

			</tr>
			@endforeach
			 @else
        <tr>
            <td colspan="9"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
          </tr>

      @endif
			
		</tbody>
	</table>
</div>
</div>

@section('script')

<script type="text/javascript">
	
	$(document).ready(function(){

   $("#weight_ranges_table").DataTable();
  
 $(".alert-success").delay('3000').fadeOut();

})

</script>


@endsection

@endsection
