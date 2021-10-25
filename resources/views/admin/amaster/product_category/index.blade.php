@extends('layouts.admin.app')
@section('content')
<div class="container">  
     <div class="row justify-content-center" id="new_color"  style="display:none">
        <div class="col-md-12 col-sm-12">
           <div class="card" class="showForm" >
              <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
                 <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Product Category</h5>
              </div>
              <div class="card-body">
                 <!----Error Message Display------>
                 <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul id="res">
                    </ul>
                 </div>
                 <!----Error Message---Close--->
                 <form method="POST" action="" enctype="multipart/form-data" id="pro_type_form" onsubmit="event.preventDefault()">
                    @csrf
                    <div class="form-group row">
                       <label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Product Category Name <span class="alert-danger">*</span></label>
                       <div class="col-md-6">
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus> 
                       </div>
                    </div>
                    <div class="form-group row">
                       <label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Alias</label>
                       <div class="col-md-6">
                          <input id="alias" type="text" class="form-control @error('name') is-invalid @enderror" name="alias" value="{{ old('name') }}"  autocomplete="name" autofocus> 
                       </div>
                    </div>
                    {{-- <div class="form-group row">
                       <label for="name" class="col-md-4 col-form-label text-md-right text-secondary">Master<span class="alert-danger">*</span></label>
                       <div class="col-md-6">
                          <select class="form-control" name='masters[]' multiple="">
                             <option>Select Master</option>
                             @foreach($masters as $master)
                             <option value="{{$master->id}}">{{$master->name}}</option>
                             @endforeach
                          </select> 
                       </div>
                    </div> --}}
                    <div class="row">
                       <label for="image" class="col-md-4 col-form-label text-md-right text-secondary">Image </label>
                       <div class="col-md-6">
                          <input id="image" type="file"   name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('hsn_code') }}"  autocomplete="name" autofocus > 
                       </div>
                    </div>
              </div>
              <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4 m-b-10">
              <button  class="btn btn-primary" id="btn_product_type">
              Save
              </button>
              <button  class="btn btn-danger" onclick="($(new_color).hide())">
              Close
              </button>
              </div>
              </div>
              </form>
           </div>
        </div>
     </div> 
<div class="row">
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="showForm()">Create Product Category</button>
  </div>
</div>
<div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Product Category List</h5>
  </div>
  <div class="card-body">
     <div class='table-responsive' id='result1' >
        <!--- table info---->
     </div>
  </div>
</div>
</div>
<div id="attachMasterView"></div>
@section('script')

<script type="text/javascript" >
    

$(document).ready(function(){

fetchProductType();

});



// save record

$("#btn_product_type").on('click',function(event){
   event.preventDefault();
  
     $.ajax({

        url:"{{ route('product-type.store') }}",
        method : 'post',
        data :new FormData($("#pro_type_form")[0]),
       contentType:false,
       processData:false,
       cache:false,
       success : function(data)
       {
        if(data.success){ 
              fetchProductType();
              $("#pro_type_form")[0].reset();  
              $("#new_color").hide();
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


});





function fetchProductType(){
  
var url="{{route('product.cat.list') }}";
$.ajax({

   url : url,
   type : "get",
   success:function(data)
   {
    
    $("#result1").html(data);
     $("#pro_type_table").DataTable();
   }


});
}
 
function changeStatus(id,status){
   var url = "{{route('product.type.status',['/','/'])}}/"+id+"/"+status;
   $.get(url,function(data){ 
         fetchProductType();
         notify('Status Updated Successfully', 'success');  
    $(function(){
            $(".success_msg").delay(5000).fadeOut();
    });
    });
}


   // Attach Master View
function masterAttachView(productCategoryId){
   var url = "{{ route('productCategoryMasterAttach.view',['/']) }}/"+productCategoryId;
   $.get(url,function(data){
   
      $("#attachMasterView").html(data);
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
   });
 }
// Attach Masters 
 function attachMasters(){
        var url = "{{ route('productCategory.masterAttach') }}";
        $.ajax({
         method :"POST",
         url : url,
         data : $("#masterAttachForm").serialize(),
         success: function(data){
            $("#attachMasterView").html('');
            // $("#zoneViewRefresh").click();
            notify('Successfully Attached','success');

         }
     });
 }

// Attach Units View 
 function unitAttachView(productCategoryId){
   var url = "{{ route('productCategoryunitAttach.view',['/']) }}/"+productCategoryId;
   $.get(url,function(data){
   
      $("#attachMasterView").html(data);
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
   });
 }

 // Attach Units 

 function attachUnits(){
        var url = "{{ route('productCategory.unitAttach') }}";
        $.ajax({
         method :"POST",
         url : url,
         data : $("#unitAttachForm").serialize(),
         success: function(data){
            $("#attachMasterView").html('');
            // $("#zoneViewRefresh").click();
            notify('Successfully Attached','success');

         }
     });
 }

</script>


@endsection
@endsection


