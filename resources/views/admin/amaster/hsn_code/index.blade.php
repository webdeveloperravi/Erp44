@extends('layouts.admin.app')
@section('content')
<div class="container">
      
      <div class="success_msg" style="display:none">
                 
      </div>

   <div class="add_hsn_code" style="display:none">
      <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create HSN Code</h5>
        </div>   
  
    <div class="card-body">
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res"></ul>
     </div>

      <form id="hsn_code_form">
        @csrf
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">HSN-CODE<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="name" type="text" class="form-control only-numeric" name="hsn_code" autofocus>
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
         <button  type="submit" class="btn btn-success" id="btn-addhsncode">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()" value="Close">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>

<!-----Edit HSN Code List---->
<div class="edit_hsn_code_div" style="display:none">
      
  <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit HSN Code</h5>
        </div> 
    <div class="card-body">
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res"></ul>
     </div>
    
    <form id="edit_hsn_code_form">
        @csrf
        <input type="hidden" name="hsn_code_id" id="hsn_code_id">

     {{--  <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Rate <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="tax_rate"  name="tax_rate" class="form-control  @error('tax_type') is-invalid @enderror">
                      <option >Select Tax Rate</option>
            @foreach($tax_rate->sortBy('name') as $tr_key => $tr_val )
                                 <option value="{{$tr_val['id']}}" {{$tr_val->id==$hsn_code_data->tax_rate_id ? 'selected' : '' }}>
                    {{$tr_val['rate']}}% 
              </option> 
            @endforeach
        </select>
        </div>  
      </div> --}}

      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">HSN-CODE<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_hsn_code" type="text" class="form-control only-numeric" name="hsn_code" autocomplete="name" autofocus >
        </div>  
      </div>

       <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="edit_desc" name="description" class="form-control" cols="20" rows="5"></textarea> 
                        <span id="msg_origin_desc"></span>
                    </div>
        </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="submit" class="btn btn-success" id="btn-updatehsncode">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()" value="Close">  
        </div>  
      </div>
    </form>
   </div>
  
</div>




</div>
 

<!----Edit HSN Code List Close---->
 
<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showForm()">Create HSN Code</button>
   </div>
</div> 


 <div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">HSN Codes</h5>
    </div> 


<div class="card-body">


<div class="table-responsive hsn_code_list">
  
 
</div>
</div>
</div>
</div>

@section('script')

<script type="text/javascript">

  hsn_code_list();

  function hsn_code_list()
    {

          $.ajax({
      
           url : "{{route('hsn.code.view') }}",
           type : "get",
           success : function(data)
           {
            $(".hsn_code_list").html(data);
            $('.tbl_hsn_code').DataTable();
        
           }

 
      });
     

}

  function closeForm(){
  
  $(".add_hsn_code").hide();
  $(".edit_hsn_code_div").hide();
 
  }
  
  function showForm(){
   $(".add_hsn_code").show(); 
 }


  $("#btn-addhsncode").click(function(event){
       
      event.preventDefault();   
      var url='{{route('hsn.code.store')}}';
  var form_data=$("#hsn_code_form").serialize(); 
  $.ajax({

         url : url,
         type : "POST",
         data : form_data,
         success : function(data)
         {
                
 
            if(data.success){ 
              $("#hsn_code_form")[0].reset();
            hsn_code_list();
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

    function edit_hsn_code(id,hsncode,desc)
    {
        $(".add_hsn_code").hide();
        $(".edit_hsn_code_div").show();
        $("#edit_hsn_code").focus();
        $("#hsn_code_id").val(id);
        $("#edit_hsn_code").val(hsncode);
        $("#edit_desc").val(desc);


    }

   function changeStatus(id,status)
  {  
     var url="hsn-code-status/"+id+"/"+status;
     $.get(url,function(data){
        
         $(".success_msg").show();
           $(".success_msg").html(data["success"]);
           $(function(){
           $(".success_msg").delay(3000).fadeOut();
                
              });

         hsn_code_list();
     

   

     });

  }   
// edit hsn_code
  
$("#btn-updatehsncode").click(function(event){
       
      event.preventDefault();   
      var url='{{route('hsn.code.update')}}';
  var form_data=$("#edit_hsn_code_form").serialize(); 
  $.ajax({

         url : url,
         type : "POST",
         data : form_data,
         success : function(data)
         {
          if(data.success){ 
            $(".edit_hsn_code_div").hide();
            hsn_code_list(); 
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

       $(".only-numeric").bind("keypress", function (e) {
          var keyCode = e.which ? e.which : e.keyCode
             var leng=$(this).val().length;

          if (!(keyCode >= 48 && keyCode <= 57)) {
             $(".error").css("display", "inline");
            return false;
          }
              if(leng>8)
              {
                return false;
              }
          else{
            $(".error").css("display", "none");
          }
        });



     


 








</script>

@endsection
@endsection