@extends('layouts.admin.app')
@section('content')

@php  use Illuminate\Support\Str;
  
@endphp

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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Species Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">
			<form method="POST" action="{{ route('species.store') }}" enctype="multipart/form-data">
				    @csrf
              <span id="msg_error">&nbsp;</span>
				 {{--    <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                 	<span id="msg_error">&nbsp;</span>
                                 </div>
                              </div> --}}
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Species Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="specie" type="text" class="form-control @error('species') is-invalid @enderror" name="species" value="{{ old('species') }}"  autocomplete="shape" autofocus  onblur="checkSpecieName()">
                                  <span id="msg_sp_name"></span>
				                @error('species')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="specie_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="clarity" autofocus onblur="checkSpecieAlias()">
                                   <span id="msg_sp_as_name"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
                <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="specie_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sp_desc"></span>
                        
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary"  onclick=" return specieValidation()"  id="btn_specie_saved">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit Species Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">
    <form method="POST" action="{{ route('species.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Species Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_specie" type="text" class="form-control @error('species') is-invalid @enderror" name="species" value="{{ old('species') }}"  autocomplete="species" autofocus onblur="editSpecieName()">
                               <span id="msg_sp_name_ed"></span>
				                @error('species')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_specie_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editSpecieAlias()">
                                   <span id="msg_sp_as_ed"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
                 <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="edit_specie_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sp_desc_ed"></span>
                        
                    </div>
                </div>


				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_specie_updated">
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

	@php


	@endphp

	
     <div class="row float-right">
     <div class="col-md-4">
	<button onclick="showForm()" class="btn btn-success"> Add New Species </button>
    </div>
</div>
    <h2 class="text-left text-info">Species List</h2>
<div class='table-responsive'>
	<table class="display table table-stripped table-bordered" style="margin-top: 20px;" cellspacing="0" width="100%" id="specie_table">  
    <thead class="bg-primary text-white">
		<tr>
				<th>UID</th>
				
				<th>Species Name</th>
				<th>Alias</th>
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
				<td>{{ $cval->species }}</td>
				<td>{{ $cval->alias}}</td>
         <td>{{str::limit($cval->descr,30)}}</td>
				<td>{{ ($cval->status==1?"Active":"In-active")}}</td>
				<td> 
					<a href="{{route('species.status',['id'=>$cval->id , 'status'=>$cval->status])}}"  class='btn btn-warning btn-sm p-1' style="width:60px;">{{ ($cval->status==1?"In-active":"Active")}} </a> 
					{{-- <a href="{{route('species.del',['id'=>$cval->id])}}" class="btn btn-danger btn-sm p-1" style="width:60px;" onclick="return confirm('Are You Sure To Delete Specie')"> Delete</a>   --}}
					<button class="btn btn-sm btn-primary p-1" onclick="edit_color({{$cval->id}} , '{{$cval->species}}', '{{$cval->alias}}','{{$cval->descr}}')" style="width:60px;"> edit </button>  

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
  $("#specie_table").dataTable();
})

function closeForm()
{
  $("#new_color").hide();
   $("#edit_color").hide();
}



// specie validation

function specieValidation(){
    var name=$("#specie").val();
   var alias=$("#specie_alias").val();
    var desc=$("#specie_desc").val();


     
   if(name==="" && alias==="" && desc==="")
   {
   
          $("#specie").css('border','1px solid red');
        $("#msg_sp_name").html("Specie Name field is required").css('color','red');
        $("#msg_sp_as_name").html("Specie Alias field is required").css('color','red');
       $("#specie_alias").css('border','1px solid red');
       $("#msg_sp_desc").html("Specie Description field is required").css('color','red');
       $("#specie_desc").css('border','1px solid red');



      return false;
   }

   else if (name==="") {
      
    
          $("#specie").css('border','1px solid red');
        $("#msg_sp_name").html("Specie Name field is required").css('color','red');
      
      return false;


   }
   else if(alias==="")
   {
      
     $("#msg_sp_as_name").html("Specie Alias field is required").css('color','red');
       $("#specie_alias").css('border','1px solid red');


     

    return false;
   }
   else if(desc==="")
   {
      
     $("#msg_sp_desc").html("Specie Description field is required").css('color','red');
       $("#specie_desc").css('border','1px solid red');


     

    return false;
   }


   else{
    return true;
   }

}

