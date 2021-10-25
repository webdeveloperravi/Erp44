
@extends('layouts.admin.app')
@section('content')
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
    <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
       <h4>{{Session::get('error')}}</h4>
   </div>
@endif

    <div id="new_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                 <div class="row">
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">SG Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">

				
    <form method="POST" action="{{ route('sg.store') }}" enctype="multipart/form-data">
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
				                <input id="sg_from" type="text" class="form-control only-numeric @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}"  autocomplete="from" autofocus {{-- onblur ="checkSGFromExist()" --}}>
                                   <span id="msg_sg_from"></span>
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
				                <input id="sg_to" type="text" class="form-control only-numeric @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="name" autofocus {{-- onblur="checkSGToExist()" --}}>
                                        <span id="msg_sg_to"></span>
				                @error('to')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

                <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <input id="sg_desc" type="text" class="form-control @error('to') is-invalid @enderror" name="desc" value="{{ old('desc') }}"  autocomplete="name" autofocus>
                                        <span id="msg_sg_desc"></span>
                        @error('to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return sgValidation()" id="btn_sg_saved">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit SG Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">

			   <form method="POST" action="{{ route('sg.update') }}" enctype="multipart/form-data">
				    @csrf
   <span id="msg_error_update">&nbsp;</span>
				    <input id="edit" type="hidden" name="id" >
            {{-- <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                  <span id="msg_error_update">&nbsp;</span>
                                 </div>
                              </div> --}}
						<div class="form-group row">
                       
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">SG<span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_sg_from" type="text" class="form-control only-numeric @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}"  autocomplete="name" autofocus {{-- onblur="searchFromEdit()" --}}>
                                   <span id="msg_edit_sg_from"></span>
				                @error('from')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">to <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_sg_to" type="text" class="form-control only-numeric @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}"  autocomplete="name" autofocus {{-- onblur="searchToEdit() --}}">
				                 <span id="msg_edit_sg_to"></span>

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
                        <input id="edit_sg_desc" type="text" class="form-control @error('to') is-invalid @enderror" name="desc" value="{{ old('to') }}"  autocomplete="name" autofocus>
                         <span id="msg_edit_sg_desc"></span>

                        @error('to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_sg_updated">
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

	<div class="row">
                       <div class="col-md-6 offset-md-2 col-sm-6 offset-sm-2">
                       	  @if(Session::has('exist'))
                       	  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                         <h4> {{Session::get('exist')}} </h4>
                         </div>      
                       @endif
                        </div>
				      </div>
     <div class="row float-right">
     <div class="col-md-4">
	<button onclick="showForm()" class="btn btn-success"> Add New SG </button>
    </div>
</div>
    <h2 class="text-left text-info">SG List</h2>
<div class='table-responsive'>
	<table class="table table-stripped " style="margin-top: 20px;" id="sg_table" width="100%" cellspacing="0" >  
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
        <td>{{ $cval->descr}}</td>
				<td>{{ ($cval->status==1?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('sg.status',['id'=>$cval->id , 'status'=>$cval->status])}}"  class='btn btn-warning btn-sm p-1' style="width:60px;">{{ ($cval->status==1?"In-active":"Active")}} </a> 
					<a href="{{route('sg.destroy',['id'=>$cval->id])}}"  class="btn btn-danger btn-sm p-1" style="width:60px;" onclick="return confirm('Are You Sure To Delete SG')"> Delete</a>  
					<button class="btn btn-sm btn-primary p-1"  onclick="edit_color({{$cval->id}} , '{{$cval->from}}', '{{$cval->to}}', `{{ $cval->descr }}`)" style="width:60px;"> edit </button>  

					</td>

			</tr>
			@endforeach
       @else
        <tr>
            <td colspan="6"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
          </tr>

      @endif
			
		</tbody>
	</table>
</div>
</div>

  @section('script')
<script type="text/javascript">

  $(document).ready(function(){
  
     $("#sg_table").DataTable();

      $(".only-numeric").keypress(function(event){ 
            return isNumber(event, this);
        });

  })
  // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(event, elementRef) {

        var self = $(elementRef);
   self.val(self.val().replace(/[^0-9\.]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
      return false;
   }


//    if ((event.which > 47 && event.which < 58) ||event.which== 190){
          
//                 return true;
//             }
//             else{
//                 return  false;
//             }
          
    }


  function closeForm()
{
  $("#new_color").hide();
   $("#edit_color").hide();
}
	
function sgValidation(){

   var name=$("#sg_from").val();
   var alias=$("#sg_to").val();
    var desc=$("#sg_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
       $("#sg_from").css('border','1px solid red');
        $("#msg_sg_from").html("From field is required").css('color','red');
        $("#msg_sg_to").html("To field is required").css('color','red');
         $("#sg_to").css('border','1px solid red');
         $("#msg_sg_desc").html("Description field is required").css('color','red');
         $("#sg_desc").css('border','1px solid red');

   
      return false;
   }

   else if (name==="") {
      
     
      $("#sg_from").css('border','1px solid red');
       $("#msg_sg_from").html("From field is required").css('color','red');
       
      return false;


   }
   else if(alias==="")
   {
          $("#msg_sg_to").html("To field is required").css('color','red');
          $("#sg_to").css('border','1px solid red');


    return false;
   }
   else if(desc==="")
   {
          $("#msg_sg_desc").html("Description field is required").css('color','red');
          $("#sg_desc").css('border','1px solid red');


    return false;
   }

   else{
    return true;
   }



}
function checkSGFromExist(){
  var  name=$("#sg_from").val();

   if(name.length>0)
   {
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/sg-from-exist/"+name,
           dataType  : "Json",
           success   : function(res)
           {
           	 if(res==1)
           	 {
                 
           	 	       $("#sg_from").css('border-color','red');
                     $("#msg_sg_from").html("SG FROM Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_sg_saved").prop('disabled',true);
                     $("#sg_to").prop('disabled',true);
                     
                
                    
                      
           	 }
             else  if(res==2)
             {
                 
                     $("#sg_from").css('border-color','red');
                     $("#msg_sg_from").html("SG FROM Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_sg_saved").prop('disabled',true);
                     $("#sg_to").prop('disabled',true);
                     
                
                    
                      
             }
           	 else
           	 {  
           	 	       $("#sg_from").css('border-color','green');
                     $("#msg_sg_from").html("SG FROM  Name Available").css('color','green');
                      $("#btn_sg_saved").prop('disabled',false);
                      $("#sg_to").prop('disabled',false);
                      
           	 }
           }

      });
   }
   else{
    
                 $("#sg_from").css('border','1px solid #ccc');
                 $("#btn_sg_saved").prop('disabled',false);
                 $("#sg_to").prop('disabled',false);
                 $("#msg_sg_from").html("");
                
  }

}
function checkSGToExist(){
 var  desc=$("#sg_to").val();

     if(desc.length>0){
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/sg-to-exist/"+desc,
           dataType  : "Json",
           success   : function(res)
           {
           	if(res==1)
           	 {
               
           	 	        $("#sg_to").css('border-color','red');
                      $("#msg_sg_to").html("SG TO Name Already Taken. Please Try Again").css('color','red');
                      $("#btn_sg_saved").prop('disabled',true);
                      $("#sg_from").prop('disabled',true);
                      
                
                    
                      
                    
           	 }
             else if(res==2)
             {
               
                      $("#sg_to").css('border-color','red');
                      $("#msg_sg_to").html("SG TO Name has been Already Taken and  Deleted . Please Contact Administrator").css('color','red');
                      $("#btn_sg_saved").prop('disabled',true);
                      $("#sg_from").prop('disabled',true);
                      
                
                    
                      
                    
             }
           	 else
           	 {
                
           	 	       $("#sg_to").css('border-color','green');
                     $("#msg_sg_to").html("SG TO Name Available").css('color','green');
                     $("#btn_sg_saved").prop('disabled',false);
                     $("#sg_from").prop('disabled',false);
                     
                
                   
           	 }
           }

      });
   }
   else{
                        $("#sg_to").css('border','1px solid #ccc');
                       $("#msg_sg_to").html("");
                      $("#btn_sg_saved").prop('disabled',false);
                      $("#sg_from").prop('disabled',false);
                     
  } 


}

// edit validation
  
$("#btn_sg_updated").click(function(){

  
   var edit_sg_from=$("#edit_sg_from").val();
   var edit_sg_to=$("#edit_sg_to").val();
    var edit_sg_desc=$("#edit_sg_desc").val();
   
   if(edit_sg_from=="" && edit_sg_to==="" && edit_sg_desc==="")
   {
        $("#edit_sg_from").css('border','1px solid red');
        $("#msg_edit_sg_from").html("SG From field is required").css('color','red');
        $("#msg_edit_sg_to").html("SG To field is required").css('color','red');
        $("#edit_sg_to").css('border','1px solid red');
        $("#msg_edit_sg_desc").html("Description To field is required").css('color','red');
         $("#edit_sg_desc").css('border','1px solid red');

  
    return false;
   }
   else if(edit_sg_from=="")
   {
       
         $("#edit_sg_from").css('border','1px solid red');
        $("#msg_edit_sg_from").html("SG From field is required").css('color','red');
         
          
  

    return false;
   }

   else if(edit_sg_to==="")
   {
      
          $("#msg_edit_sg_to").html("SG To field is required").css('color','red');
         $("#edit_sg_to").css('border','1px solid red');

   
  
    return false;
   }

    else if(edit_sg_desc==="")
   {
      
          $("#msg_edit_sg_desc").html("Description To field is required").css('color','red');
         $("#edit_sg_desc").css('border','1px solid red');

   
  
    return false;
   }
   else
   {
    return true;
   }

})

function searchFromEdit(){

  var edit_from=$("#edit_sg_from").val();
  var id=$("#edit").val();
 $("#btn_sg_update").prop('disabled', false);
  if(edit_from.length>0){
   
     
      $.ajax({
        
          type :"GET",
          url  :"../admin/sg-from-exist-edit/"+id+"/"+edit_from,
          dataType :"JSON",
          success :function(result)
          {
             
                   if(result==0)
                  {
                     
                     $("#msg_edit_sg_from").html("Already SG Name Assigned This ID").css('color','gray');
                     $("#edit_sg_from").css('border','1px solid #ccc');
                     $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_to").prop('disabled', false);
                    
                     
                  }
                  else if(result==1)
                  {
                      
                     $("#msg_edit_sg_from").html("SG Name Already Taken. Please Try Again").css('color','red');
                     $("#edit_sg_from").css('border-color','red');
                     $("#btn_sg_updated").prop('disabled', true);
                     $("#edit_sg_to").prop('disabled', true);
                    
                     
                                       }
                  else if(result==2)
                  {
                    
                     $("#msg_edit_sg_from").html("SG Name Available").css('color','green');
                     $("#edit_sg_from").css('border-color','green');
                     $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_to").prop('disabled', false);
                    
                     
                      
                  }
                   else if(result==3)
                  {
                      
                     $("#msg_edit_sg_from").html("SG Name has been  Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_sg_from").css('border-color','red');
                     $("#btn_sg_updated").prop('disabled', true);
                     $("#edit_sg_to").prop('disabled', true);
                    
                     
                                       }
              



          }


      }); 
  


  }
  else{
                          
                     $("#edit_sg_from").css('border','1px solid #ccc');
                     $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_to").prop('disabled', false);
                     $("#msg_edit_sg_from").html("");
                     
  }


}  // function close of searchfromedit


 // function to search to name value from database
   function searchToEdit(){

    
    var edit_to=$("#edit_sg_to").val();
  var id=$("#edit").val();
  $("#btn_sg_update").prop('disabled', false);

  if(edit_to.length>0){
   
     
      $.ajax({
        
          type :"GET",
          url  :"../admin/sg-to-exist-edit/"+id+"/"+edit_to,
          dataType :"JSON",
          success :function(result)
          {
             
                   if(result==0)
                  {
                    
                     $("#msg_edit_sg_to").html("Already SG To Assigned This ID").css('color','gray');
                     $("#edit_sg_to").css('border','1px solid #ccc');
                     $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_from").prop('disabled', false);
                    
                    
                  }
                  else if(result==1)
                  {
                      
                     $("#msg_edit_sg_to").html("SG To Already Taken. Please Try Again").css('color','red');
                     $("#edit_sg_to").css('border-color','red');
                     $("#btn_sg_updated").prop('disabled', true);
                     $("#edit_sg_from").prop('disabled', true);
                      
                  }

                  else if(result==2)
                  {
                    
                     $("#msg_edit_sg_to").html("SG Name Available").css('color','green');
                     $("#edit_sg_to").css('border-color','green');
                     $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_from").prop('disabled', false);
                    
                     
                  }
                   else if(result==3)
                  {
                      
                  $("#msg_edit_sg_to").html("SG To has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_sg_to").css('border-color','red');
                     $("#btn_sg_updated").prop('disabled', true);
                     $("#edit_sg_from").prop('disabled', true);
                      
                  }
              



          }


      }); 
  


  }
  else{
                     $("#edit_sg_to").css('border','1px solid #ccc');
                    $("#btn_sg_updated").prop('disabled', false);
                     $("#edit_sg_from").prop('disabled', false);
                     $("#msg_edit_sg_to").html("");
                    
  }


   }

$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
$(".errors").delay('3000').fadeOut();

})







   </script>

@endsection

@endsection

