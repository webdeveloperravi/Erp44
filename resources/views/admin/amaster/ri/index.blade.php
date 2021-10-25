
@extends('layouts.admin.app')
@section('content')
@php  use Illuminate\Support\Str; @endphp
<div class="container">

				@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!--- Show Message When we save record or update ---->

 @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
       <h4>{{Session::get('success')}}</h4>
   </div>
@endif
 @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible errors">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
       <h4>{{Session::get('error')}}</h4>
   </div>
@endif


    <div id="new_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                 <div class="row">
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">RI Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">

			<form method="POST" action="{{ route('ri.store') }}" enctype="multipart/form-data" id="riform">
				    @csrf
              <span id="msg_error">&nbsp;</span>
				       {{-- <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                 	<span id="msg_error">&nbsp;</span>
                                 </div>
                              </div> --}}
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">From<span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="ri_from" type="text" class="form-control only-numeric @error('from') is-invalid @enderror text-secondary" name="from" value="{{ old('from') }}"  autocomplete="name" autofocus {{-- onblur="checkRIFromExist()" --}}>
                                     <span id="msg_ri_from"></span>
				                @error('from')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">To <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="ri_to" type="text" class="form-control only-numeric @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="name" autofocus {{-- onblur="checkRIToExist()" --}}>
				                <span id="msg_ri_to"></span>

				                @error('to')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

                <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="ri_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_desc"></span>
                        
                    </div>
                </div>


				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return riValidation()" id="btn_ri_save">
                                   Save
                                </button>
                            </div>
                        </div>
				 </form>
				</div>
			</div>
		</div>
	</div>

	<div id="edit_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                <div class="row">
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit RI Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">

				
				

				<form method="POST" action="{{ route('ri.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
                     <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                  <span id="msg_error_update">&nbsp;</span>
                                 </div>
                              </div>

						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary ">From<span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_ri_from" type="text" class="form-control only-numeric @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}"  autocomplete="name" autofocus {{-- onblur="searchRiFromEdit()" --}}>
				                 <span id="msg_edit_ri_from"></span>

				                @error('from')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">To <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_ri_To" type="text" class="form-control only-numeric @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="name" autofocus {{-- onblur="searchRiToEdit()" --}}>
				                <span id="msg_edit_ri_to"></span>

				                @error('to')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
                <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="edit_ri_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_edit_ri_desc"></span>
                        
                    </div>
                </div>


				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_RI_updated">
                                   Update
                                </button>
                            </div>
                        </div>
				 </form>
				</div>
			</div>
		</div>
	</div>

	@php


	@endphp

	
     <div class="row float-right">
     <div class="col-md-4">
	<button onclick="showForm()" class="btn btn-success"> Add New RI </button>
    </div>
</div>
    <h2 class="text-left text-info">RI List</h2>