// to search specie name from database

function checkSpecieName()
{
   var name=$("#specie").val();

   if(name.length>0)
   {
  
   	  $.ajax({
                
                method : "GET",
                url : "../admin/species-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {
                      $("#specie").css('border-color','red');
                      $("#msg_sp_name").html("Species Name Already Taken. Please Try Again").css('color','red');
                       $("#btn_specie_saved").prop('disabled', true);
   	                   $("#specie_alias").prop('disabled',true);
   	                   
                  }
                else 
                  if(data==2)
                  {
                      $("#specie").css('border-color','red');
                      $("#msg_sp_name").html("Species Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                       $("#btn_specie_saved").prop('disabled', true);
                       $("#specie_alias").prop('disabled',true);
                       
                  }

                  else
                  {
                      $("#specie").css('border-color','green');
                      $("#msg_sp_name").html("Species Name Available").css('color','green');
                       $("#btn_specie_saved").prop('disabled', false);
   	                   $("#specie_alias").prop('disabled',false);
   	                   
            
                  }

                  

                }

          });
   }
   else
   {
       $("#specie").css('border','1px solid #ccc');
      $("#btn_specie_saved").prop('disabled', false);
   	  $("#specie_alias").prop('disabled',false);
   	  $("#msg_sp_name").html("");
   }


}

//to search specie alias name from dataabase

function checkSpecieAlias()
{
  
    var alias=$("#specie_alias").val();

   if(alias.length>0)
   {
     
   	 $.ajax({
                
                method : "GET",
                url : "../admin/species-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {
                     $("#specie_alias").css('border-color','red');
                     $("#msg_sp_as_name").html("Species Alias Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_specie_saved").prop('disabled', true);
                     $("#specie").prop('disabled',true);
                    
                
                  }
                else if(data==2)
                  {
                     $("#specie_alias").css('border-color','red');
                     $("#msg_sp_as_name").html("Species Alias  Name has been  Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_specie_saved").prop('disabled', true);
                     $("#specie").prop('disabled',true);
                    
                
                  }

                  else
                  {
                     $("#specie_alias").css('border-color','green');
                     $("#msg_sp_as_name").html("Specie Alias Name Available").css('color','green');
                     $("#btn_specie_saved").prop('disabled', false);
                     $("#specie").prop('disabled',false);
                     
                
                  }

                  

                }

          });
   }
   else

   {
     $("#specie_alias").css('border','1px solid #ccc');
     $("#btn_specie_saved").prop('disabled', false);
     $("#specie").prop('disabled',false);
      $("#msg_sp_as_name").html("");
                
   }

}



// update validation
$(document).ready(function(){

$("#btn_specie_updated").click(function(event){
 
  var name=$("#edit_specie").val();
  var alias=$("#edit_specie_alias").val();
  var desc=$("#edit_specie_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
   
          $("#edit_specie").css('border','1px solid red');
        $("#msg_sp_name_ed").html("Specie Name field is required").css('color','red');
        $("#msg_sp_as_ed").html("Specie Alias field is required").css('color','red');
       $("#edit_specie_alias").css('border','1px solid red');
       $("#msg_sp_desc_ed").html("Specie Description field is required").css('color','red');
       $("#edit_specie_desc").css('border','1px solid red');


      return false;
   }

   else if (name==="") {
      
    
          $("#edit_specie").css('border','1px solid red');
        $("#msg_sp_name_ed").html("Specie Name field is required").css('color','red');
      
      return false;


   }
   else if(alias==="")
   {
      
     $("#msg_sp_as_ed").html("Specie Alias field is required").css('color','red');
       $("#edit_specie_alias").css('border','1px solid red');


     

    return false;
   }
   else if(desc==="")
   {
      
     $("#msg_sp_desc_ed").html("Specie Description field is required").css('color','red');
       $("#edit_specie_desc").css('border','1px solid red');


     

    return false;
   }

   else{
    return true;
   }

event.preventDefault();
})


})

