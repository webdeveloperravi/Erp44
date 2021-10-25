@extends('layouts.admin.app')
@section('content')
<div class="container">
<div id="modal_org_role_config"></div>
<div class="success_msg" style="display:none"></div>
<div class="add_config " style="display: none">
<div class="card">
<!--Header ---->

<div class="row">
<div class="col-xs-6 col-sm-9 col-md-9 "> 
<div class="card-header text-secondary text-uppercase"> Organization Role Configuration </div>
</div>
</div>   

<div class="card-body">

<div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="res"></ul>
</div>
<form id="org_role_config_form">
@csrf

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Org Role Name <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6" id="div_org_role_name">
@if(!empty($assign_org_role_name))
<select   id="org_role_name"  name="role_name" class="form-control  @error('tax_type') is-invalid @enderror">
<option >Select Role Name </option>
@foreach($org_role as $role_key => $org_val )

@if(in_array($org_val->id, $assign_org_role_name->toArray()))
@else
<option value="{{$org_val->id}}" title="{{$org_val->description}}">
{{$org_val->name}} 
@endif
@endforeach
</select>
@else
<select   id="org_role_name"  name="role_name" class="form-control  @error('tax_type') is-invalid @enderror">
<option >Select Role Name </option>
@foreach($org_role as $role_key => $org_val )


<option value="{{$org_val->id}}" title="{{$org_val->description}}">
{{$org_val->name}} 

@endforeach
</select>
@endif
</div>  
</div>

<div class="form-group row" id="retail_model">
 <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Retail Model<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div>
<select   id="retail_model"  name="retail_model" class="form-control  @error('tax_type') is-invalid @enderror">
<option disabled="" >Select Retail Model </option>
@foreach($retail_models as $model)
<option value="{{$model->id}}" class="text-dark font-weight-bold">
{{$model->name}} 
</option> 
@includeWhen($model->subRetailModels->count() > 0,'admin.amaster.organization.org_role_config.retail_model_options',['retailModels'=>$model] )

@endforeach
</select>
</div>
</div> 
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Type <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div id="org_tax_type">
<select   id="tax_rate_id"  name="tax_type" class="form-control  @error('tax_type') is-invalid @enderror">
<option>Select Tax Type </option>
@foreach($org_tax_type as  $tt_key => $tt_val )
<option value="{{$tt_val->id}}">
{{$tt_val->name}}
</option> 
@endforeach
</select>
</div>
</div>  
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Unit <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div id="org_unit">
<select   id="unit_conversion_id"  name="unit" class="form-control  @error('tax_type') is-invalid @enderror">
<option>Select Unit </option>
@foreach($org_unit as $unit_key => $unit_val )
<option value="{{$unit_val['id']}}" title="{{$unit_val->description}}">
{{$unit_val->name}} 
</option> 
@endforeach
</select>
</div>
</div>  
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="button" class="btn btn-success" onclick="addOrgRoleConfig()">Submit</button> <input type="button" name="cancel"class="btn btn-warning m-l-10" onclick="closeForm()" value="Cancel">  
</div>  
</div>
</form>
</div>
</div>
</div>

<!---------Edit Record Div---------->
<div class="edit_role_config" style="display: none">

</div>


<div class="row m-b-10">
<div class="col-xs-8 col-sm-10 col-md-10 col-lg-10"><h5 class="text-info">Organization Role Config List</h5></div>
<div class="col-xs-4 col-sm-2 col-md-2 col-g-2 float-md-right" onclick="showConfigForm()"><button class="btn  btn-success">ADD Org Role Config</button></div>
</div>

<div class="dis" id="assign_dis">

</div>


<!-----------View All Record --------------->

<div class="table-responsive  org_role_config">


</div>

</div>


</div>
@section('script')

<script type="text/javascript">

$(document).ready(function(){

orgRoleConfigList();
})

function showConfigForm(){
$(".add_config").show();
$(".edit_role_config").hide();   
}

function closeForm(){
$(".add_config").hide();
$(".edit_role_config").hide();   

}
function  orgRoleConfigList(){

var url="{{ route('org.role.config.list') }}";
$.get(url , function (data) {

$(".org_role_config").html(data);
$('.tbl_org_role_config').DataTable();

});

}

function addOrgRoleConfig(){

var url="{{route('org.role.config.store') }}";
var form_data=$("#org_role_config_form").serialize();

$.ajax({

url : url,
type : "Post",
data : form_data,
success:function(data){

$("#org_role_config_form")[0].reset();
$(".success_msg").show();
$(".success_msg").html(data["success"]);
$(function(){
$(".success_msg").delay(3000).fadeOut();
});

orgRoleConfigList();
updateRoleName();

},

error : function(error)
{

var messages=error.responseJSON["message"];

alert("errors");
$("#error_msg").show();
$("#res").empty();
for (var i =0; i<messages.length; i++) {
$("#res").append("<ul><li>"+messages[i]+"</li></ul>");
}
$(function(){
$("#error_msg").delay(10000).fadeOut();
});



}


})
}


function editOrgRoleConfing(id) {

var org_role_config_id=id;
var url ="org-role-config-edit/"+org_role_config_id;
$.ajax({

url  : url,
type : "GET",
success : function(data){

$("#modal_org_role_config").html(data);
}


});

}

function OrgRoleConfigUpdate(){

var url="{{route('org.role.config.update') }}";
var form_data=$("#edit_org_role_config_form").serialize();

$.ajax({

url : url,
type : "Post",
data : form_data,
success:function(data){

// $("#address_type_form")[0].reset();
$(".edit_role_config").hide();
$(".success_msg").show();
$(".success_msg").html(data["success"]);
$(function(){
$(".success_msg").delay(3000).fadeOut();

});

orgRoleConfigList();
$("#modal_org_role_config").empty();

},

error : function(error)
{

var messages=error.responseJSON["message"];

alert("errors");
$("#edit_error_msg").show();
$("#edit_res").empty();
for (var i =0; i<messages.length; i++) {
$("#edit_res").append("<ul><li>"+messages[i]+"</li></ul>");
}
$(function(){
$("#edit_error_msg").delay(10000).fadeOut();
});



}


})


}

function updateRoleName(){

var url="{{route('org-role-name-update-show')}}";
$.get(url,function(data){
$("#div_org_role_name").html(data);

});

}



function closeModal(){
$("#modal_org_role_config").empty();
}





</script>

@endsection
@endsection	