 
   
<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="createSocial({{ $leadId }})">Add Social</button>
   </div>
</div> 
 
  
<div id="createSocial">
   
</div>
 
<div id="allSocial">
           
</div> 
 
<div id="editSocial">
           
</div>

 
<script type="text/javascript">

$(document).ready(function(){
  allSocial();
});
 function createSocial(leadId){
      var url ="{{ route('leadSocial.create',['/']) }}/"+leadId;
      $.get(url,function(data){
         $("#createSocial").html(data);
      });
 }
 

 function allSocial(){
    var leadId = "{{ $leadId }}";
    var url ="{{ route('leadSocial.all',['/']) }}/"+leadId;
      $.get(url,function(data){
         $("#allSocial").html(data);
      });
 }

 
 function store1(){
      hideErrors();
     $.ajax({
       url : "{{ route('leadSocial.store') }}",
       method : "POST",
       data : $("#createFormSocial").serialize(),
       success:function(data){
          if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>');
                        $(document).find('[name='+field_name+']').addClass('input-error');

              var offset = $("#createSocial").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
            });  
          }else{
              notify('Saved','success');
              allSocial();
            $("#createSocial").html("");
          }
       },
     });
 }
 
 function editSocial(typeId){
      var url ="{{ route('leadSocial.edit',['/']) }}/"+typeId;
      $.get(url,function(data){
         $("#editSocial").html(data);
      });
 }

 
 function update(){
      hideErrors();
     $.ajax({
       url : "{{ route('leadSocial.update') }}",
       method : "POST",
       data : $("#editForm").serialize(),
       success:function(data){
          if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>');
                        $(document).find('[name='+field_name+']').addClass('input-error');

              var offset = $("#createSocial").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
            });  
          }else{
              notify('Updated','success');
              allSocial();
            $("#editSocial").html("");
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