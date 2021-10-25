@extends('layouts.admin.app')
@section('content')
<div class="container">
<div class="success_msg">

 </div>
 <div id="edit">

</div>
<div id="viewiewTwo">
</div>
<div class="add_retail_model">
  
</div>
 
<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showRetailModel()">Create Retail Model</button>
   </div>
</div> 
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Retail Models</h5>
</div> 
 

 <!--Retail Model List----->
<div class="view table-responsive">

</div>


  
<!----Role List Close--->
</div>
@section('script')
<script type = "text/javascript" >
  $(document).ready(function(){
   retailModelList();

   });

   function closeE(){
          $("#edit").html("");
      }

function showRetailModel() {

  closeE();
   var url ="{{route('retail.model.create')}}";
   $.get(url,function(data){
     $(".add_retail_model").html(data);
     });
 }
function view(id) {

  closeE();
   var url ="{{route('retail.model.view',['/'])}}/"+id;
   $.get(url,function(data){
     $("#viewiewTwo").html(data);
     });
 }

 

function closeForm(){
$(".add_retail_model").empty();

}

function retailModelList(){

var url ="{{route('retail.model.list')}}";
   $.get(url,function(data){
   $(".view").html(data);
        });  
}

function addRetailModel(){
   
   var formData = $("#formRetailModel").serialize();
   $.ajax({
  
     url    : "{{route('retail.model.store')}}", 
     method : "POST",
     data   : formData,
     success: function(data){
    
       retailModelList();
       closeForm();
        }
   });
}

function edit(id){
  closeForm();
  $("#viewiewTwo").html("");
  var url = "{{ route('retail.model.edit',['/']) }}/"+id;
  $.get(url,function(data){
     $("#edit").html(data);
  });
}

function update(){
    var form_data = $("#edit_config_role_form").serialize();
    var url = "{{ route('retail.model.update') }}";
    $.ajax({
        url: url,
        type: "Post",
        data: form_data,
        success: function(data) {
          if(data.errors){
        // $(".complete-loader").hide();
            // $(".complete-box").show(); 
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
              
  setTimeout(hideErrors,5000);
  

      }else{
           closeE();
            $(".success_msg").show();
            retailModelList();
            $(".edit_config_role").hide()
            $(".success_msg").html(data["success"]);
            $(function() {
                $(".success_msg").delay(3000).fadeOut();
            });
            fetchConfigRole();
      }

            
            
            
            
        }
    });
  } 
  function hideErrors(){ 
    $(".text-danger").remove(); 
  }

  function changeStatus(id) {
    var url = "{{route('retail.model.status.update',['/'])}}/"+id;
    $.get(url, function(data) {
         notify('Status Changed','success' );
         retailModelList();
    });
}

</script>
@endsection
@endsection
