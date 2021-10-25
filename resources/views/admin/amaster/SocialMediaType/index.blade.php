@extends('layouts.admin.app')
@section('content')
   
<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Add Type</button>
   </div>
</div> 
 
  
<div id="create">
   
</div>
 
<div id="all">
           
</div> 
 
<div id="edit">
           
</div>


@section('script')
<script type="text/javascript">

$(document).ready(function(){
  all();
});
 function create(){
      var url ="{{ route('socialMediaType.create') }}";
      $.get(url,function(data){
         $("#create").html(data);
      });
 }
 

 function all(){
    var url ="{{ route('socialMediaType.all') }}";
      $.get(url,function(data){
         $("#all").html(data);
      });
 }

 
 function store(){
      hideErrors();
     $.ajax({
       url : "{{ route('socialMediaType.store') }}",
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
          }else{
              notify('Saved','success');
            all();
            $("#create").html("");
          }
       },
     });
 }
 
 function edit(typeId){
      var url ="{{ route('socialMediaType.edit',['/']) }}/"+typeId;
      $.get(url,function(data){
         $("#edit").html(data);
      });
 }

 
 function update(){
      hideErrors();
     $.ajax({
       url : "{{ route('socialMediaType.update') }}",
       method : "POST",
       data : $("#editForm").serialize(),
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
          }else{
              notify('Updated','success');
            all();
            $("#edit").html("");
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