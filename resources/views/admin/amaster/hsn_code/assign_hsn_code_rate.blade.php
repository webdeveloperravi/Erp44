@extends('layouts.admin.app')
@section('content')
<div class="container"   onload="myfunction()">
     
    @if(empty($assign_hsn_code_rate))
   <div class="assign_hsn_code_rate" style="display:block">
      <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Asign Tax Rate</h5>
        </div>   
  
    <div class="card-body">
     <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="res"></ul>
     </div>

      <form id="assign-tax-rate-form" onsubmit="event.preventDefault()">
        @csrf
       <input type="hidden" name="hsn_code_id" value="{{$id}}">
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">HSN-CODE<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="name" type="text" class="form-control"  autocomplete="name" autofocus value="{{$hsncode}}" readonly="true">
        </div>	
      </div>
 
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Rate <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="tax_rate"  name="tax_rate" class="form-control  @error('tax_type') is-invalid @enderror">
                      <option >Select Tax Rate</option>
            @foreach($tax_rate->sortBy('name') as $tr_key => $tr_val )
                                 <option value="{{$tr_val['id']}}">
                    {{$tr_val['rate']}}% 
              </option> 
            @endforeach
        </select>
        </div>  
      </div>

        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Date<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
            <input id="date" type="text" class="form-control" name="manual_date" autocomplete="name" autofocus placeholder="dd/mm/yyyy" value={{old('manual_date')}}>
        </div>  
      </div>
      
    <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="submit" class="btn btn-success" id="btn-assign-rate">Save</button>
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>
@endif

<div class="edit_assign_hsn_code_rate">
</div>  

<div class="card">
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">HSN Codes ({{ $hsncode }}) </h5>
  </div> 
  @if(empty($assign_hsn_code_rate))
  <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
  @else
<table class="table table-bordered tbl_assigned_rate">
    <thead>
        <tr>
          <th>HSN-Code</th>
          <th>Tax Rate</th>
          <th>Created Date</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody> <tr>
               <td>{{$assign_hsn_code_rate->assign_hsn_code->hsn_code}}</td>
               <td>{{$assign_hsn_code_rate->assign_tax_rate->rate}}%</td>
               <td>{{$assign_hsn_code_rate->created_date}}</td>
               <td><button type="button" class="btn btn-primary btn-sm" onclick="edit_assign({{$assign_hsn_code_rate->hsn_code_id}})">Edit</button></td>
             </tr>
    </tbody>
  </table>
  @endif
</div>
  <a href="{{route('hsn.code')}}" class="btn btn-warning btn-sm m-t-10"> Back </a>

</div>
@section('script')

  <script type="text/javascript">

  $(document).ready(function() {
  $("#date").datepicker({
    dateFormat: "dd/mm/yy",
    defaultDate: '01/04/2019',
   changeMonth: true,
   changeYear: true,

  });
});
   

     // assign tax rate to HSN Code 

  $("#btn-assign-rate").click(function(e){

      e.preventDefault();
      var url='{{route('hsn.code.assign.rate.store')}}';
  var form_data=$("#assign-tax-rate-form").serialize(); 
  $.ajax({

         url : url,
         type : "POST",
         data : form_data,
         success : function(data)
         {
          if(data.success){  
            notify('Successfully Saved', 'success'); 
             window.location.href="{{route('hsn.code') }}";
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


function edit_assign(id)
{
  
   var assign_hsn_code_rate_id=id;
   var url="{{ route('hsn.code.assign.edit',['/'])}}/"+assign_hsn_code_rate_id;

       $.get(url,function(data){
      $(".edit_assign_hsn_code_rate").show();
      $(".edit_assign_hsn_code_rate").html(data);
      $("#edit_tax_rate").focus();

   }); 
       

}

function closeForm()
{

   $(".edit_assign_hsn_code_rate").hide();

}




  </script>

@endsection
@endsection
