@extends('layouts.store.app')
@section('content') 
 


<div class="card" id="form">
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Stock Transactions</h5>
     </div>
  
  <div class="card-body">
   <div class="row">
    <div class="col col-md-3">
      <button class="btn btn-primary" value="1" onclick="list(this.value)">Managers</button>
  </div>
   <div class="col col-md-3">
      <button class="btn btn-primary" value="17" onclick="list(this.value)">Accounts</button>
  </div>
 
  </div>
 </div>
  
<div id="details" class="container"></div>

<div id="stockledgerView" class="container">
  

</div>


</div>
<div class="row">
 <div class="col col-md-12">
 <div id="stockTransactionDetail"></div>
</div>
 </div>





@endsection
@section('script')
<script>
$(document).ready(function(data){
   //view()
});


function list(id){
 
 var url = "{{route('stockLedger.account',['/'])}}/"+id;
 $.get(url,function(data){

  $("#details").html(data);
  $("#stockledgerView").html('');
  $("#stockTransactionDetail").html('');
 })

}

//Ledger
function view(){
    $("#create").html("");
     var url = "{{ route('stockLedger.view') }}";
     $.get(url,function(data){
        $("#create").html(data);
     });
}

function getLedger(id){
    // $("#create").html("");
     var url = "{{ route('stockLedger.all',['/']) }}/"+id;
     $.get(url,function(data){
        $("#stockledgerView").html(data); 
        $("#stockTransactionDetail") .html('');     
      
     });
}

function stockTransactionDetail(id){
   var url = "{{ route('stockTransactionDetails',['/']) }}/"+id;
   $.get(url,function(data){
      $("#stockTransactionDetail") .html(data);     
   })
}


//Issue Stock

//  function createIssueStock(){
//     $("#create").html("");
//      var url = "{{ route('stockLedger.issueStock.create') }}";
//      $.get(url,function(data){
//         $("#create").html(data);
//      });
//  }

//  function saveIssueStock(){
     
//      $.ajax({
//        url : "{{ route('stockLedger.issueStock.save') }}",
//         method : "POST",
//         data : $("#createForm").serialize(),
//         success:function(data){
//         if(data.errors){
//               $.each(data.errors,function(field_name,error){
//                       $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
//           }); 
//           setTimeout(hideErrors,5000); 
//         }else{ 
//            // window.location.href=data.url;
//            $("#create").html(data);
//         }
//      },
//      });
// }

// //Receive Stock

//  function createReceiveStock(){
//     $("#create").html("");
//      var url = "{{ route('stockLedger.receiveStock.create') }}";
//      $.get(url,function(data){
//         $("#create").html(data);
//      });
//  }
 

//  function saveReceiveStock(){
     
//       $.ajax({
//         url : "{{ route('stockLedger.receiveStock.save') }}",
//          method : "POST",
//          data : $("#createForm").serialize(),
//          success:function(data){
//          if(data.errors){
//                $.each(data.errors,function(field_name,error){
//                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
//            }); 
//            setTimeout(hideErrors,5000); 
//          }else{ 
//             // window.location.href=data.url;
//             $("#create").html(data);
//          }
//       },
//       });
//  }



 // 

</script>
@endsection