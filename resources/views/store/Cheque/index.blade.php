@extends('layouts.store.app')
@section('content')

<div class="row"> 
  <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Add Cheque</button>
  </div>
</div>

<div id="create"></div>

<div id="all" class=""></div>


<div id="edit"></div>




@section('script')
<script type="text/javascript">
	
$(document).ready(function () {
	all();
});	

function create(){

let url ="{{route('cheque.create')}}";
  $.get(url,function(data){
   
   $("#create").html(data);

  })
}

function all(){

let url ="{{route('cheque.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function edit(id)
{
let url ="{{route('cheque.edit',['/'])}}/"+id;
  $.get(url,function(data){
   
   $("#edit").html(data);

  })

}




</script>
@endsection

@endsection


  

