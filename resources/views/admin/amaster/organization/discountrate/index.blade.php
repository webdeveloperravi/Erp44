@extends('layouts.admin.app')
@section('content')
<div class="container">
      
        <div class="success_msg" style="display:none">
                 
       </div>

   <div class="add_discount_rate " style="display: none">
    
    <div class="card">
    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Discount Rate</h5>
      </div> 
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res">
                  
                 </ul>
     </div>

      <form id="discount_rate_form">
        @csrf
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-5">
        <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus placeholder="Enter the Name">
        </div>	
      </div>

       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Rate<span class="alert-danger">*</span></label>
       <div class="col col-sm-1 col-md-5">
        <input id="rate" type="text" class="form-control only_num" name="rate"  autocomplete="name" autofocus placeholder="enter the Rate">
        </div>  
         <div class="col col-sm-1 col-md-1">
         <span class="font-weight-bold">%</span>
        </div>  
        
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
         <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="addDiscountRate()">Submit</button> <input type="button" name="cancel"class="btn btn-warning m-l-10" onclick="closeForm()" value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>


<!----Edit Discount Rate ------>


 <div class="edit_discount_rate " style="display: none">
    
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Discount Rate</h5>
        </div>   
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res">
                  
                 </ul>
     </div>

      <form id="edit_discount_rate_form">
        @csrf
        <input type="hidden" name="id" id="id">
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_name" type="text" class="form-control" name="edit_name"  autocomplete="name" autofocus>
        </div>  
      </div>

       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Rate<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_rate" type="text" class="form-control only_num" name="edit_rate"  autocomplete="name" autofocus>
        </div>  
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="updateDiscountRate()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>



<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Discount Rate</button>
   </div>
</div> 
<div class="card">
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Discount Rates</h5>
</div> 
<div class="card-body">
  <div class="table-responsive  rate_list">
  
 
  </div>
</div>
</div>
<!---Edit Discount Rate Close------>
 





</div>

@section('script')
 
<script type="text/javascript">

  $(document).ready(function(){

   discountRateList();

   });
 

  function showStatusForm(){
      
      $(".add_discount_rate").show();
      $(".edit_discount_rate").hide();   
     
  }

  function closeForm(){
     
     $(".add_discount_rate").hide();
     $(".edit_discount_rate").hide();   
  
  }

  function  discountRateList(){
 
    var url="discount-rate-list";
      $.get(url , function (data) {
         
       $(".rate_list").html(data);
        $('.tbl_discount_list').DataTable();
     
    });

 }

 function addDiscountRate(){
 var url="{{route('discountrate.store') }}";
 var form_data=$("#discount_rate_form").serialize();

    $.ajax({
         
         url : url,
         type : "post",
         data : form_data,
         success:function(data){

          if(data.success){ 
            $("#discount_rate_form")[0].reset(); 
            discountRateList();
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

  function editDiscountRate(id,name,rate)
  {
      
      $(".edit_discount_rate").show();   
      $(".add_discount_rate").hide();
        $("#edit_name").focus();
      var id=$("#id").val(id);
     var name=$("#edit_name").val(name);
     var rate=$("#edit_rate").val(rate);

 

  }




  function updateDiscountRate(){

 var url="{{route('discountrate.update') }}";
 var form_data=$("#edit_discount_rate_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){
           
          if(data.success){ 
            $(".edit_discount_rate").hide();  
            discountRateList();
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
     var url="discount-rate-status/"+id+"/"+status;
     $.get(url,function(data){
        
         $(".success_msg").show();
           $(".success_msg").html(data["success"]);
           $(function(){
           $(".success_msg").delay(3000).fadeOut();
                
              });

         discountRateList();
     

   

     });

  }



$(function () {
    $(".only_num").on("keypress", function (evt) {
        var $txtBox = $(this);
        var charCode = (evt.which) ? evt.which : evt.keyCode
          ("#msg").append(charCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        else {
            var len = $txtBox.val().length;
            var index = $txtBox.val().indexOf('.');
            //alert(index);
            if (index > 0 && charCode == 46) {
              return false;
            }
            if (index > 0) {
                var charAfterdot = (len + 1) - index;
                if (charAfterdot > 3) {
                    return false;
                }
            }
        }
        return $txtBox; //for chaining
    });
})
 

</script>
 

@endsection
@endsection
