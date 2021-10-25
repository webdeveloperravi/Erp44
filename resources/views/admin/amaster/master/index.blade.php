@extends('layouts.admin.app')
@section('content')
<div class="container">
  <!-------Master  Save record Message------->
<div class="success_msg" style="display:none"></div>


<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="show_Form('add_master')">Create Master</button>
   </div>
</div> 
 
<!---------Master Form Start------------>
<div class="add_master" style="display:none">
<div class="card">
      <!--Header ---->
 
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Warehouse Roles</h5>
</div> 

<div class="card-body"><!----------Card Master Body----------->
<div class="alert alert-danger alert-dismissible" style="display:none" id="error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="res"></ul>
</div>
<form id="add_master_form">
@csrf
<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input  type="text" class="form-control name" name="name" autofocus id="name">
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
<button  type="submit" class="btn btn-success" id="btn_add_master">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="close_form('add_master')" value="Close">  
</div>  
</div>
</form>
</div><!--------Card Master Body Close-------->
  
</div>
</div><!------Add Master DIV Close--->

<!------Master Edit Form---->
<div class="edit_master" style="display:none">
<div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Master</h5>
        </div> 
        

<div class="card-body"><!----------Card Master Body----------->
<div class="alert alert-danger alert-dismissible" style="display:none" id="edit_error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="edit_res"></ul>
</div>
<form id="edit_master_form">

@csrf
<input type="hidden" name="id" value="" id="id">
<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input  type="text" class="form-control name" name="name" autofocus id="edit_name">
</div>	
</div>

<div class="form-group row">
<label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
<div class="col-md-6">
<textarea id="edit_description" name="description" class="form-control" cols="20" rows="5" value="dd"></textarea> 
<span id="msg_origin_desc"></span>
</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="submit" class="btn btn-success" id="btn_edit_master">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="close_form('edit_master')" value="Cancel">  
</div>  
</div>
</form>
</div><!--------Card Master Body Close-------->
  
</div>
</div><!------Add Master DIV Close--->

<!--------Master Edit Form Close----->

<div class="card">
  <div class="card-footer p-0 mb" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Masters</h5>
    </div> 
    
  <div class="card- master_list">
    
   

  </div>
</div>

</div><!--------Container Close------>


@section('script')
<script type="text/javascript">
master_list();

function master_list()
{
$.ajax({
url : "{{route('master.list.view') }}",
type : "get",
success : function(data)
{
$(".master_list").html(data);
$('.tbl_master_list').DataTable();
}
});
}

// add master record

$("#btn_add_master").click(function(event){
event.preventDefault();   
var url='{{route('master.store')}}';
var form_data=$("#add_master_form").serialize(); 
$.ajax({

url : url,
type : "POST",
data : form_data,
success : function(data)
{

  if(data.success){ 
            notify('Successfully Saved', 'success'); 
            master_list();
          $("#add_master_form")[0].reset();  
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

// edit master record

$("#btn_edit_master").click(function(event){
event.preventDefault();   
var url='{{route('master.update')}}';
var form_data=$("#edit_master_form").serialize(); 
$.ajax({

url : url,
type : "POST",
data : form_data,
success : function(data)
{
	 
  if(data.success){ 
            notify('Successfully Updated', 'success'); 
            close_form('edit_master');
	master_list();
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

// change status

   function changeStatus(id,status)
  {  
     var url="master-status/"+id+"/"+status;
     $.get(url,function(data){
        
          notify('Status Updated','success');

         master_list();
     

   

     });

  }

</script>
@endsection
@endsection