<section id="basic-input">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class=" text-white m-b-0" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">
             <span class="text-right">Temporary Order No. #{{ Session::get('temp_number') }}</span></h5>
         </div>
         <div class="card-block">
            <div id="createPurchaseOrderPage">

            </div>
            
            <div id="editPurchaseOrderPage">
              
            </div>

            <div id="purchaseOrderDetails">
           
          </div>
         </div>
      </div>
    </div>
  </div>
<div id="success">
</div>
</section>
<script type="text/javascript">

$(document).ready(function(){
   create();
   purchaseOrderDetails();
});

function purchaseOrderDetails(){

var url ="{{route('purchaseorder.getAllDetails')}}";
$.get(url,function(data){
 $("#purchaseOrderDetails").html(data);
})

}	

function create()
{
 var url = "{{route('purchaseorder.createpage')}}";
 $.get(url,function(data){
   $('#createPurchaseOrderPage').html(data);
 })
}

 

function closeUpdate(){
 $("#edit").html("");
}

function storePurchaseOrderDetail(){
 
   $.ajax({
   url : "{{route('purchaseorder.detail.store')}}",
   method : "POST",
   data : $("#createForm").serialize(),
   success : function(data){ 
              if(data.errors){
              $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
              }); 
              setTimeout(hideErrors,5000); 
              }else{
                purchaseOrderDetails(); 
              }
          
           },
 });
}


function updatePurchaseOrderDetail(){

   $.ajax({
   url : "{{route('purchaseorder.detail.update')}}",
   method : "POST",
   data : $("#updateForm").serialize(),
   success : function(data){
              if(data.errors){
              $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
           }); 
           setTimeout(hideErrors,5000); 
              }else{
                $("#editPurchaseOrderPage").html('');
               createPurchaseOrder();
               purchaseOrderDetails();
               
                  //  $("#create").html(data);
              }
           },
 });
} 

function placeOrder(){
   var url = "{{ route('purchaseorder.placeorder') }}";
   $.ajax({
     method : "POST",
     url : url,
     data : $("#createForm").serialize(),
     success:function(data){
      if(data.errors){
              $.each(data.errors,function(field_name,error){
                  $("#vendorError").after('<span class="text-strong text-danger">' +error+ '</span>')
              }); 
              setTimeout(hideErrors,5000); 
      }
      if(data.success){
        swal(data.msg);
        $("#create").html('');
          allPurchaseOrders();
      }
     }
   }); 
}

  function hideErrors(){ 
   $(".text-danger").remove(); 
  }

  function deleteDetail(detailId){
      var url ="{{ route('purchaseorder.detail.delete',['/']) }}/"+detailId;
      $.get(url,function(data){
        purchaseOrderDetails();
      });
  }

    function editDetail(detailId){
      var url ="{{ route('purchaseorder.detail.edit',['/']) }}/"+detailId;
      $.get(url,function(data){
        $("#createPurchaseOrderPage").remove();
       $("#editPurchaseOrderPage").html(data); 
      });
  }



</script> 