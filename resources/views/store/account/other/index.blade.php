@extends('layouts.store.app')
@section('content') 

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark  f-right mb-2" onclick="createOtherAccount()">Create Other</button>
    </div>
</div>  
<div id="create"></div>
<div id="all"></div>

@endsection
@section('script')

<script>
    $(document).ready(function(){ 
      getOtherAccounts();
    });
 
 function createOtherAccount(){
    $("#create").html("");
     var url = "{{ route('otherAccount.create') }}";
     $.get(url,function(data){
        $("#create").html(data);
     });
 }

 function saveOther(){
     
     $.ajax({
       url : "{{ route('otherAccount.save') }}",
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
          setTimeout(hideErrors,8000); 
        }else{
         swal(data.message);
         $("#create").html('');
           getOtherAccounts();
        }
     },
     });
}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error');
   $("select").removeClass('input-error');
 }

function getOtherAccounts(){
   var url = "{{ route('otherAccount.all') }}";
   $.get(url,function(data){
      $("#all").html(data);
   });
}


function changeOtherAccountStatus(storeId){
  var url = "{{ route('otherAccount.changeStatus',['/']) }}/"+storeId;
  $.get(url,function(data){
     getOtherAccounts();
     notify('Status Updated','success');
  });
}


</script>
@endsection