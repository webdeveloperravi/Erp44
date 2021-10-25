@extends('layouts.admin.app')
@section('content')


<div class="container">
  <div class="success_msg" style="display:none">
  </div>
  <div id="editConfig"></div>
  <div class="add_profile_permission" style="display: none">
     <div class="card">
        <!--Header ---->
        <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
         <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Role</h5>
         </div> 
        <div class="card-body">
           <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <ul id="res">
              </ul>
           </div>
           <form id="profile_permission_form">
              @csrf
              <div class="form-group row">
                 <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
                 <div class="col col-sm-4 col-md-6">
                    <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
                 </div>
              </div>
              <div class="form-group row">
                 <label for="desc" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                 <div class="col-md-6">
                    <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                 </div>
              </div>
              <div class="form-group row">
                 <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
                 <div class="col col-sm-4 col-md-4">
                    <button  type="button" class="btn btn-success" onclick="addOrgRole()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
                 </div>
              </div>
           </form>
        </div>
     </div>
  </div>
  <!---Edit Profile Permission ---->
  <div class="edit_profile_permission" style="display: none">
     <div class="card">
        <!--Header ---->
        <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
         <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Role</h5>
         </div> 
        <div class="card-body">
           <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <ul id="edit_res">
              </ul>
           </div>
           <form id="edit_profile_permission_form">
              @csrf
              <input type="hidden" name="id" id="id">
              <div class="form-group row">
                 <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
                 <div class="col col-sm-4 col-md-6">
                    <input id="edit_name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
                 </div>
              </div>
              <div class="form-group row">
                 <label for="desc" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                 <div class="col-md-6">
                    <textarea id="edit_desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                 </div>
              </div>
              <div class="form-group row">
                 <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
                 <div class="col col-sm-4 col-md-4">
                    <button  type="button" class="btn btn-success" onclick="updateOrgRole()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
                 </div>
              </div>
           </form>
        </div>
     </div>
  </div>

  <div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Role</button>
    </div>
</div>
</div>
<div class="table-responsive  profile_permission_list">
</div>

<div id="editModules"></div>
@section('script')
 
<script type="text/javascript">

  $(document).ready(function(){

   orgRoleList();

   });
 

  function showStatusForm(){
      
      $(".add_profile_permission").show();
      $(".edit_profile_permission").hide();   
     
  }

  function closeForm(){
     
     $(".add_profile_permission").hide();
     $(".edit_profile_permission").hide();   
  
  }

  function  orgRoleList(){
 
    var url="{{ route('org-role-list') }}";
      $.get(url , function (data) {
         
       $(".profile_permission_list").html(data);
       $(".tbl_profile_permission").DataTable();
     
    });

 }

 function addOrgRole()
 {

  var url="{{route('org-role-store') }}";
   var form_data=$("#profile_permission_form").serialize();

    $.ajax({
         
         url : url,
         type : "post",
         data : form_data,
         success:function(data){

            if(data.success){ 
            $("#profile_permission_form")[0].reset();
            orgRoleList();
            notify('Successfully Saved', 'success'); 
            }
            if(data.errors){
               $.each(data.errors,function(field_name,error){
                           $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
               }); 
               setTimeout(hideErrors,5000); 
            } 
     },
    })

 }

  function editProfilePermission(id,name,desc)
  {
      
      $(".edit_profile_permission").show();   
      $(".add_profile_permission").hide();

      var id=$("#id").val(id);
     var name=$("#edit_name").val(name);
     var desc=$("#edit_desc").val(desc);
        $("edit_name").focus();
        var offset = $(".edit_profile_permission").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
 

  }




  function updateOrgRole(){

 var url="{{route('org-role-update') }}";
 var form_data=$("#edit_profile_permission_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
           
            if(data.success){ 
            $(".edit_profile_permission").hide();
            orgRoleList();
            notify('Successfully Updated', 'success'); 
            }
            if(data.errors){
               $.each(data.errors,function(field_name,error){
                           $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
               }); 
               setTimeout(hideErrors,5000); 
            } 
      }
    })
}

function updateConfig(){
       var url ="{{ route('org.role.config.update') }}";
       var formData = $("#editConfigForm").serialize();
       $.ajax({
          url : url,
          type:"POST",
          data:formData,
          success:function(data){
             orgRoleList();
              $("#editConfig").html("");
          } 
       });
    }

  function changeStatus(id,status)
  {  
     var url="org-role-status/"+id+"/"+status;
     $.get(url,function(data){
        
      notify('Status Changed Successfully', 'success'); 

         orgRoleList();
     

   

     });

  }

  function editConfig(id){
     
    var url ="{{ route('org.role.config.edit',['/']) }}/"+id;
    $.get(url,function(data){
      $("#editConfig").html(data);
      // location.href = "#editConfig"
    });
  }

  function editModules(roleId){
     var url ="{{ route('org.role.module.edit',['/']) }}/"+roleId;
     $.get(url,function(data){
         $("#editModules").html(data);
         var offset = $("#editModules").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

     });
  }
 

</script>
@endsection
@endsection

