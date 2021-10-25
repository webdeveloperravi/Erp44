@extends('layouts.admin.app')
@section('content')
<div class="container">
      
        <div class="alert alert-success alert-dismissible success_msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="sucs"></h4>
       </div>

   <div class="add_unit_conversion " style="display: none">
    
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Unit Conversion</h5>
        </div> 
          
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res">
                  
                 </ul>
     </div>

      <form id="unit_conversion_form">
        @csrf
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Main Unit<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
      <select   id="main_unit"  name="main_unit" class="form-control" onchange="getSubUnit(this.value)">
                       <option value="0">Select Unit</option>
                      @foreach($unit_list as $ul_key =>$ul_val)
                        <option value="{{ $ul_val->id }}">{{ $ul_val->name }}</option>
                    @endforeach
                     
          
        </select>
        </div>	
      </div>
        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Sub Unit <span class="alert-danger">*</span></label>
         <div class="col col-sm-4 col-md-6">
       <select   id="sub_unit"  name="sub_unit" class="form-control sub_unit  @error('main_unit') is-invalid @enderror">
                     
          
        </select>
      </div>
    </div>

      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Convesion Factor <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="conversion_res" type="text" class="form-control only_numeric" name="conversion"  autocomplete="name" autofocus value="">
        </div>  
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="addConversion()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>
<!---Edit Unit Conversion----->
   <div class="edit_unit_conversion">



   </div>


  <div class="row"> 
  <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Unit Conversion</button>
    </div>
</div> 
<div class="card"> 
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Unit Conversions</h5>
</div>

<!--Edit Unit Conversion Close--->
 <div class="card-body"> 

<div class="table-responsive  unit_conversion_list">
  
 
</div>
 </div>
</div>
</div>

@section('script')

   <script type="text/javascript">

     $(document).ready(function(){

   unitConversionList();

   });

   function showStatusForm(){
      
      $(".add_unit_conversion").show();
      $(".edit_unit_conversion").hide();   
     
  }

  function closeForm(){
     
     $(".add_unit_conversion").hide();
     $(".edit_unit_conversion").hide();   
  
  }
  

   function  unitConversionList(){
 
    var url="unit-conversion-list";
      $.get(url , function (data) {
         
       $(".unit_conversion_list").html(data);
        $('.tbl_unit_conversion_list').DataTable();
     
    });

 }


     
    function getSubUnit(id)
    {
         if(id>0)
         {
         var conversion_type_id=id;  
         var url="unit-conversion-subunit/"+conversion_type_id;
         $.get(url,function(data){

            $(".sub_unit").empty();
          // $("#state").html("<option>choose State</option>");
             $.each( data['sub'], function( key, value ) {
             $(".sub_unit").append("<option value="+key+">"+value+"</option>");
            

            });

         })

       }

    }

   function addConversion() {
     
       var url="{{route('unitconversion.store') }}";
       var form_data=$("#unit_conversion_form").serialize();

       



    $.ajax({
         
         url : url,
         type : "post",
         data : form_data,
         dataType : 'json',
         success:function(data){
          if(data.success){ 
            $("#unit_conversion_form")[0].reset();
            unitConversionList();
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

 function editUnitConversion(id){
   
   var unit_conversion_id=id;
   var url ="unit-conversion-edit/"+unit_conversion_id;
 
   $.get(url,function(data){
      $(".add_unit_conversion").hide();
      $(".edit_unit_conversion").show();
      $(".edit_unit_conversion").html(data);
      $("#edit_conversion_res").focus();
  

   });



 }

 function updateUnitConversion() {
   
   var url="{{route('unitconversion.update') }}";
 var form_data=$("#edit_unit_conversion_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
           
          if(data.success){ 
            $(".edit_unit_conversion").hide();
            unitConversionList();
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
     var url="unit-conversion-status/"+id+"/"+status;
     $.get(url,function(data){
         
      notify('Status Changed Successfully ', 'success'); 
         unitConversionList();
     

   

     });

  }

  $(".only_numeric").bind("keypress", function (e) {
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
