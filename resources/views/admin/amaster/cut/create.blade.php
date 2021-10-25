@extends('layouts.admin.app')
@section('content')
<div class="container">
@section('css')    
<style type="text/css">
  .add_cut{display: none;}
  .edit_cut{display: none;}
</style>
@endsection
<!--Message for success-->
<div class="success_msg">

</div>
<div id="error_msg">
</div>

<!---make type add div tag start-->
<div class="add_cut">
<div class="card">
<!--Header ---->
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Cut</h5>
  </div>   

<div class="card-body">
<form id="add_cut_form">
@csrf
<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input id="name" type="text" class="form-control" name="name" autofocus>
</div>	
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alise<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input id="alias" type="text" class="form-control" name="alias" autofocus>
</div>  
</div>
<div class="form-group row">
<label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
<div class="col-md-6">
<textarea id="description" name="description" class="form-control" cols="20" rows="5"></textarea> 
<span id="msg_origin_desc"></span>
</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="submit" class="btn btn-success" id="btn-add_cut">Submit</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()" value="Close">  
</div>  
</div>
</form>
</div>
</div>
</div>

<!----Edit Cut ----------Form---->
<div class="edit_cut">
<div class="card">
<!--Header ---->
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Cut</h5>
  </div> 

<div class="card-body">
<div class="alert alert-danger alert-dismissible" id="edit_error_msg">

</div>

<form id="edit_cut_form">
@csrf
<input type="hidden" name="id" id="id">
<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input id="edit_name" type="text" class="form-control" name="name" autofocus>
</div>	
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alise<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input id="edit_alias" type="text" class="form-control" name="alias" autofocus>
</div>  
</div>
<div class="form-group row">
<label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
<div class="col-md-6">
<textarea id="edit_description" name="description" class="form-control" cols="20" rows="5"></textarea> 
<span id="msg_origin_desc"></span>
</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="submit" class="btn btn-success" id="btn-edit_cut">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Close">  
</div>  
</div>
</form>
</div>
</div>
</div>

<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showForm()">Create Cut</button>
   </div>
</div> 
<div class="card">
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Cuts</h5>
</div> 

 
<div class="card-body">

<div class="table-responsive cut_list">
  
 
</div>
</div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){

   cutList(); 

})

function cutList(){

var url = "{{route('cut.list')}}";
$.get(url,function(data){

$(".cut_list").html(data);
$(".tbl_cut_list").DataTable();
});

}
 
 function showForm(){
    $(".add_cut").show();
    $(".edit_cut").hide();
    $("#name").focus();
  }

  function closeForm(){
    $(".add_cut").hide();
    $(".edit_cut").hide();
  }

 $("#btn-add_cut").on('click',function(event){
      event.preventDefault();
    var url = "{{route('cut.store')}}";
    var form_data  = $("#add_cut_form").serialize();
$.ajax({
       
        url : url,
        type : "POST",
        data : form_data, 
     success : function(data){
      
      if(data.success){ 
        $("#add_cut_form")[0].reset(); 
       cutList(); 
            notify('Successfully Saved', 'success'); 
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
   },  

});
 
}); 

 
 




  function editCut(id,name,alias,description){
   
      $(".edit_cut").show();
      $("#edit_name").focus();
      $(".add_cut").hide();
      $("#id").val(id);
      $("#edit_name").val(name);
      $("#edit_alias").val(alias);
      $("#edit_description").val(description);
  }

   function changeStatus(id,status){
   

   var url = "{{route('cut.status',['/','/'])}}/"+id+"/"+status;
   
   $.get(url,function(data){
    $(".success_msg").show();
    $(".success_msg").html(data['success']);
      cutList(); 
   
    $(function(){
            $(".success_msg").delay(5000).fadeOut();
            });
       });
  }

  $("#btn-edit_cut").on('click',function(event){
 
    event.preventDefault();
    var url = "{{route('cut.update')}}";
    var form_data  = $("#edit_cut_form").serialize();
    
    $.ajax({
       
        url : url,
        type : "POST",
        data : form_data, 
     success : function(data){
       if(data.success){
      closeForm();
       cutList(); 
            notify('Successfully Saved', 'success'); 
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
   },  

});

});    





</script>

@endsection