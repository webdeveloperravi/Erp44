@extends('layouts.admin.app')
@section('content')
<div class="container">
 @php
 @endphp
 <h2></h2>
  <div class="col-md-12 col-sm-12">
        <div class="card" class="showForm" >
        <div class="card-header text-secondary"><h2>Assigned Category And Grade</h2></div>
        <div class="card-body">
          <form id="view_form">
            @csrf
 <div class="row">
        <div class="col-md-3 col-sm-3"> 
         <label class="font-weight-bold">Product</label> 
         <select class="form-control m-b-15 filter" id="cate_id" name="cate_id">
           <option value="0" selected>All</option>
              @foreach($categories as $ckey => $cval)
               <option value="{{$cval->id}}">{{ $cval->name }}</option>
              @endforeach
         </select>
        </div>

        <div class="col-md-3 col-sm-4">
         <label class="font-weight-bold">Grade </label>
         <div class="form-row">
          <div class="col-md-6">
          <input type="checkbox" name="grade[assigned]" checked="" id="rb_g_assign" value="assigned" class="filter">&nbsp;<small class="text-uppercase">Assigned</small> </div>
           <div class="col-md-6"> <input type="checkbox" name="grade[unassigned]" id="rb_g_unassign" value="unassigned" checked class="filter"> &nbsp;<small class="text-uppercase" >Un-Assigned</small></div>
        </div> 
        </div>
            <div style="width:1px; background-color:black"></div>
        <div class="col-md-5 col-sm-4">
         <label class="font-weight-bold">Grade with Rate Profile Assigned & Un-assigned </label>
         <div class="form-row">
          <div class="col-md-6">
          <input type="checkbox" name="profile[assigned]" checked="" id="rb_p_assign" value="assigned" class="filter">&nbsp;<small class="text-uppercase">Assigned</small> </div>
           <div class="col-md-6"> <input type="checkbox" name="profile[unassigned]" id="rb_p_unassign" value="unassigned" checked class="filter"> &nbsp;<small class="text-uppercase">Un-Assigned</small></div>
        </div> 
        </div>
      </div> 
      </form> 
  </div>
</div>
</div>
        <!---table--->

    <div class='table-responsive m-15' id="assigned_view">
     
       <!--Assigned View Record---->     
  

    </div>
    <!--table close div-->
    <div class="col-md-1">
    <a href="{{ url()->previous()}}"  class="btn btn-warning " style="margin-top:7px;"> Back</a>
  </div>
  
     </div>
    
@section('script')

<script type="text/javascript">
	
	$(document).ready(function(event){
         recordsAssigned();
         // alert("View Called");
         
         

     });

	// to show All Records
	function recordsAssigned(){

    form_data=$("#view_form").serialize();
      $.ajax({
         type : "POST",
         url : "{{route('view.all')}}",
         data  : form_data,
         success : function(res)
         {

           $('#assigned_view').html(res);
        
         }


    });
  
  return false;
  }

    
	
  
  // filter Category
  $(".filter").on('change',function(e){
    e.preventDefault();
     
     recordsAssigned();
   
  });

</script>

@endsection
@endsection


