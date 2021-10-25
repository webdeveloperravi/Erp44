
   {{-- <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Store Addresses</h5>
   </div>  --}}
   <div class="row"> 
      <div class="col">
         <button class="btn btn-dark float-right mb-3 mr-2" onclick="createAddress()">Create Address</button>
      </div>
   </div> 
   <div  id="createAddress"> </div>
<div class="" id="all"> </div>

<script>
 all();

function all(){
   var accountId ='{{ $accountId }}';
    var url = "{{ route('storeAccount.address.all',['/']) }}/"+accountId; 
    $.get(url,function(data){
       $("#all").html(data);
    });
}

function createAddress(){
   var accountId ='{{ $accountId }}';
   var  url ="{{route('storeAccount.address.create',['/'])}}/"+accountId;
    $.get(url,function(data){
        $("#createAddress").html(data);
    }); 
}

function saveAddress(){

     $.ajax({
       url : "{{ route('storeAccount.address.save') }}",
        method : "POST",
        data : $("#createForm").serialize(),
        success:function(data){
        if(data.errors){
              $.each(data.errors,function(field_name,error){
                      $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                      $(document).find('[name='+field_name+']').addClass('input-error');
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

var url = "{{route('storeAccount.address.edit',['/'])}}/"+id;
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
   url : "{{ route('storeAccount.address.update') }}",
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
//    swal({
//   title: "Are you sure?",
//    text: "Once deleted, you will not be able to recover this Address!",
//    icon: "warning",
//    buttons: true,
//    dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {
       var url = "{{route('storeAccount.address.delete',['/'])}}/"+id;
      $.get(url,function(data){

      if(data.success){
         swal(data.message);
         all();
      }
      });
//     swal("Deleted Successfully!", {
//       icon: "success",
//       });
//   } else {
//     swal("Your imaginary file is safe!");
//   }
// });
 
 

}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error');
   $("select").removeClass('input-error');
 }


</script>