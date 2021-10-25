@extends('layouts.admin.app')
@section('content')
<div class="container">
       
        				@if ($errors->any())
    <div class="alert alert-danger lert-dismissible">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Grade Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">

				


				<form method="POST" action="{{ route('grade.store') }}" enctype="multipart/form-data">
				    @csrf
              <span id="msg_error">&nbsp;</span>
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Grade Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="grade_name" type="text" class="form-control @error('grade') is-invalid @enderror" name="grade" value="{{ old('grade') }}"  autocomplete="clarity" autofocus onblur="checkGradeName()">
                                  <span id="msg_gr_name"></span>
				                @error('grade')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="grade_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="checkGradeAlias()">
                                      <span id="msg_gr_alias"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

                 <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <input id="grade_desc" type="text" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name" autofocus>
                                      <span id="msg_gr_desc"></span>
                        @error('alias')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return gradeValidation()" id="btn_grade_saved">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit Grade Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">

				
				

				<form method="POST" action="{{ route('grade.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Grade Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_grade_name" type="text" class="form-control @error('grade') is-invalid @enderror" name="grade" value="{{ old('grade') }}"  autocomplete="grade" autofocus onblur="editGradeName()">
                                    <span id="msg_gr_ed"></span>
				                @error('grade')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary
				            ">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_grade_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editGradeAlias()">
                              <span id="msg_as_ed"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
                      

                      <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary
                    ">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <input id="edit_grade_desc" type="text" class="form-control @error('alias') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editGradeAlias()">
                              <span id="msg_desc_ed"></span>
                        @error('alias')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_grade_updated">
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
	<button class="btn btn-success" id="new_rate" data-toggle="modal" data-target="#grade_modal" data-whatever="@getbootstrap" onclick="showForm()">Add New Grade</button>
    </div>
</div>
    <h2 class="text-left text-info">Grade List</h2>
    
    <!---Heading---->
    <div class="row">
       <div class="col-12 col-sm-1 col-md-1 font-weight-bold ">UID</div>
         <div class="col-12 col-sm-2 col-md-2 font-weight-bold ">Name</div>
         <div class="col-12 col-sm-1 col-md-1 font-weight-bold ">Alias</div>
         <div class="col-12 col-sm-6 col-md-5 font-weight-bold ">Description</div>
         <div class="col-12 col-sm-3 col-md-2  font-weight-bold text-center">Action</div> 
      </div>  
 

<ul  id="sortable1" class="list-group list-group-flush"  onmousemove="parentSort1('sortable1')">
     @foreach($data->sortBy('parent_sort') as $data_key =>$data_val)
    
     <li class="list-group-item m-b-10 m-t-10 z-depth-0" id="parent_id_{{$data_val->id}}">
      <div class="row">
      <div class="col-12 col-sm-1 col-md-1 font-weight-bold">{{ $data_val->id }}</div>
      <div class="col-12 col-sm-2 col-md 2">{{ $data_val->grade }}</div>
      <div class="col-12 col-sm-1 col-md-1 ">{{ $data_val->alias }}</div>
      <div class="col-12 col-sm-6 col-md-5">{{ $data_val->descr }}</div>
      <div class="col-12 col-sm-2 col-md-3 ">
     <button class="btn btn-sm btn-primary p-1 float-right m-r-10" style="width:60px;" onclick="edit_color({{$data_val->id}},'{{$data_val->grade}}','{{$data_val->alias}}',`{{ $data_val->descr}}`)"> edit </button>  
     @if($data_val->status==1) 
     <a href="{{route('grade.status',['id'=>$data_val->id,'status'=>$data_val->status])}}" class="btn btn-warning btn-sm p-1 float-right m-r-10" style="width:60px;"> Disable</a>
     @else
     <a href="{{route('grade.status',['id'=>$data_val->id,'status'=>$data_val->status])}}" class="btn btn-success btn-sm p-1 float-right m-r-10" style="width:60px;"> Enable</a>
     @endif
     {{-- <a href="{{route('grade.del',['id'=>$data_val->id])}}" class="btn btn-danger btn-sm p-1 float-right m-r-10" style="width:60px;" onclick="return confirm('Are You Sure To Delete Menu Item')"> Delete</a>
          --}}
      </div>
    </div>
       </li>
      @endforeach
  
    </ul>
</div>

@section('script')

<script type="text/javascript">
	
$(document).ready(function(){

$("#grade_table").DataTable();

});

function closeForm(){
  $("#new_color").hide();
  $("#edit_color").hide();
}

// save Validation

