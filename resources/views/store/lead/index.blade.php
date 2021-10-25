@extends('layouts.store.app')
@section('content')
  
@can('store-create', 'lead.index')
<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Add Lead</button>
   </div>
</div>
@endcan  
 
  
<div id="create">
   
</div>

@can('store-read','lead.index')
<div id="all">
           
</div>
@endcan  
 

 
<div id="edit">
           
</div>


@section('script')
<script type="text/javascript">

$(document).ready(function(){
  all();
});
 function create(){
      var url ="{{ route('lead.create') }}";
      $.get(url,function(data){
         $("#create").html(data);
      });
 }

 function all(){
    var url ="{{ route('lead.all') }}";
      $.get(url,function(data){
         $("#all").html(data);
      });
 }

 
 function saveLead(){
      hideErrors();
     $.ajax({
       url : "{{ route('lead.store') }}",
       method : "POST",
       data : $("#createForm").serialize(),
       success:function(data){
          if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>');
                        $(document).find('[name='+field_name+']').addClass('input-error');

              var offset = $("#create").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);


            }); 
            // setTimeout(hideErrors,8000); 
          }else{
              notify('Lead Saved','success');
            all();
            $("#create").html("");
          }
       },
     });
 }

 function hideErrors(){ 
 $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  $('textarea').removeClass('input-error');
  $('select').removeClass('input-error');

}
</script>
@endsection
@endsection