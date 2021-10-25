@extends('layouts.admin.app') 
@section('content')
<div class="container">
      
        <div class="alert alert-success alert-dismissible success_msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="sucs"></h4>
       </div>

   <div class="add_address_type " style="display: none">
    
    <div class="card">
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Address Type</h5>
        </div>  
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res">
                  
                 </ul>
     </div>

      <form id="address_type_form">
        @csrf
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
        </div>	
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="addAddressType()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>

<!-----Edit Address Type List---->

<div class="edit_address_type " style="display: none">
    
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Address Type</h5>
        </div>   
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res">
                  
                 </ul>
     </div>

      <form id="edit_address_type_form">
        @csrf
        <input type="hidden"  id="id" name="id" value="">
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
        </div>	
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="updateAddressType()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>
 

<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Address type</button>
   </div>
</div> 
 <div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Address Types</h5>
    </div> 
  <div class="card-body">
    <div class="table-responsive  type_list">
  
 
    </div>
  </div>





 </div> 









</div>

@section('script')
  
<script type="text/javascript">
	



   $(document).ready(function(){
 
   addressTypeList();

   });
 

	function showStatusForm(){
      
      $(".add_address_type").show();
       $(".edit_address_type").hide();   
     
	}

	function closeForm(){
     
     $(".add_address_type").hide();
     $(".edit_address_type").hide();   
	
	}

 function  addressTypeList(){
 
    var url="address-type-list";
      $.get(url , function (data) {
         
       $(".type_list").html(data);
         $('.tbl_address_list').DataTable();
     
       });

 }	

 function addAddressType(){

 var url="{{route('addresstype.store') }}";
 var form_data=$("#address_type_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
           
          if(data.success){ 
            $("#address_type_form")[0].reset();
            addressTypeList();
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
 }
  
  function editAddressType(id,name)
  {
      
      $(".edit_address_type").show();   
      $(".add_address_type").hide();

      var id=$("#id").val(id);
     var name=$("#edit_name").val(name);

 

  }




  function updateAddressType(){

 var url="{{route('addresstype.update') }}";
 var form_data=$("#edit_address_type_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
          if(data.success){ 
            $(".edit_address_type").hide(); 
            addressTypeList();
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
}

  function changeStatus(id,status)
  {  
     var url="address-type-status/"+id+"/"+status;
     $.get(url,function(data){
        
         $(".success_msg").show();
           $(".sucs").html(data["success"]);
           $(function(){
           $(".success_msg").delay(3000).fadeOut();
                
              });

         addressTypeList();
     

   

     });

  }

</script>


@endsection
@endsection