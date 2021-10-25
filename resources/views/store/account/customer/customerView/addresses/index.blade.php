<div class="card">
   <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Customer Addresses</h5>
   </div> 
   <div class="row"> 
      <div class="col">
         <button class="btn btn-dark float-right mb-3 mr-2" onclick="createAddress()">Create Address</button>
      </div>
   </div> 
   <div  id="createAddress"> </div>
<div class="card-body" id="all"> </div>
</div>
<script>
 all();

function all(){
   var accountId ='{{ $accountId }}';
    var url = "{{ route('customerAccount.address.all',['/']) }}/"+accountId; 
    $.get(url,function(data){
       $("#all").html(data);
    });
}

function createAddress(){
   var accountId ='{{ $accountId }}';
   var  url ="{{route('customerAccount.address.create',['/'])}}/"+accountId;
    $.get(url,function(data){
        $("#createAddress").html(data);
    }); 
}

function saveAddress(){

     $.ajax({
       url : "{{ route('customerAccount.address.save') }}",
        method : "POST",
        data : $("#createForm").serialize(),
        success:function(data){
        if(data.errors){
              $.each(data.errors,function(field_name,error){
                      $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          }); 
          setTimeout(hideErrors,5000); 
        }else{
           notify('Address Saved','success');
           all();
           $("#createAddress").html('');
        }
     },
     });
}


function editAddress(id){

var url = "{{route('customerAccount.address.edit',['/'])}}/"+id;
$.get(url,function(data){
 $("#createAddress").html(data)

})
  var offset = $("#createAddress").offset();
     $('html, body').animate({
        scrollTop: offset.top,
        scrollLeft: offset.left
     }, 1000);
}

function updateAddress(){

$.ajax({
   url : "{{ route('customerAccount.address.update') }}",
    method : "POST",
    data : $("#editForm").serialize(),
    success:function(data){
    if(data.errors){
          $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
      }); 
      setTimeout(hideErrors,5000); 
    }else{
       notify('Address Updated','success');
       all();
       $("#createAddress").html('');
    }
 },
 });

}

function deleteAddress(id){
   swal({
   title: "Are you sure?",
   text: "Once deleted, you will not be able to recover this Address!",
   icon: "warning",
   buttons: true,
   dangerMode: true,
   })
   .then((willDelete) => {
      if (willDelete) {
         var url = "{{route('customerAccount.address.delete',['/'])}}/"+id;
      $.get(url,function(data){

      if(data.success){
         swal(data.message);
         all();
      }
      });
      swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
      });
   } else {
       
   }
   });
 

}

function hideErrors(){ 
   $(".text-danger").remove(); 
 }


</script>