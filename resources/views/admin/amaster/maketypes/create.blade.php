@extends('layouts.admin.app')
@section('content')
<div class="container">
 @section('css')   
<style type="text/css">
  .add_make_type{display: none;}
  .edit_make_type_div{display: none;}

</style>
@endsection
<!--Message for success-->
<div class="success_msg">

</div>
<div id="error_msg">
</div>

<!---make type add div tag start-->
<div class="add_make_type">
<div class="card">
<!--Header ---->
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Make Type</h5>
  </div>  

<div class="card-body">


<form id="make_type_form">
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
<button  type="submit" class="btn btn-success" id="btn-add_make_type">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
</div>  
</div>
</form>
</div>
</div>
</div>

<!---------Edit Make Type ----->
<div class="edit_make_type_div" >
<div class="card">
<!--Header ---->
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Make Type</h5>
  </div> 
  

<div class="card-body">


<form id="edit_make_type_form">
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

</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="submit" class="btn btn-success" id="btn-edit_make_type">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
</div>  
</div>
</form>
</div>
</div>
</div>



<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showForm()">Create Make Type</button>
   </div>
</div> 
<div class="card"> 
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Make Types</h5>
</div> 
 
<div class="card-body">
  <div class="table-responsive make_type_list">
    
   
  </div>

</div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){

   makeTypeList(); 

})

function makeTypeList(){

var url = "{{route('make.type.list')}}";
$.get(url,function(data){

$(".make_type_list").html(data);
$(".tbl_make_type_list").DataTable();
});

}

 function showForm(){

    $(".add_make_type").show();
    $("#name").focus();
  }

  function closeForm(){
    $(".add_make_type").hide();
    $(".edit_make_type_div").hide();
  }

  $("#btn-add_make_type").on('click',function(event){
 
    event.preventDefault();
    var url = "{{route('make.type.store')}}";
    var form_data  = $("#make_type_form").serialize();
    $.ajax({
       
        url : url,
        type : "POST",
        data : form_data, 
     success : function(data){
      if(data.success){ 
        $("#make_type_form")[0].reset();
       makeTypeList();
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
 
 
  function changeStatus(id,status){
   

   var url = "{{route('make.type.status',['/','/'])}}/"+id+"/"+status;
   
   $.get(url,function(data){
  
    $(".success_msg").html(data['success']);
      makeTypeList(); 
   
    $(function(){
            $(".success_msg").delay(5000).fadeOut();
            });
  
  
   });
  }


  function editMakeType(id,name,alias,description){
   
      $(".edit_make_type_div").show();
      $("#edit_name").focus();
      $(".add_make_type").hide();
      $("#id").val(id);
      $("#edit_name").val(name);
      $("#edit_alias").val(alias);
      $("#edit_description").val(description);
  }


  $("#btn-edit_make_type").on('click',function(event){
 
    event.preventDefault();
    var url = "{{route('make.type.update')}}";
    var form_data  = $("#edit_make_type_form").serialize();
    
    $.ajax({
       
        url : url,
        type : "POST",
        data : form_data, 
     success : function(data){
       if(data.success){
        $("#make_type_form")[0].reset();
          makeTypeList();
          closeForm();
          notify('Successfully Updated', 'success'); 
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