<div class='table-responsive'>
	<table class="table table-stripped " style="margin-top: 20px;" cellspacing="0" width="100%" id="ri_table">  
		 <thead class="bg-primary text-white">
    <tr>
				<th>UID</th>
				<th>From</th>
				<th>To</th>
         <th>Description</th>
				<th>status</th>
				<th>Action</th>
			</thead>
		</tr>

		<tbody>
        @if($data->isNotEmpty())
			@foreach($data as $ckey => $cval)
			<tr>
				<td>{{$cval->id}}</td>
				<td>{{ $cval->from}}</td>
				<td>{{ $cval->to}}</td>
        <td>{{str::limit($cval->descr,30)}}</td>
				<td>{{ ($cval->status==1?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('ri.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class="btn btn-sm btn-warning p-1" style="width:60px;">{{ ($cval->status==1?"In-active":"Active")}} </a> 
					<a href="{{route('ri.destroy',['id'=>$cval->id])}}" class="btn btn-sm btn-danger p-1" style="width:60px;"onclick="return confirm('Are You Sure To Delete RI')"> Delete</a>  
					<button onclick="edit_color({{$cval->id}} , '{{$cval->from}}', '{{$cval->to}}',`{{$cval->descr}}`)" class="btn btn-sm btn-info p-1" style="width:60px;"> edit </button>  

					</td>

			</tr>
			@endforeach
       @else
        <tr>
            <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
          </tr>

      @endif
			
		</tbody>
	</table>
</div>
</div>
  @section('script')
<script type="text/javascript">
	
$(document).ready(function(){
 
 $("#ri_table").DataTable();

  $(".only-numeric").keypress(function(event){ 
            return isNumber(event, this);
        });

})

function closeForm()
{
  $("#new_color").hide();
   $("#edit_color").hide();
}




function riValidation(){

   var name=$("#ri_from").val();
   var alias=$("#ri_to").val();
     var desc=$("#ri_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
       $("#ri_from").css('border','1px solid red');
        $("#msg_ri_from").html("From field is required").css('color','red');
        $("#msg_ri_to").html("To field is required").css('color','red');
         $("#ri_to").css('border','1px solid red');
         $("#msg_desc").html("Description field is required").css('color','red');
         $("#ri_desc").css('border','1px solid red');

    

      return false;
   }

   else if (name==="") {
      
        
     
       $("#ri_from").css('border','1px solid red');
        $("#msg_ri_from").html("From field is required").css('color','red'); 
      return false;


   }
   else if(alias==="")
   {
        $("#msg_ri_to").html("To field is required").css('color','red');
         $("#ri_to").css('border','1px solid red');


    return false;
   }
    else if(desc==="")
   {
        $("#msg_desc").html("Description field is required").css('color','red');
         $("#ri_desc").css('border','1px solid red');


    return false;
   }

   else{
    return true;
   }



}

// its is seraching RI from values from database 


function checkRIFromExist(){
  var  name=$("#ri_from").val();

   if(name.length>0)
   {
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/ri-from-exist/"+name,
           dataType  : "Json",
           success   : function(res)
           {
           	 if(res==1)
           	 {        
                     
                     $("#ri_from").css('border-color','red');
                     $("#msg_ri_from").html("RI FROM  Already Taken. Please Try Again").css('color','red');
                      $("#btn_ri_save").prop('disabled',true);
                      $("#ri_to").prop('disabled',true);
                    
                
                       
                     
           	 }
             else if(res==2)
             {        
                     
                     $("#ri_from").css('border-color','red');
                     $("#msg_ri_from").html("RI FROM  has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                      $("#btn_ri_save").prop('disabled',true);
                      $("#ri_to").prop('disabled',true);
                    
                
                       
                     
             }
           	 else
           	 {        
           	 	       $("#ri_from").css('border-color','green');
                     $("#msg_ri_from").html("RI FROM Available").css('color','green');
                       $("#btn_ri_save").prop('disabled',false);
                      $("#ri_to").prop('disabled',false);
                     
                
                    
                     
           	 }
           }

      });
   }
    else{ 

         $("#ri_from").css('border','1px solid #ccc');
         $("#btn_ri_save").prop('disabled',false);
        $("#ri_to").prop('disabled',false);
         $("#msg_ri_from").html("");
                
  }

}

// its searching RI To values from database;

function checkRIToExist(){
 var  desc=$("#ri_to").val();

   if(desc.length>0)
   {
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/ri-to-exist/"+desc,
           dataType  : "Json",
           success   : function(res)
           {
             if(res==1)
             {        
                     
                     $("#ri_to").css('border-color','red');
                     $("#msg_ri_to").html("RI TO  Already Taken. Please Try Again").css('color','red');
                     $("#btn_ri_save").prop('disabled',true);
                     $("#ri_from").prop('disabled',true);
                      
                
                       
                     
             }
             else   if(res==2)
             {        
                     
                     $("#ri_to").css('border-color','red');
                     $("#msg_ri_to").html("RI TO  has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_ri_save").prop('disabled',true);
                     $("#ri_from").prop('disabled',true);
                      
                
                       
                     
             }
             else
             {        
                     $("#ri_to").css('border-color','green');
                     $("#msg_ri_to").html("RI TO Available").css('color','green');
                     $("#btn_ri_save").prop('disabled',false);
                      $("#ri_from").prop('disabled',false);
                     
                
                       
                      
             }
           }

      });
   }
    else{
     $("#ri_to").css('border','1px solid #ccc');
    $("#btn_ri_save").prop('disabled',false);
    $("#ri_from").prop('disabled',false);
    $("#msg_ri_to").html("");
                
     
  }

}

// validation for updation form
  $(document).ready(function(){

$("#btn_RI_updated").click(function(){

  
   var edit_ri_from=$("#edit_ri_from").val();
   var edit_ri_to=$("#edit_ri_To").val();
    var edit_ri_desc=$("#edit_ri_desc").val();
   
   if(edit_ri_from=="" && edit_ri_to==="" && edit_ri_desc==="")
   {
        
       $("#edit_ri_from").css('border','1px solid red');
        $("#msg_edit_ri_from").html("From field is required").css('color','red');
        $("#msg_edit_ri_to").html("To field is required").css('color','red');
        $("#edit_ri_To").css('border','1px solid red');
        $("#msg_edit_ri_desc").html("Description field is required").css('color','red');
        $("#edit_ri_desc").css('border','1px solid red');

    

    return false;
   }
   else if(edit_ri_from=="")
   {
      $("#edit_ri_from").css('border','1px solid red');
        $("#msg_edit_ri_from").html("From field is required").css('color','red');
     
    
    return false;
   }

   else if(edit_ri_to==="")
   {

             $("#msg_edit_ri_to").html("To field is required").css('color','red');
              $("#edit_ri_To").css('border','1px solid red');

    return false;
   }
   else if(edit_ri_desc==="")
   {

             $("#msg_edit_ri_desc").html("Description field is required").css('color','red');
              $("#edit_ri_desc").css('border','1px solid red');

    return false;
   }
   else
   {
    

    return true;
    }

});

});

//its searching ri to values from database. while we update time functionality
function searchRiToEdit(){

var id=$("#edit").val();
var ri_to=$("#edit_ri_To").val();


if(ri_to.length>0){

   $.ajax({
        
          type :"GET",
          url  :"../admin/ri-to-exist-edit/"+id+"/"+ri_to,
          dataType :"JSON",
          success :function(result)
          {
             
                   if(result==0)
                  {
                    
                     $("#msg_edit_ri_to").html("Already RI TO Assigned This ID").css('color','gray');
                     $("#edit_ri_To").css('border','1px solid #ccc');
                     $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_from").prop('disabled', false);
                     
                     
                  }
                  else if(result==1)
                  {
                     
                     $("#msg_edit_ri_to").html("RI To Name Already Taken. Please Try Again").css('color','red');
                     $("#edit_ri_To").css('border-color','red');
                     $("#btn_RI_updated").prop('disabled', true);
                     $("#edit_ri_from").prop('disabled', true);
                      
                  }
                  else if(result==2)
                  {
                     
                     $("#msg_edit_ri_to").html("RI From Name Available").css('color','green');
                     $("#edit_ri_To").css('border-color','green');
                     $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_from").prop('disabled', false);
                    
                     
                  }
                   else if(result==3)
                  {
                     
                     $("#msg_edit_ri_to").html("RI To Name  has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_ri_To").css('border-color','red');
                     $("#btn_RI_updated").prop('disabled', true);
                     $("#edit_ri_from").prop('disabled', true);
                      
                  }
              



          }


      });

}
 else 

 {                   
                      $("#edit_ri_To").css('border','1px solid #ccc');
                     $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_from").prop('disabled', false);
                     $("#msg_edit_ri_to").html("");

                     
 }

} // close search ri to edit

function searchRiFromEdit(){
 
 var id=$("#edit").val();
var ri_from=$("#edit_ri_from").val();
 
if(ri_from.length>0)
{
 
   
     $.ajax({
        
          type :"GET",
          url  :"../admin/ri-from-exist-edit/"+id+"/"+ri_from,
          dataType :"JSON",
          success :function(result)
          {
             
                   if(result==0)
                  {
                     
                     $("#msg_edit_ri_from").html("Already RI Name Assigned This ID").css('color','gray');
                     $("#edit_ri_from").css('border','1px solid #ccc');
                     $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_To").prop('disabled', false);
                    
                    
                      
                  }
                  else if(result==1)
                  {
                     
                     $("#msg_edit_ri_from").html("RI From Name Already Taken. Please Try Again").css('color','red');
                     $("#edit_ri_from").css('border-color','red');
                     $("#btn_RI_updated").prop('disabled', true);
                      $("#edit_ri_To").prop('disabled', true);
                     
                      
                  }
                  else if(result==2)
                  {
                    
                     $("#msg_edit_ri_from").html("RI From Name Available").css('color','green');
                     $("#edit_ri_from").css('border-color','green');
                     $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_To").prop('disabled', false);
                    
                    
                  }
                   else if(result==3)
                  {
                     
                     $("#msg_edit_ri_from").html("RI From Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_ri_from").css('border-color','red');
                     $("#btn_RI_updated").prop('disabled', true);
                      $("#edit_ri_To").prop('disabled', true);
                     
                      
                  }
              



          }


      });




}
else
{          
                      $("#edit_ri_from").css('border','1px solid #ccc');
                   $("#btn_RI_updated").prop('disabled', false);
                     $("#edit_ri_To").prop('disabled', false);
                     $("#msg_edit_ri_from").html("");
                    

                     
}

}// search ri from edit

$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
$(".errors").delay('3000').fadeOut();

  
})

    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // Check minus and only once.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // Check for dots and only once.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }




</script>

@endsection

@endsection