function editSpecieName(){

    var name=$("#edit_specie").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
     
          $.ajax({
                
                method : "GET",
                url : "../admin/species-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                    
                     $("#edit_specie").css('border','1px solid #ccc');
                      $("#msg_sp_name_ed").html("Before assigned Specie Name this id").css('color','gray');
                      $("#btn_specie_updated").prop('disabled',false);
                       $("#edit_specie_alias").prop('disabled',false);
                       $("#msg_sp_as_ed").html(" ");


                  }
                  else if(data==1)
                  {
                      $("#edit_specie").css('border-color','red');
                     $("#msg_sp_name_ed").html("Specie Name Already Taken. Please Try Again").css('color','red');
                      $("#btn_specie_updated").prop('disabled',true);
                     $("#edit_specie_alias").prop('disabled',true);
                     
                
                  }
                  else if(data==2)
                  {
                     $("#edit_specie").css('border-color','green');
                     $("#msg_sp_name_ed").html("Specie Name Available").css('color','green');
                     $("#btn_specie_updated").prop('disabled',false);
                     $("#edit_specie_alias").prop('disabled',false);
                    
                
                  }
                   else if(data==3)
                  {
                      $("#edit_specie").css('border-color','red');
                     $("#msg_sp_name_ed").html("Specie Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                      $("#btn_specie_updated").prop('disabled',true);
                     $("#edit_specie_alias").prop('disabled',true);
                     
                
                  }

                  

                }

          });

   }
   else

   {  
      $("#edit_specie").css('border','1px solid #ccc');
      $("#btn_specie_updated").prop('disabled',false);
       $("#edit_specie_alias").prop('disabled',false);
        $("#msg_sp_name_ed").html("");
         
                
   }


}

function editSpecieAlias(){

   var name=$("#edit_specie_alias").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
      
          $.ajax({
                
                method : "GET",
                url : "../admin/species-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     
                     $("#edit_specie_alias").css('border','1px solid #ccc');
                      $("#msg_sp_as_ed").html("Before assigned Specie Alias this id").css('color','gray');
                      $("#btn_specie_updated").prop('disabled',false);
                       $("#edit_specie_alias").prop('disabled',false);
                      

                  }
                  else if(data==1)
                  {
                     
                      $("#edit_specie_alias").css('border-color','red');
                     $("#msg_sp_as_ed").html("Alias Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_specie_updated").prop('disabled',true);
                       $("#edit_specie").prop('disabled',true);
                       
                  }
                  else if(data==2)
                  {
                     $("#edit_specie_alias").css('border-color','green');
                     $("#msg_sp_as_ed").html("Alias Name Available").css('color','green');
                      $("#btn_specie_updated").prop('disabled',false);
                       $("#edit_specie").prop('disabled',false);
                       

                  }

                  else if(data==3)
                  {
                     
                      $("#edit_specie_alias").css('border-color','red');
                     $("#msg_sp_as_ed").html("Alias Name has been  Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_specie_updated").prop('disabled',true);
                       $("#edit_specie").prop('disabled',true);
                       
                  }


                  

                }

          });

   }
   else
   {
     $("#edit_specie_alias").css('border','1px solid #ccc');
   	$("#btn_specie_updated").prop('disabled',false);
    $("#edit_specie").prop('disabled',false);
     $("#msg_sp_as_ed").html("");
     
   }



}

$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
 $(".errors").delay('3000').fadeOut();
})


</script>
@endsection
@endsection
