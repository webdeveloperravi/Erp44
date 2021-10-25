@extends('layouts.admin.app')
@section('content')
@php  use Illuminate\Support\Str; @endphp
<div class="container">

				@if ($errors->any())
    <div class="alert alert-danger  alert-dismissible">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Shape Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>  
                <div class="card-body">

				


				<form method="POST" action="{{ route('shape.store') }}" enctype="multipart/form-data">
				    @csrf
              <span id="msg_error">&nbsp;</span>
				 {{--    <div class="form-group row">
                                 <div class="col-md-4 col-sm-4"></div>
                                 <div class="col-md-6 col-sm-6">
                                 
                                 </div>
                              </div> --}}
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Shape Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="shape" type="text" class="form-control @error('shape') is-invalid @enderror" name="shape" value="{{ old('shape') }}"  autocomplete="clarity" autofocus onblur="checkShapeName()">
                                       <span id="msg_sh_name"></span>
				                @error('shape')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="checkShapeAlias()">
                                     <span id="msg_sh_alias"></span>
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
                        <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sh_desc"></span>
                        
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_shape_saved">
                                   Save
                                </button>
                                <button type="button" class="btn btn-danger" id="btn_shape_close" onclick="$('#new_color').hide()">
                                    close</button>
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit Shape Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">

				

				

				<form method="POST" action="{{ route('shape.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Shape Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
                        
                        <input id="edit_shape_name" type="text" class="form-control @error('shape') is-invalid @enderror" name="shape" value="{{ old('shape') }}"  autocomplete="shape" autofocus onblur="editShapeName()">
                                      <span id="msg_sh_name_ed"></span>
				                @error('shape')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_shape_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="edittShapeAlias()">
                                   <span id="msg_sh_as_ed"></span>
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
                        <textarea id="edit_shape_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_sh_desc_ed"></span>
                        
                    </div>
                </div>
				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_shape_updated">
                                   Update
                                </button>
                                <button type="button" class="btn btn-danger" id="btn_shape_updated_close" onclick="$('#edit_color').hide()">
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
	<button onclick="showForm()" class="btn btn-success"> Add New Shape </button>
    </div>
</div>
    <h2 class="text-left text-info">Shape List</h2>

  <div class='table-responsive'>
<table id="shape_tab_id" class="table table-stripped clarity_table" style="margin-top: 20px;">
      <thead class="bg-primary text-white">
        <tr>
         <th>UID</th>
        <th>Clarity Name</th>
        <th>Alias</th>
        <th>Description</th>
        <th>status</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
         @if($data->count()>0)
      @foreach($data as $ckey => $cval)
      <tr>
      <td>{{$cval->id}}</td>
        <td>{{ $cval->shape  }}</td>
        <td>{{ $cval->alias}}</td>
         <td>{{str::limit($cval->descr,30)}}</td>
        <td class="text-success">{{ ($cval->status==1?"Active":"In-active")}}</td>
        <td> <a href="{{route('shape.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class='btn btn-warning btn-sm p-1' style="width:60px;">{{ ($cval->status==1?"In-active":"Active")}} </a>
          {{-- <a href="{{route('shape.del',['id'=>$cval->id])}}" class="btn btn-danger btn-sm p-1" style="width:60px;" onclick="return confirm('Are You Sure To Delete Clarity')"> Delete</a>   --}}
          <button class="btn btn-sm btn-primary p-1" onclick="edit_color({{$cval->id}} ,'{{$cval->shape}}', '{{$cval->alias}}','{{$cval->descr}}')"style="width:60px;"> edit </button>  

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


   function closeForm()
   {
    $("#new_color").hide();
    $("#edit_color").hide();
   }



  $(document).ready(function(){

$('#shape_tab_id').DataTable();

});
	
