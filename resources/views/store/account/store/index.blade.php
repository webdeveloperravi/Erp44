@extends('layouts.store.app')
@section('content') 

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark  f-right mb-2" onclick="createStoreAccount()">Create Store</button>
    </div>
</div>  
{{-- <form onsubmit="event.preventDefault(0)" id="searchForm">
   @csrf
<div class="row">
   <div class="col col-xl-4 col-md-3">
       <div class="form-group">
           <label for="parentId">Search Store:</label>
           <input  type="text" id="find" name="find" class="form-control" onkeypress="javascript: if(event.keyCode == 13) findStore();" autocomplete="off">
       </div>
   </div> 
   <div class="col col-xl-4 col-md-4">
<div class="form-group">
<label for="parentId" class="invisible d-block">Hidden</label>
<button type='button' class="btn btn-sm btn-dark"  onclick="searchStore()">Search</button>
</div>
</div>  
</div> 
</form>  --}}
<div id="create"></div>
<div id="all"></div>

@endsection
@section('script')

<script>
    $(document).ready(function(){ 
      getStoreAccounts();
    });
 
 function createStoreAccount(){
    $("#create").html("");
     var url = "{{ route('storeAccount.create') }}";
     $.get(url,function(data){
        $("#create").html(data);
     });
 }

 function saveStore(){
     
     $.ajax({
       url : "{{ route('storeAccount.save') }}",
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
           getStoreAccounts();
        }
     },
     });
}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error');
   $("select").removeClass('input-error');
 }

function getStoreAccounts(){
   var url = "{{ route('store.getAccounts') }}";
   $.get(url,function(data){
      $("#all").html(data);
   });
}


function changeStoreAccountStatus(storeId){
  var url = "{{ route('storeAccount.changeStatus',['/']) }}/"+storeId;
  $.get(url,function(data){
     getStoreAccounts();
     notify('Status Updated','success');
  });
}

function searchStore(){
     
     $.ajax({
       url : "{{ route('storeAccount.searchStore') }}",
        method : "POST",
        data : $("#searchForm").serialize(),
        success:function(data){
         $("#all").html(data);
     },
     });
}
 
</script>
@endsection