function gradeValidation(){
   
   
   var name=$("#grade_name").val();
   var alias=$("#grade_alias").val();
   var desc=$("#grade_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
   
   
       
        $("#grade_name").css('border','1px solid red');
        $("#msg_gr_name").html("Grade Name field is required").css('color','red');
        $("#msg_gr_alias").html("Grade Alias field is required").css('color','red');
       $("#grade_alias").css('border','1px solid red');
        $("#grade_desc").css('border','1px solid red');
      $("#msg_gr_desc").html("Description field is required").css('color','red');


      return false;
   }

   else if (name==="") {
      
        $("#grade_name").css('border','1px solid red');
      $("#msg_gr_name").html("Grade Name field is required").css('color','red');
      
      return false;


   }
   else if(alias==="")
   {
       $("#grade_alias").css('border','1px solid red');
      $("#msg_gr_alias").html("Grade Alias field is required").css('color','red');
     

    return false;
   }
   else if(desc==="")
   {
       $("#grade_desc").css('border','1px solid red');
      $("#msg_gr_desc").html("Description field is required").css('color','red');
     

    return false;
   }

   else{
    return true;
   }


}

// to search grade name 


function checkGradeName(){

var name=$("#grade_name").val();

   if(name.length>0)
   {
     
       $("#msg_gr_name").html(" ");
   	    $.ajax({
               
                method : "GET",
                url : "../admin/grade-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     
                     var data=res;
                     
                  if(data==1)
                  {
                      $("#grade_name").css('border-color','red');
                     $("#msg_gr_name").html("Grade Name Already Taken.Please Try Again").css('color','red');
                      $("#btn_grade_saved").prop('disabled', true);
                      $("#grade_alias").prop('disabled',true);
                      
                
                  }
                else if(data==2)
                  {
                    $("#grade_name").css('border-color','red');
                     $("#msg_gr_name").html("Grade Name has been Already Taken and Deleted.Please Contact Administrator").css('color','red');
                      $("#btn_grade_saved").prop('disabled', true);
                      $("#grade_alias").prop('disabled',true);
                      
                
                  }

                  else
                  {
                      $("#grade_name").css('border-color','green');
                      $("#msg_gr_name").html("Grade Name Available").css('color','green');
                      $("#btn_grade_saved").prop('disabled', false);
                      $("#grade_alias").prop('disabled',false);
                    
                
                  }

                  

                }

          });
   }
   else
   {
       $("#grade_name").css('border','1px solid #ccc');
     $("#btn_grade_saved").prop('disabled', false);
   	  $("#grade_alias").prop('disabled',false);
   	   $("#msg_gr_name").html("");
   }


}






// to search grade Alias 

function checkGradeAlias(){

var alias=$("#grade_alias").val();

   if(alias.length>0)
   {
    
       $.ajax({
                
                method : "GET",
                url : "../admin/grade-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {
                     $("#grade_alias").css('border-color','red');
                     $("#msg_gr_alias").html("Alias Name Already Taken Please Try Again").css('color','red');
                      $("#btn_grade_saved").prop('disabled', true);
                      $("#grade_name").prop('disabled',true);
                     

                  }
                   else if(data==2){

                    $("#grade_alias").css('border-color','red');
                     $("#msg_gr_alias").html("Alias Name has been Already Taken and Deleted.Please Contact Administrator").css('color','red');
                      $("#btn_grade_saved").prop('disabled', true);
                      $("#grade_name").prop('disabled',true);
                     

                   }


                  else
                  {
                     $("#grade_alias").css('border-color','green');
                     $("#msg_gr_alias").html("Alias Name Available").css('color','green');
                     $("#btn_grade_saved").prop('disabled', false);
                      $("#grade_name").prop('disabled',false);
                      
                
                  }

                  

                }

          });
   }
   else
   {
     
      $("#grade_alias").css('border','1px solid #ccc');
     $("#btn_grade_saved").prop('disabled', false);
   	 $("#grade_name").prop('disabled',false);
   	 $("#msg_gr_alias").html("");
                
   }

}


// update validation

$(document).ready(function(){

$("#btn_grade_updated").click(function(){

     var name=$("#edit_grade_name").val();
   var alias=$("#edit_grade_alias").val();

     
   if(name==="" && alias==="")
   {
   
   
       
        $("#edit_grade_name").css('border','1px solid red');
        $("#msg_gr_ed").html("Grade Name field is required").css('color','red');
        $("#msg_as_ed").html("Grade Alias field is required").css('color','red');
       $("#edit_grade_alias").css('border','1px solid red');


      return false;
   }

   else if (name==="") {
      
        $("#edit_grade_name").css('border','1px solid red');
      $("#msg_gr_ed").html("Grade Name field is required").css('color','red');
      
      return false;


   }
   else if(alias==="")
   {
       $("#edit_grade_alias").css('border','1px solid red');
      $("#msg_as_ed").html("Grade Alias field is required").css('color','red');
     

    return false;
   }

   else{
    return true;
   }

})

})

