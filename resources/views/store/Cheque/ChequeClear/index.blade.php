@extends('layouts.store.app')
@section('content')

<div class="row"> 
  <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Clear Cheque</button>
  </div>
</div>

<div id="create"></div>

<div id="all" class="card"></div>

<div id="edit"></div>




@section('script')
<script type="text/javascript">
	
$(document).ready(function () {
	all();
});	

function create(){

let url ="{{route('chequeClear.create')}}";
  $.get(url,function(data){
   
   $("#create").html(data);

  })
}





function all(){

let url ="{{route('chequeClear.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function edit(id)
{
let url ="{{route('chequeClear.edit',['/'])}}/"+id;
  $.get(url,function(data){
   
   $("#edit").html(data);

  })

}
 


    function save(){

  let url ="{{route('chequeClear.store')}}";
  let formData = $("#createForm").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#create").html('');
               all();
               }else{
                  $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
               }
            }, 
        });
    }


    function hideErrors(){ 
   $(".text-danger").remove(); 
 }
    




</script>
@endsection

@endsection


  

