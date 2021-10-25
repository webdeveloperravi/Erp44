@extends('layouts.admin.app')
@section('css')
@endsection
@section('content')
<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<select id="counrtyIndex" class="form-control" onchange="getStatesIndex(this.value)">
						<option disabled="" selected="">Select Country</option>
					 @foreach($countries as $country)
					 <option value="{{$country->id}}">{{$country->name}}</option>
					 @endforeach
					</select>
				</div>
				<div class="col-md-3">
					<select id="stateIndex" class="form-control" onchange="index(this.value)" class="form-group">
						<option disabled="" selected="">Select State</option>
					   </select>
				</div>
		<div class="col">
			{{-- <button class="btn btn-dark float-right" onclick="create()">Add Zone</button> --}}
		<div>
	</div>
		</div>
	</div>
</div>
	</div>
	<div id="errorMsg">
		
	</div>
	<div id="create">
		
	</div>
	<div id="index">
		
	</div>
	<div id="edit">
		
	</div> 

	

@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
     // create();
});

function createCity(stateId){

   var url ="{{route('city.create',['/'])}}/"+stateId;
   $.get(url,function(data){
       $("#create").html(data);
   });

}

function edit(cityId){
	var url ="{{route('city.edit',['/'])}}/"+cityId;
   $.get(url,function(data){
       $("#edit").html(data);
   });
}

function closeCity(){
	$("#create").html("");
}

function index(stateId){
      var url ="{{route('city.view',['/'])}}/"+stateId;
      $.get(url,function(data){
          $("#index").html(data);             
      });
}

 
function getStatesIndex(countryId){ 
	var url = "{{route('city.states',['/'])}}/"+countryId;
	$.get(url,function(data){
	$("#stateIndex").html(data);
	});
}

function editClose(){

	$("#edit").html("");
}
 
</script>

@endsection