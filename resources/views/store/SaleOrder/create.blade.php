@extends('layouts.store.app')
@section('content') 
<div class="row">
    <div class="col-md-12">
      <div id="createPurchaseOrderPage">
      </div>
    </div>
</div> 
<div id="success">
</div> 
 
@endsection
@section('script')
<script type="text/javascript">
$('.sweet-1').on('click',function(){
        swal("Hey Saab");
  });

$(document).ready(function(){
   create();
   
});

function saleOrderDetails(){

var url ="{{route('saleOrder.getAllDetails')}}";
$.get(url,function(data){
 $("#saleOrderDetails").html(data);
})

}	

function create()
{
 var url = "{{route('saleOrder.createpage')}}";
 $.get(url,function(data){
   $('#createPurchaseOrderPage').html(data);
   saleOrderDetails();
 })
}

function getGrades(productId){

var url ="{{route('saleOrder.getGrades',['/'])}}/"+productId;
$.get(url,function(data){
    $("#grades").html(data);
});
}

function closeUpdate(){
 $("#edit").html("");
}

function storePurchaseOrderDetail(){

   $.ajax({
   url : "{{route('saleOrder.detail.store')}}",
   method : "POST",
   data : $("#createForm").serialize(),
   success : function(data){
              if(data.errors){
              $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
           }); 
           setTimeout(hideErrors,5000); 
              }else{
                saleOrderDetails();
                  //  $("#create").html(data);
              }
              
           },
 });
} 

function checkBuyer(){
  if($("#buyerId").val() == null){
    return false
  }else{
    return true
  }
}

function placeOrder2(){  
  if($("#buyerId").val() == 0){
    swal({
      title : '! Select Buyer Store',
      type: "warning",
    }) 
    
  }else{
    swal({
			title: "Are you Sure",
			text: "To Place Sale Order",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		}, function () {

    var buyerId = $("#buyerId").val();
    var url = "{{ route('saleOrder.placeorder',['/']) }}/"+buyerId;  
   $.get(url,function(data){ 
          swal({
            title: "Sale Order Created Successfully",
            text: "You clicked the button!",
            icon: "success",
            button: "Back to Sale Orders",
          });
          swal(data.msg)
          location.href = "{{ route('saleOrder.index') }}"; 
          }); 
       

			// setTimeout(function () {
			// 	swal("Ajax request finished!");
			// }, 2000);
		});

   



 
  }
}

function hideErrors(){ 
  $(".text-danger").remove(); 
}

function deleteDetail(detailId){
    var url ="{{ route('saleOrder.detail.delete',['/']) }}/"+detailId;
    $.get(url,function(data){
      saleOrderDetails();
    });
}
</script> 
@endsection