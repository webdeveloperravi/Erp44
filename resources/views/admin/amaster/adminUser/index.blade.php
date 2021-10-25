@extends('layouts.admin.app')
@section('content')

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Create</button>
    </div>
</div>

<div id="create">


</div>
<div id="edit">

</div>

<div id="all">

</div>


@endsection


@section('script')
<script type="text/javascript">
	
$(document).ready(function () {
	all();
});	

function create(){

let url ="{{route('adminUser.create')}}";
  $.get(url,function(data){
   
   $("#create").html(data);

  })
}

function all(){

let url ="{{route('adminUser.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function edit(id)
{
let url ="{{route('adminUser.edit',['/'])}}/"+id;
  $.get(url,function(data){
    var offset = $("#edit").offset();
    $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
    }, 1000);
   $("#edit").html(data);

  })

}

function updateStatus(userId){
  var url = "{{ route('adminUser.changeStatus',['/']) }}/"+userId;
  $.get(url,function(data){
      all();
  });
}




</script>
@endsection
 

  

