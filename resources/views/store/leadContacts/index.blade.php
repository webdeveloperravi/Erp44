 @php
   $lead =  App\Model\Store\Lead::find($leadId);
 @endphp
<div class="row"> 
   <div class="col">
    @if($lead->converted_to_store == 0)
    @can('store-create', 'lead.index')
 

    <button class="btn btn-dark float-right mb-3" style="display: inline" onclick="create()">Add Contact</button>
    @endcan  

 @endif
 </div>
</div>
  
  
<div id="create">

</div>
 
@can('store-update','lead.index')
<div id="edit">
  
</div>
@endcan  
@can('store-read','lead.index')
<div id="all">
  
</div>
@endcan  



 
<script type="text/javascript">

$(document).ready(function(){
  all();
});
 function create(){
      var url ="{{ route('leadContact.create',['/'])}}/"+"{{$leadId}}";
      $.get(url,function(data){
         $("#create").html(data);
      });
 }

 function all(){
    var url ="{{ route('leadContact.all',['/']) }}/"+"{{$leadId}}";
      $.get(url,function(data){
         $("#all").html(data);
      });
 }


 function save(){
     $.ajax({
       url : "{{ route('leadContact.save') }}",
       method : "POST",
       data : $("#createForm").serialize(),
       success:function(data){
          if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                        $(document).find('[name='+field_name+']').addClass('input-error')
            }); 
            setTimeout(hideErrors,5000); 
          }else{
             notify('Lead Contact Saved','success');
            all();
            $("#create").html("");
          }
       },
     });
 }

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error');
   $("select").removeClass('input-error');
 }

 
 function edit(id){

   var url = "{{route('leadContact.edit',['/'])}}/"+id;
   // alert(url);
   // return false;
   $.get(url, function(data){

   $("#create").html(data);

   });


 }

function update(){
 
 $.ajax({
       method : "POST",
       url : "{{ route('leadContact.update') }}",
       data : $("#updateForm").serialize(),
       success:function(data){
          if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                        $(document).find('[name='+field_name+']').addClass('input-error')
            }); 
            setTimeout(hideErrors,8000); 
          }else{
             notify('Lead Contact  Updated','success');
            all();
            $("#create").html("");
          }
       },
     });

}

</script> 