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
    <div class="alert alert-danger alert-dismissible errors">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
       <h4>{{Session::get('error')}}</h4>
   </div>
@endif

    <div id="new_color"  style="display: none;" class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card" class="showForm" >
                <div class="row">
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Treatment Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>  
              

                
                <div class="card-body">
	

			<form method="POST" action="{{ route('treatment.store') }}" enctype="multipart/form-data">
				    @csrf
              <span id="msg_error">&nbsp;</span>
				  {{--   <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                
                                 </div>
                              </div> --}}
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Treatment<span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="treatment" type="text" class="form-control @error('treatment') is-invalid @enderror" name="treatment" value="{{ old('treatment') }}"  autocomplete="treatment" autofocus onblur=" return checkTreatmentNameExist()">
                                 <span id="msg_treat"></span>
				                @error('treatment')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="description" autofocus onblur=" return checkTreatmentDescExist()">
                                       <span id="msg_desc"></span>
				                @error('description')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return treatmentValidation()" id="btn-treat-save">
                                   Save
                                </button>
                                <button type="button" class="btn btn-danger"  onclick="$('#new_color').hide()">
                                    Close
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit Treatment Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">

				

				

				<form method="POST" action="{{ route('treatment.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
              <span id="msg_error_update">&nbsp;</span>
            {{--  <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                  <span id="msg_error_update">&nbsp;</span>
                                 </div>
                              </div> --}}
          
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Treatment<span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_treat_name" type="text" class="form-control @error('treatment') is-invalid @enderror" name="treatment" value="{{ old('treatment') }}"  autocomplete="name" autofocus onblur="editTreatName()">
                           <span id="msg_edit_treat_name"></span>
				                @error('treatment')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_treat_desc" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="name" autofocus onblur="editTreatDesc()">
                                <span id="msg_edit_treat_desc"></span>
				                @error('description')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_treat_update" onclick=" return updateValidation()">
                                   Update
                                </button>
                                <button type="button" class="btn btn-danger"  onclick="$('#edit_color').hide()">
                                    Close
                                 </button>
                            </div>
                        </div>
				 </form>
				</div>
			</div>
		</div>
	</div>

     <div class="row float-right">
     <div class="col-md-4">
	<button onclick="showForm()" class="btn btn-success"> Add New Treatment  </button>
    </div>
</div>
    <h2 class="text-left text-info">  List</h2>
<div class='table-responsive'>
	<table class="table table-stripped table-bordered" style="margin-top: 20px;" id="treatment_table"  cellspacing="0" width="100%">
    <thead class="bg-primary text-white">  
		<tr>
		
				<th>UID</th>
				<th>Treatment</th>
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
				<td>{{ $cval->treatment}}</td>
				<td>{{ $cval->description}}</td>
				<td class=" text-success">{{ ($cval->status==1?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('treatment.status',['id'=>$cval->id , 'status'=>$cval->status])}}"  class="btn btn-sm btn-warning p-1" style="width:60px;">{{ ($cval->status==1?"In-active":"Active")}} </a> 
					{{-- <a href="{{route('treatment.destroy',['id'=>$cval->id])}}" class="btn btn-sm btn-danger p-1" style="width:60px;" onclick="return confirm('Are You Sure To Delete Treatment')"> Delete</a>   --}}
					<button onclick="edit_color({{$cval->id}} , '{{$cval->treatment}}', '{{$cval->description}}')" class="btn btn-sm btn-primary p-1" style="width:60px;"> edit </button>  

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

  $("#treatment_table").DataTable();
})

function closeForm(){
  $("#new_color").hide();
  $("#edit_color").hide();
}



   
  function treatmentValidation() {

   var name=$("#treatment").val();
   var alias=$("#description").val();

 if(name==="" && alias==="" )
   {
   
        $("#treatment").css('border','1px solid red');
        $("#msg_treat").html("Treatment Name field is required").css('color','red');
        $("#msg_desc").html("Description field is required").css('color','red');
       $("#description").css('border','1px solid red');

    
      return false;
   }

   else if (name==="") {
      
        $("#treatment").css('border','1px solid red');
        $("#msg_treat").html("Treatment Name field is required").css('color','red');
       
      return false;


   }
   else if(alias==="")
   {
      
       $("#msg_desc").html("Description field is required").css('color','red');
       $("#description").css('border','1px solid red');

    return false;
   }

   else{
    return true;
   }

}