// to search Edit  Grade Name from database

function editGradeName()
{

 
   var name=$("#edit_grade_name").val();
   var id=$("#edit").val();

   if(name.length>0)
   {
      
      
        $.ajax({
                
                method : "GET",
                url : "../admin/grade-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                      $("#edit_grade_name").css('border','1px solid #ccc');
                      $("#msg_gr_ed").html("Before assigned Grade Name this id").css('color','gray');
                      $("#btn_grade_updated").prop('disabled',false);
                       $("#edit_grade_alias").prop('disabled',false);
                    
                  }
                  else if(data==1)
                  {
                     $("#edit_grade_name").css('border-color','red');
                     $("#msg_gr_ed").html("Grade Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_grade_updated").prop('disabled',true);
                     $("#edit_grade_alias").prop('disabled',true);
                     
                  }
                  else if(data==2)
                  {
                   $("#edit_grade_name").css('border-color','green');
                     $("#msg_gr_ed").html("Grade Name Available").css('color','green');
                     $("#btn_grade_updated").prop('disabled',false);
                       $("#edit_grade_alias").prop('disabled',false);
                     

                  }

                  else if(data==3)
                  {
                     $("#edit_grade_name").css('border-color','red');
                     $("#msg_gr_ed").html("Grade Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_grade_updated").prop('disabled',true);
                     $("#edit_grade_alias").prop('disabled',true);
                     
                  }

                  

                }

          });
   }

   else
   {
       $("#edit_grade_name").css('border','1px solid #ccc');
     	  $("#msg_gr_ed").html("");  
        $("#btn_grade_updated").prop('disabled',false);
        $("#edit_grade_alias").prop('disabled',false);
   }

}


// to search edit Grade alias from database

function editGradeAlias()
{

 var alias=$("#edit_grade_alias").val();
   var id=$("#edit").val();

   if(alias.length>0)
   {
       
       
      
        $.ajax({
                
                method : "GET",
                url : "../admin/grade-alias-exist-edit/"+id+"/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                    
                     $("#edit_grade_alias").css('border','1px solid #ccc');
                      $("#msg_as_ed").html("Before assigned Grade Name this id").css('color','gray');
                      $("#btn_grade_updated").prop('disabled',false);
                       $("#edit_grade_name").prop('disabled',false);
                     

                  }
                  else if(data==1)
                  {
                     $("#edit_grade_alias").css('border-color','red');
                     $("#msg_as_ed").html("Grade Alias Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_grade_updated").prop('disabled',true);
                     $("#edit_grade_name").prop('disabled',true);
                     
                
                  }
                  else if(data==2)
                  {
                   $("#edit_grade_alias").css('border-color','green');
                    $("#msg_as_ed").html(" Grade Alias Name Available").css('color','green');
                    $("#btn_grade_updated").prop('disabled',false);
                     $("#edit_grade_name").prop('disabled',false);
                     

                  }

                  else if(data==3)
                  {
                     $("#edit_grade_alias").css('border-color','red');
                     $("#msg_as_ed").html("Grade Alias Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_grade_updated").prop('disabled',true);
                     $("#edit_grade_name").prop('disabled',true);
                     
                
                  }

                  

                }

          });
   }
   else
   {
     $("#edit_grade_alias").css('border','1px solid #ccc');
   	 $("#btn_grade_updated").prop('disabled',false);
     $("#edit_grade_name").prop('disabled',false);
      $("#msg_as_ed").html("");

   }


}

$(document).ready(function(){

  $(".alert-success").delay('3000').fadeOut();
   $(".erros").delay('3000').fadeOut();

})


function parentSort1(value){

$( "#"+value ).sortable({

       axis : 'y',
      cursor: "move",
       update : function(){

        var data1=$(this).sortable("serialize");
        
         $.ajax({
        
               url : "./grade-parentsort",
               type : "GET",

               dataType:"json",
               data:data1,

             success : function(res)
             {
                // alert("updated parent sort");
              
                   setTimeout(function () {
        //alert('Reloading Page');
        location.reload(true);
      }, 2000);


             }

         });

       }


    });


}

</script>


@endsection

@endsection