$(document).ready(function(){

$("#btn_shape_saved").click(function(){


  
   var name=$("#shape").val();
   var alias=$("#alias").val();
    var desc=$("#desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
        
        $("#shape").css('border','1px solid red');
        $("#msg_sh_name").html("Shape Name field is required").css('color','red');
        $("#msg_sh_alias").html("Shape Alias field is required").css('color','red');
        $("#alias").css('border','1px solid red');
         $("#msg_sh_desc").html("Shape Description field is required").css('color','red');
        $("#desc").css('border','1px solid red');


    
      return false;
   }

   else if (name==="") {
      
      $("#msg_sh_name").html("Shape Name field is required").css('color','red');
      $("#shape").css('border','1px solid red');
      
      
      return false;


   }
   else if(alias==="")
   {
      $("#msg_sh_alias").html("Shape Alias field is required").css('color','red');
      $("#alias").css('border','1px solid red');
      

    return false;
   }
   else if(dsec==="")
   {
      $("#msg_sh_desc").html("Shape Description field is required").css('color','red');
      $("#desc").css('border','1px solid red');
      

    return false;
   }

   else{
    return true;
   }



})

})



// shape name to search from database

function checkShapeName(){


var name=$("#shape").val();

   if(name.length>0)
   {
    
      $.ajax({
                
                method : "GET",
                url : "../admin/shape-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {
                      $("#shape").css('border-color','red');
                      $("#msg_sh_name").html("Shape Name Already Taken. Please Try Again").css('color','red');
                      $("#btn_shape_saved").prop('disabled', true);
                      $("#alias").prop('disabled',true);
                     

                  }
                 else if(data==2)
                  {
                      $("#shape").css('border-color','red');
                      $("#msg_sh_name").html("Shape Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                      $("#btn_shape_saved").prop('disabled', true);
                      $("#alias").prop('disabled',true);
                     

                  }


                  else
                  {
                      $("#shape").css('border-color','green');
                      $("#msg_sh_name").html("Shape Name Available").css('color','green');
                      $("#btn_shape_saved").prop('disabled', false);
                      $("#alias").prop('disabled',false);
                      

                  }

                  

                }

          });
   }
 
   else
   {
      $("#shape").css('border','1px solid #ccc');
   	 $("#btn_shape_saved").prop('disabled', false);
   	 $("#alias").prop('disabled',false);
   	 $("#msg_sh_name").html("");

   }



}

function checkShapeAlias(){

   var alias=$("#alias").val();

   if(alias.length>0)
   {
  
      
   	 $.ajax({
                
                method : "GET",
                url : "../admin/shape-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {
                     $("#alias").css('border-color','red');
                     $("#msg_sh_alias").html("Alias Name Already Taken.Please Try Again").css('color','red');
                      $("#btn_shape_saved").prop('disabled', true);
                      $("#shape").prop('disabled',true);
                     

                  }
                  else  if(data==2)
                  {
                     $("#alias").css('border-color','red');
                     $("#msg_sh_alias").html("Alias Name has been  Already Taken and Deleted.Please Contact Administrator").css('color','red');
                      $("#btn_shape_saved").prop('disabled', true);
                      $("#shape").prop('disabled',true);
                     

                  }
                  else
                  {
                     $("#alias").css('border-color','green');
                     $("#msg_sh_alias").html("Alias Name Available").css('color','green');
                     $("#btn_shape_saved").prop('disabled', false);
                      $("#shape").prop('disabled',false);
                    
                      
                  }

                  

                }

          });
   }
   else
   {
      $("#alias").css('border','1px solid #ccc');
  	 $("#btn_shape_saved").prop('disabled', false);
   	 $("#shape").prop('disabled',false);
   	 $("#msg_sh_alias").html("");

   }


}

$(document).ready(function(event){

 $("#btn_shape_updated").click(function(){

  var name=$("#edit_shape_name").val();
   var alias=$("#edit_shape_alias").val();
   var desc=$("#edit_shape_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
        
        $("#edit_shape_name").css('border','1px solid red');
        $("#msg_sh_name_ed").html("Shape Name field is required").css('color','red');
        $("#msg_sh_as_ed").html("Shape Alias field is required").css('color','red');
        $("#edit_shape_alias").css('border','1px solid red');
         $("#msg_sh_desc_ed").html("Shape Description field is required").css('color','red');
        $("#edit_shape_desc").css('border','1px solid red');


    
      return false;
   }

   else if (name==="") {
      
      $("#msg_sh_name_ed").html("Shape Name field is required").css('color','red');
      $("#edit_shape_name").css('border','1px solid red');
      
      
      return false;


   }
   else if(alias==="")
   {
      $("#msg_sh_as_ed").html("Shape Alias field is required").css('color','red');
      $("#edit_shape_alias").css('border','1px solid red');
      

    return false;
   }
   else if(desc==="")
   {
      $("#msg_sh_desc_ed").html("Shape Description field is required").css('color','red');
      $("#edit_shape_desc").css('border','1px solid red');
      

    return false;
   }

   else{
    return true;
   }






 })



	
})

