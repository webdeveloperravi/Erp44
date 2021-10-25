@extends('layouts.admin.app')
@section('content')
<div class="container">
      
        <div class="alert alert-success alert-dismissible success_msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="sucs"></h4>
       </div>

   <div class="add_unit " style="display: none">
    
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Unit</h5>
        </div> 
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res">
                  
                 </ul>
     </div>

      <form id="unit_form">
        @csrf
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
        </div>	
      </div>
        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="alias" type="text" class="form-control" name="alias"  autocomplete="name" autofocus>
        </div>  
      </div>

       <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sh_desc"></span>
                        
                    </div>
      </div>

         {{-- <div class="form-group row">
        <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">UQC (GST + EReturn) <span class="alert-danger"></span> </label>
          <div class="col col-sm-4 col-md-6">
        <input id="uqc" type="text" class="form-control" name="uqc"  autocomplete="name" autofocus>
        </div>  
                   
                    
      </div> --}}
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="addUnit()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>


<!---Edit Unit -->


   <div class="edit_unit " style="display: none">
    
    <div class="card">
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Unit</h5>
        </div>  
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res">
                  
                 </ul>
     </div>

      <form id="edit_unit_form">
        @csrf
        <input type="hidden" name="id" id="id">
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
        </div>  
      </div>
        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_alias" type="text" class="form-control" name="alias"  autocomplete="name" autofocus>
        </div>  
      </div>

       <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="edit_desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sh_desc"></span>
                        
                    </div>
      </div>

        {{-- <div class="form-group row">
        <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">UQC (GST + EReturn) <span class="alert-danger"></span> </label>
          <div class="col col-sm-4 col-md-6">
        <input id="edit_uqc" type="text" class="form-control" name="uqc"  autocomplete="name" autofocus>
        </div>  
                   
                    
      </div> --}}
   
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="updateUnit()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>

<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Unit</button>
   </div>
</div> 
<div class="card">
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Units</h5>
</div> 
<!---Edit Unit Close--->

 <div class="card-body"> 

<div class="table-responsive  unit_list">
  
 
</div>
 </div>
</div>


</div>

@section('script')
 
<script type="text/javascript">

  $(document).ready(function(){

   unitList();

   });
 

  function showStatusForm(){
      
      $(".add_unit").show();
      $(".edit_unit").hide();   
     
  }

  function closeForm(){
     
     $(".add_unit").hide();
     $(".edit_unit").hide();   
  
  }

  function  unitList(){
 
    var url="{{ route('unit.list') }}";
      $.get(url , function (data) {
         
       $(".unit_list").html(data);
       $(".tbl_unit").DataTable();
      //$('.tbl_unit_list').DataTable();
     
    });

 }

 function addUnit(){
 var url="{{route('unit.store') }}";
 var form_data=$("#unit_form").serialize();

    $.ajax({
         
         url : url,
         type : "post",
         data : form_data,
         success:function(data){
          if(data.success){ 
            $("#unit_form")[0].reset();
           unitList();
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


  function editUnit(id,name,alias,desc,uqc)
  {
      
      $(".edit_unit").show();   
      $(".add_unit").hide();

      var id=$("#id").val(id);
     var name=$("#edit_name").val(name);
     var alias=$("#edit_alias").val(alias);
     var desc=$("#edit_desc").val(desc);
     var uqc=$("#edit_uqc").val(uqc);
      $("#edit_name").focus();
 }

  function updateUnit(){

 var url="{{route('unit.update') }}";
 var form_data=$("#edit_unit_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
           
          if(data.success){ 
            $(".edit_unit").hide();
           unitList();
            notify('Successfully Updated', 'success'); 
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


  function changeStatus(id,status)
  {  
     var url="unit-status/"+id+"/"+status;
     $.get(url,function(data){
        
         $(".success_msg").show();
           $(".sucs").html(data["success"]);
           $(function(){
           $(".success_msg").delay(3000).fadeOut();
                
              });

         unitList();
     

   

     });

  }

</script>

@endsection

@endsection
