@extends('layouts.admin.app')
@section('content')

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Create Fluoresecnce</button>
    </div>
</div>

<div id="create">


</div>

<div id="all">

</div>

<div id="edit">

</div>




@section('script')
<script type="text/javascript">
	
$(document).ready(function () {
	all();
});	

function create(){

let url ="{{route('fluorescence.create')}}";
  $.get(url,function(data){
   
   $("#create").html(data);

  })
}

function all(){

let url ="{{route('fluorescence.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function editFluorescence(id)
{
let url ="{{route('fluorescence.edit',['/'])}}/"+id;
  $.get(url,function(data){
   
   $("#edit").html(data);

  })

}




</script>
@endsection

@endsection


  

