<div class="card">
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
    var url = "{{ route('managerAccount.address.all',['/']) }}/"+accountId; 
    $.get(url,function(data){
       $("#all").html(data);
    });
}

function createAddress(){
   var accountId ='{{ $accountId }}';
   var  url ="{{route('managerAccount.address.create',['/'])}}/"+accountId;
    $.get(url,function(data){
        $("#createAddress").html(data);
    }); 
}

function saveAddress(){

     $.ajax({
       url : "{{ route('managerAccount.address.save') }}",
        method : "POST",
        data : $("#createForm").serialize(),
        success:function(data){
        if(data.errors){
              $.each(data.errors,function(field_name,error){
                      $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                      $(document).find('[name='+field_name+']').addClass('input-error');
          }); 
          setTimeout(hideErrors,8000); 
        }else{
           notify('Address Saved','success');
           all();
           $("#createAddress").html('');
        }
     },
     });
}




 function editAddress(id){

var url = "{{route('managerAccount.address.edit',['/'])}}/"+id;
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
   url : "{{ route('managerAccount.address.update') }}",
    method : "POST",
    data : $("#editForm").serialize(),
    success:function(data){
    if(data.errors){
          $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                  $(document).find('[name='+field_name+']').addClass('input-error') 

            }); 
      setTimeout(hideErrors,8000); 
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
         var url = "{{route('managerAccount.address.delete',['/'])}}/"+id;
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
   $("input").removeClass('input-error'); 
   $("select").removeClass('input-error'); 
 }


</script>