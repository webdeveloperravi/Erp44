@extends('layouts.store.app')
@section('content') 

<div class="row"> 
    <div class="col">
      <button class="btn btn-dark float-right mb-2" onclick="createManagerAccount()">Create Manager</button>
     </div>
 </div>  
<div id="create"></div>
<div id="all"></div>

@endsection
@section('script')

<script>
    $(document).ready(function(){
      // createManagerAccount();
      getManagerAccounts();
    });

function createManagerAccount(){
 
    var url = "{{ route('managerAccount.create') }}";
    $.get(url,function(data){
       $("#create").html(data);
    });
}

function saveManager(){
    
    $.ajax({
      url : "{{ route('managerAccount.save') }}",
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
         notify('Manager Successfully Created','success');
         $("#create").html("");
          getManagerAccounts();
       }
    },
    });
}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("select").removeClass('input-error'); 
   $("textarea").removeClass('input-error'); 
   $("input").removeClass('input-error'); 
   
 }

function getManagerAccounts(){
  var url = "{{ route('manager.getAccounts') }}";
  $.get(url,function(data){
     $("#all").html(data);
  });

}

function changeManagerAccountStatus(managerId){
  var url = "{{ route('manager.changeStatus',['/']) }}/"+managerId;
  $.get(url,function(data){
      getManagerAccounts();
  });
}

  

</script>
@endsection