function checkTreatmentNameExist(){
  var  name=$("#treatment").val();
  
   if(name.length>0 )
   {   
      $.ajax({
        
           method : "GET",
           url    : "../admin/treatment-name-exist/"+name,
           dataType  : "Json",
           success   : function(res)
           {
           	 if(res==1)
           	 {
               	 	   $("#treatment").css('border-color','red');
                     $("#msg_treat").html("Treatment Name Already Taken. Please Try Again").css('color','red');
                     $("#btn-treat-save").prop('disabled',true);
                     $("#description").prop('disabled',true);
                     
                
                                           
           	 }

             else 
             if(res==2)
             {
                     $("#treatment").css('border-color','red');
                     $("#msg_treat").html("Treatment Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn-treat-save").prop('disabled',true);
                     $("#description").prop('disabled',true);
                     
                
                                           
             }
           	 else
           	 {
           	 	       $("#treatment").css('border-color','green');
                     $("#msg_treat").html("Treatment Name Available").css('color','green');
                     $("#btn-treat-save").prop('disabled',false);
                     $("#description").prop('disabled',false);
                     
                
                      
                      
                    
                      
                      
           	 }
           }

      });
    
   }
   else
   {
       $("#treatment").css('border','1px solid #ccc');
      $("#btn-treat-save").prop('disabled',false);
       $("#description").prop('disabled',false);
       $("#msg_treat").html("");
                      
                      
   }

}
  
  
function checkTreatmentDescExist(){
 var  desc=$("#description").val();

   if(desc.length>0)
   {

       
      $.ajax({
        
           method : "GET",
           url    : "../admin/treatment-desc-exist/"+desc,
           dataType  : "Json",
           success   : function(res)
           {
           	if(res==1)
           	 {
           	 	  $("#description").css('border-color','red');
                $("#msg_desc").html("Treatment Description Already Taken. Please Try Again").css('color','red');
                $("#btn-treat-save").prop('disabled',true);
                $("#treatment").prop('disabled',true);
               
                
                    
           	 }
             else if(res==2)
             {
                $("#description").css('border-color','red');
                $("#msg_desc").html("Treatment Description has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                $("#btn-treat-save").prop('disabled',true);
                $("#treatment").prop('disabled',true);
               
                
                    
             }

           	 else
           	 {
           	 	       $("#description").css('border-color','green');
                     $("#msg_desc").html("Treatment Description Available").css('color','green');
                     $("#btn-treat-save").prop('disabled',false);
                     $("#treatment").prop('disabled',false);
                     
                
           	 }
           }

      });
   }
   else
   {
    $("#description").css('border','1px solid #ccc');
    $("#btn-treat-save").prop('disabled',false);
     $("#treatment").prop('disabled',false);
     $("#msg_desc").html("");
                
   }


}

function updateValidation(){

  var edit_name=$("#edit_treat_name").val();
  var edit_desc=$("#edit_treat_desc").val();
  
  if((edit_name=="" && edit_desc===""))
  {
        $("#edit_treat_name").css('border','1px solid red');
        $("#msg_edit_treat_name").html("Treatment Name field is required").css('color','red');
        $("#msg_edit_treat_desc").html("Description field is required").css('color','red');
       $("#edit_treat_desc").css('border','1px solid red');

      
            return false;
  }
   else if (edit_name==="") {
      
      $("#msg_edit_treat_name").html("Treatment Name Filed is required").css('color','red');
        $("#edit_treat_name").css('border','1px solid red');
      
      return false;


   }
   else if(edit_desc==="")
   {
      
      $("#msg_edit_treat_desc").html("Description Name Filed is required").css('color','red');
      $("#edit_treat_desc").css('border','1px solid red');

     

    return false;
   }

   else{
    return true;
   }





}

function editTreatName(){

var  name=$("#edit_treat_name").val();
var id=$("#edit").val();

   if(name.length>0)
   {
    
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/treatment-name-exist-edit/"+id+"/"+name,
           dataType  : "Json",
           success:function(res){
                     
                     console.log(res);
                    
                     if(res==0)
                  {
                     
                     $("#msg_edit_treat_name").html("Already Treatment Name Assigned This ID").css('color','gray');
                     $("#edit_treat_name").css('border','1px solid #ccc');
                     $("#btn_treat_update").prop('disabled', false);
                      $("#edit_treat_desc").prop('disabled', false);

                  }
                  else if(res==1)
                  {
                      
                     $("#msg_edit_treat_name").html("Treatment Name Already Taken. Please  Try Again").css('color','red');
                     $("#edit_treat_name").css('border-color','red');
                      $("#btn_treat_update").prop('disabled', true);
                      $("#edit_treat_desc").prop('disabled', true);
                  }
                  else if(res==2)
                  {
                   
                     $("#msg_edit_treat_name").html("Treatment Name Available").css('color','green');
                     $("#edit_treat_name").css('border-color','green');
                      $("#btn_treat_update").prop('disabled', false);
                      $("#edit_treat_desc").prop('disabled', false);

                  }
                    else if(res==3)
                  {
                      
                     $("#msg_edit_treat_name").html("Treatment Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_treat_name").css('border-color','red');
                      $("#btn_treat_update").prop('disabled', true);
                      $("#edit_treat_desc").prop('disabled', true);
                  }

                  

                }

      });
   }
   else
   {
     $("#edit_treat_name").css('border','1px solid #ccc');
     $("#msg_edit_treat_name").html("");
     $("#btn_treat_update").prop('disabled', false);
     $("#edit_treat_desc").prop('disabled', false);

   }



}
function editTreatDesc(){


var  desc=$("#edit_treat_desc").val();
var id=$("#edit").val();

   if(desc.length>0 )
   {
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/treatment-desc-exist-edit/"+id+"/"+desc,
           dataType  : "Json",
          
           success:function(res){
                     
                     console.log(res);
                    
                     if(res==0)
                  {
                     
                     $("#msg_edit_treat_desc").html("Already Description Name Assigned This ID").css('color','gray');
                     $("#edit_treat_desc").css('border','1px solid #ccc');
                      $("#btn_treat_update").prop('disabled', false);
                      $("#edit_treat_name").prop('disabled', false);

                  }
                  else if(res==1)
                  {
                      
                     $("#msg_edit_treat_desc").html("Description Name Already Taken. Please Try Again").css('color','red');
                     $("#edit_treat_desc").css('border-color','red');
                     $("#btn_treat_update").prop('disabled', true);
                      $("#edit_treat_name").prop('disabled', true);
                      
                  }
                  else if(res==2)
                  {
                   
                     $("#msg_edit_treat_desc").html("Description Name Available").css('color','green');
                     $("#edit_treat_desc").css('border-color','green');
                      $("#btn_treat_update").prop('disabled', false);
                      $("#edit_treat_name").prop('disabled', false);
                      
                      }
                      else if(res==3)
                  {
                      
                     $("#msg_edit_treat_desc").html("Description Name  has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_treat_desc").css('border-color','red');
                     $("#btn_treat_update").prop('disabled', true);
                      $("#edit_treat_name").prop('disabled', true);
                      
                  }

                  

                }

      });
   }
   else
   {
                      $("#edit_treat_desc").css('border','1px solid #ccc');
                      $("#msg_edit_treat_desc").html("");
                      $("#btn_treat_update").prop('disabled', false);
                      $("#edit_treat_name").prop('disabled', false);
                      
   }

}

$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
 $(".errors").delay('3000').fadeOut();
  
})



   </script>

@endsection
@endsection