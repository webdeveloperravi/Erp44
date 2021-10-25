   <div class="row"> 
    <div class="col">
   <button class="btn btn-dark float-right mb-2" onclick="createManagerAccount()">Create Manager</button>
     </div>
 </div>  
<div id="create"></div>
<div id="all2"></div>
<script>
    $(document).ready(function(){
      // createManagerAccount();
      getManagerAccounts();
    });

function createManagerAccount(){
 
    var url = "{{ route('subStore.managerAccount.create',['/']) }}/"+"{{ $store->id }}";
    $.get(url,function(data){
       $("#create").html(data);
    });
}

function saveManager(){
    
    $.ajax({
      url : "{{ route('subStore.managerAccount.save') }}",
       method : "POST",
       data : $("#createForm").serialize(),
       success:function(data){
       if(data.errors){
             $.each(data.errors,function(field_name,error){
                     $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                     $(document).find('[name='+field_name+']').addClass('input-error');

         }); 
         var offset = $("#create").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
         setTimeout(hideErrors,5000); 
       }else{ 
         swal(data.message);
         $("#create").html("");
          getManagerAccounts();
       }
    },
    });
}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error'); 
   $("select").removeClass('input-error'); 
 }

function getManagerAccounts(){
  var url = "{{ route('subStore.manager.getAccounts',['/']) }}/"+"{{$store->id}}";
  $.get(url,function(data){
     $("#all2").html(data);
  });

}
 
  

</script>