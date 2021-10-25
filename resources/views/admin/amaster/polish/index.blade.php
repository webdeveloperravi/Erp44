@extends('layouts.admin.app')
@section('content')

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Create Polish</button>
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

let url ="{{route('polish.create')}}";
  $.get(url,function(data){
   
   $("#create").html(data);

  })
}

function all(){

let url ="{{route('polish.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function editPolish(id)
{
let url ="{{route('polish.edit',['/'])}}/"+id;
  $.get(url,function(data){
   
   $("#edit").html(data);

  })

}




</script>
@endsection

@endsection


  