// edit shape name to search data  from database
function editShapeName(){

var name=$("#edit_shape_name").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
      
          $.ajax({
                
                method : "GET",
                url : "../admin/shape-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                    
                     $("#edit_shape_name").css('border','1px solid #ccc');
                     $("#msg_sh_name_ed").html("Before assigned Shape Name this id").css('color','gray');
                     $("#btn_shape_updated").prop('disabled',false);
                     $("#edit_shape_alias").prop('disabled',false);
                    

                  }
                  else if(data==1)
                  {
                     $("#edit_shape_name").css('border','1px solid red');
                     $("#msg_sh_name_ed").html("Shape Name Already Taken then Please Try Again").css('color','red');
                     $("#btn_shape_updated").prop('disabled',true);
                     $("#edit_shape_alias").prop('disabled',true);
                    
                  }
                  else if(data==2)
                  {
                   $("#edit_shape_name").css('border-color','green');
                   $("#msg_sh_name_ed").html("Shape Name Available").css('color','green');
                   $("#btn_shape_updated").prop('disabled',false);
                   $("#edit_shape_alias").prop('disabled',false);
                  
                  }
                   else if(data==3)
                  {
                     $("#edit_shape_name").css('border','1px solid red');
                     $("#msg_sh_name_ed").html("Shape Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_shape_updated").prop('disabled',true);
                     $("#edit_shape_alias").prop('disabled',true);
                    
                  }


                  

                }

          });

   }
  else
     {
         $("#edit_shape_name").css('border','1px solid #ccc');
     	  
      	$("#msg_sh_name_ed").html("");
        $("#btn_shape_updated").prop('disabled',false);
         $("#edit_shape_alias").prop('disabled',false);
     }


}

// edit shape alias to search data  from database
function edittShapeAlias(){

 var name=$("#edit_shape_alias").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
      
          $.ajax({
                
                method : "GET",
                url : "../admin/shape-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                    
                     $("#edit_shape_alias").css('border','1px solid #ccc');
                     $("#msg_sh_as_ed").html("Before assigned Shape Alias Name this id").css('color','gray');;
                     $("#btn_shape_updated").prop('disabled',false);
                     $("#edit_shape_name").prop('disabled',false);
                    
                  }
                  else if(data==1)
                  {
                     
                     $("#edit_shape_alias").css('border-color','red');
                     $("#msg_sh_as_ed").html("Shape Alias Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_shape_updated").prop('disabled',true);
                     $("#edit_shape_name").prop('disabled',true);
                    
                
                  }
                  else if(data==2)
                  {
                    $("#edit_shape_alias").css('border-color','green');
                     $("#msg_sh_as_ed").html("Sahpe Alias Name Available").css('color','green');
                     $("#btn_shape_updated").prop('disabled',false);
                     $("#edit_shape_name").prop('disabled',false);
                    
              
                  }
                   else if(data==3)
                  {
                     
                     $("#edit_shape_alias").css('border-color','red');
                     $("#msg_sh_as_ed").html("Shape Alias Name has been Already Taken and Deleted. Please Contact Administrator.").css('color','red');
                     $("#btn_shape_updated").prop('disabled',true);
                     $("#edit_shape_name").prop('disabled',true);
                    
                
                  }


                  

                }

          });

   }
   else
   {
       $("#edit_shape_alias").css('border','1px solid #ccc');
     	 $("#msg_sh_as_ed").html("");
       $("#btn_shape_updated").prop('disabled',false);
       $("#edit_shape_name").prop('disabled',false);

   }




}




$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
 $(".errors").delay('3000').fadeOut();
 
})



</script>

@endsection


@endsection
