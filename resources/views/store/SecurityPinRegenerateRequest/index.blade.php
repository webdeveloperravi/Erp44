@extends('layouts.store.app')
@section('content')
 
 

<div id="all">

</div>

 




@section('script')
<script type="text/javascript">
	
$(document).ready(function () {
	all();
});	

 

function all(){

let url ="{{route('securityPinRegenerateRequest.all')}}";
  $.get(url,function(data){
   
   $("#all").html(data);

  })
}

function regenerateNow(requestId){
//   swal({
//   title: "Are you sure?",
//   text: "To Process Security Pin Regenerate",
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {
  


//   } else {
//     swal("Process Cancelled");
//   }
// });

if(confirm(`Are you sure? To Process Security Pin Regenerate`)){
  var url = "{{route('securityPinRegenerateRequest.resolve')}}";
  $.ajax({
    method: 'POST',
    url : url,
    data : {
      _token : "{{ csrf_token() }}", 
      requestId : requestId,
    },
    success: function(data){ 
    //     swal(`Security Pin Issued to user's Contact`, {
    //   icon: "success",
    //   text : data.msg

    // });
    alert(`Security Pin Issued to user's Contact ${data.msg}`);
      all();
    }
  });
}else{
  alert('Process Canceld');
}

  
}

 




</script>
@endsection

@endsection


  

