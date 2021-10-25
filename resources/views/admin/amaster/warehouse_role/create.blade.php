@extends('layouts.admin.app')
@section('content')
<div class="container"> 
  <div class="add_config_role" style="display: none">
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Warehouse Role</h5>
      </div>
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <ul id="res">
          </ul>
        </div>
        <form id="createForm" onsubmit="event.preventDefault()">
          @csrf
          <div class="row">
            @csrf   
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="parentId">Parent Role</label>
              <select name="parent_id"  class="form-control">
                <option value="0" selected="">Select Parent Role</option>
                @foreach($parent_roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
              </select>
            </div> 
          </div>  
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Role Name</label>
              <input name="role_name" type="text" class="form-control" placeholder="Role Name"/>
            </div>
          </div> 
          <div class="col-xl-4 col-md-6 col-12 mb-1">
            <div class="form-group">
              <label for="basicInput">Alias</label>
              <input name="alias" type="text" class="form-control" placeholder="Alias"/>
            </div>
          </div> 
           
          <div class="col-xl-4 col-md-6 col-12 my-auto">
              <div class="form-group mt-lg-4"> 
                  <button class="btn btn-primary" onclick="addConfigRole()">Save</button>
                  <button class="btn btn-danger" onclick="closeForm()">Close</button>
                </div>
          </div>  
        </div> 
        </form>
      </div>
      
    </div>
  </div>
  <!----Edit Config Role--->
  <div class="edit_config_role">
  </div>
  <!---Edit Config Role Close --->
  <div class="row"> 
    <div class="col">
       <button class="btn btn-dark float-right mb-3" onclick="show()">Add Warehouse Role</button>
     </div>
 </div> 
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Warehouse Roles</h5>
  </div> 
  <!--Role List----->
  <div class="view table-responsive" >
    
  </div>
  
  <div id="editModules" class="mt-3"></div>
  <!----Role List Close--->
</div>
@section('script')
<script type = "text/javascript" >
    $(document).ready(function() {
        fetchConfigRole();
    });

function show() {
    $(".add_config_role").show();
    $("#guard").focus();
}

function closeForm() {
    $(".add_config_role").hide();
    $(".edit_config_role").hide();
}
// To show Full Record.
function fetchConfigRole() {
    $.ajax({
        url: "{{route('warehouse.role.index') }}",
        type: "get",
        success: function(data) {
            $(".view").html(data);
            $('.tbl_config_role').DataTable();
        }
    });
}
//  Add Config Role
function addConfigRole() {
    var form_data = $("#createForm").serialize();
    var url = "{{ route('warehouse.role.store') }}";
    $.ajax({
        url: url,
        type: "Post",
        data: form_data,
        success: function(data) {
          if(data.success){
            $("#createForm")[0].reset(); 
            notify('Successfully Saved', 'success');
            fetchConfigRole();
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
        },
    });
}

function editConfigRole(id) {
    var config_role_id = id;
    var url = "{{route('warehouse.role.edit',['/'])}}/" + config_role_id;
    $.get(url, function(data) {
        $(".add_config_role").hide();
        $(".edit_config_role").show();
        $(".edit_config_role").html(data);
        $('#edit_department').focus();
        var offset = $("body").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
    });
}

function updateConfigRole() {
    var form_data = $("#editForm").serialize();
    var url = "{{ route('warehouse.role.update') }}";
    $.ajax({
        url: url,
        type: "Post",
        data: form_data,
        success: function(data) {
          if(data.success){ 
            $(".edit_config_role").hide(); 
            notify('Successfully Updated', 'success');
            fetchConfigRole();
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
        },
    });
}

function changeStatus(id) {
    var url = "{{route('warehouse.role.status.update',['/'])}}/"+id;
    $.get(url, function(data) {
        $(".success_msg").show();
        $(".success_msg").html(data["success"]);
        $(function() {
            $(".success_msg").delay(3000).fadeOut();
        });
        fetchConfigRole();
    });
}

function messageDelete(id) {
    var conf = confirm("Are You Sure to Delete Record")
    if (conf == true) {
        deleteRecord(id);
        return true;
    } else {
        return false;
    }
}

function deleteRecord(id) {
    $.ajax({
        type: "GET",
        url: "config-role-delete/" + id,
        success: function(data) {
            $(".success_msg").show();
            $(".success_msg").html(data["success"]);
            $(function() {
                $(".success_msg").delay(3000).fadeOut();
            });
            fetchConfigRole();
        },
    }); // ajax bracket close
} 


function editModules(roleId){
     var url ="{{ route('warehouseRoleModule.edit',['/']) }}/"+roleId;
     $.get(url,function(data){
         $("#editModules").html(data);

         var offset = $("#editModules").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

     });
  }

  function updateModules(){
      
      $.ajax({
          url : "{{ route('warehouseRoleModule.update') }}",
        method : "POST",
        data : $("#editModulesForm").serialize(),
        success : function(data){  
             $("#editModules").html("");
             notify('Modules Updated Successfully','success');
        },
      });
  }
</script>
@endsection
@endsection