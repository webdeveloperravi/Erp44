@extends('layouts.admin.app')
@section('content')
<div class="container">
      
        <div class="alert alert-success alert-dismissible success_msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="sucs"></h4>
        </div>

   <div class="add_tax_rate" style="display: none">
    
    <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Tax Rate</h5>
        </div>  
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res">
                  
                 </ul>
     </div>

      <form id="tax_rate_form">
        @csrf
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Type <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="tax_type_id"  name="tax_type" class="form-control  @error('tax_type') is-invalid @enderror">
                      <option >Select Tax Type</option>
            @foreach($tax_type->sortBy('name') as $tt_key => $tt_val )
                                 <option value="{{$tt_val['id']}}">
                {{$tt_val['name']}}  
              </option> 
            @endforeach
        </select>
        </div>  
      </div>
     
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Rate<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="rate" type="text" class="form-control only_num" name="rate"  autocomplete="name" autofocus>
        </div>  
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="addTaxRate()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>

<!---Edit Tax Rate ---->

<div class="edit_tax_rate">

</div>


<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showStatusForm()">Create Tax Rate</button>
   </div>
</div>

<div class="card"> 
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Tax Rates</h5>
</div> 

<div class="card-body"> 
<!---Edit Rate Close---->

 


<div class="table-responsive  tax_rate_list">
 
</div>
</div>
</div>




@section('script')
 
<script type="text/javascript">

  $(document).ready(function(){

   taxRateList();

   });
 

  function showStatusForm(){
      
      $(".add_tax_rate").show();
      $(".edit_tax_rate").hide();   
     
  }

  function closeForm(){
     
     $(".add_tax_rate").hide();
     $(".edit_tax_rate").hide();   
  
  }

  function  taxRateList(){
 
      var url="tax-rate-list";
      $.get(url , function (data) {
         
        $(".tax_rate_list").html(data);
        $('.tbl_tax_type_list').DataTable();
     
    });

 }

 function addTaxRate(){
 var url="{{route('taxrate.store') }}";
 var form_data=$("#tax_rate_form").serialize();

    $.ajax({
         url : url,
         type : "post",
         data : form_data,
         success:function(data){
           
          if(data.success){ 
            $("#tax_rate_form")[0].reset();
            taxRateList();
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

 function editTaxRate(id) {
   
   var tax_rate_id=id;
   var url ="tax-rate-edit/"+tax_rate_id;

   $.get(url,function(data){
      $(".add_tax_rate").hide();
      $(".edit_tax_rate").show();
      $(".edit_tax_rate").html(data);
      $('#edit_tax_type').focus();
   });



 }

 function updateTaxRate() {
   
   var url="{{route('taxrate.update') }}";
 var form_data=$("#edit_tax_rate_form").serialize();

    $.ajax({
         
         url : url,
         type : "Post",
         data : form_data,
         success:function(data){

          if(data.success){ 
            $(".edit_tax_rate").hide();
            taxRateList();
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
     var url="tax-rate-status/"+id+"/"+status;
     $.get(url,function(data){
        
         $(".success_msg").show();
           $(".sucs").html(data["success"]);
           $(function(){
           $(".success_msg").delay(3000).fadeOut();
                
              });

         taxRateList();
     

   

     });

  }

//only numeric and decimal value

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