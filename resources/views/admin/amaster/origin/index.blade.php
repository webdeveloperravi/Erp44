@extends('layouts.admin.app')
@section('content')
@php  use Illuminate\Support\Str; @endphp;
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
              
                <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
                    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Origin</h5>
                    </div> 


                <div class="card-body">
       <form method="POST" action="{{ route('origin.store') }}" enctype="multipart/form-data">
				    @csrf
				    <div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Origin Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="origin" type="text" class="form-control @error('origin') is-invalid @enderror" name="origin" value="{{ old('origin') }}"  autocomplete="clarity" autofocus onblur="checkOriginName()">
                                  <span id="msg_origin_name"></span>
				                @error('origin')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="origin_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="checkOriginAlias()">
                                     <span id="msg_origin_alias"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

                  <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Origin Code </label>
                    <div class="col-md-6">
                        <input id="origin_code" type="text" class="form-control @error('origin_code') is-invalid @enderror" name="origin_code" value="{{ old('origin_code') }}"  autocomplete="name" autofocus>
                                     <span id="msg_origin_code"></span>
                        @error('origin_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="origin-desc" name="desc" class="form-control" cols="20" rows="5"></textarea> 
                        <span id="msg_origin_desc"></span>
                        
                    </div>
                </div>


				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return originValidation()"  id="btn_origin_saved">
                                   Save
                                </button>
                                <button type="button" class="btn btn-danger" onclick="$('#new_color').hide()">
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
                 
                 
                    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
                        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Origin</h5>
                        </div> 
                <div class="card-body">


				
				

				<form method="POST" action="{{ route('origin.update') }}" enctype="multipart/form-data" >
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">origin Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_origin" type="text" class="form-control @error('origin') is-invalid @enderror" name="origin" value="{{ old('origin') }}"  autocomplete="origin" autofocus onblur="editOriginName()">
                                <span id="msg_or_name_ed"></span>
				                @error('origin')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_origin_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editOriginAlias()">
                                 <span id="msg_or_as_ed"></span>
				                @error('alias')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

                <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Origin Code </label>
                    <div class="col-md-6">
                        <input id="edit_origin_code" type="text" class="form-control @error('origin_code') is-invalid @enderror" name="origin_code" value="{{ old('origin_code') }}"  autocomplete="name" autofocus>
                                 <span id="msg_or_code_ed"></span>
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
                        <textarea id="edit_origin_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_or_desc_ed"></span>
                        
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_origin_updated">
                                   Update
                                </button>
                                <button type="button" class="btn btn-danger" onclick="$('#edit_color').hide()">
                                   Close
                                </button>
                            </div>
                        </div>
				 </form>
				</div>
			</div>
		</div>
    </div> 
    <div class="row"> 
        <div class="col">
           <button class="btn btn-dark float-right mb-3" onclick="showForm()">Create Origin</button>
         </div>
     </div> 
<div class="card">
    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Origins</h5>
    </div> 
  <div class="card-body">
<div class='table-responsive'>
	<table id="origin_table" class="display table table-stripped" cellspacing="0" width="100%" style="margin-top: 20px;">  
      <thead class="bg-primary text-white">
		<tr>
	       <th>UID</th>
				<th>Origin Name</th>
				<th>Alias</th>
               <th>Origin Code</th>
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
				<td>{{strtoupper($cval->origin) }}</td>
				<td>{{strtoupper($cval->alias)}}</td>
        <td>{{strtoupper($cval->origin_code)}}</td>
        <td>{{str::limit($cval->descr,30)}}</td> 
        <td>
        @if ($cval->status == 1)
        <a href="{{route('origin.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class="btn btn-sm btn-warning p-1"style="width:60px;">Disable</a>  
        @else
        <a href="{{route('origin.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class="btn btn-sm btn-success p-1"style="width:60px;">Enable</a> 
        @endif
        </td>
				<td> 
					
					<button onclick="edit_color({{$cval->id}} , '{{$cval->origin}}', '{{$cval->alias}}','{{$cval->descr}}','{{$cval->origin_code}}')" class="btn btn-sm btn-info p-1" style="width:60px;"> edit </button>  

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
</div>
</div>


@section('script')

<script type="text/javascript">
	
$(document).ready(function(){

$("#origin_table").DataTable();

});

function closeForm1()
{
    alert('ddd');
  $("#new_color").hide();
  $("#edit_color").hide();
}

function originValidation(){
   
  
   
   var name=$("#origin").val();
   var alias=$("#origin_alias").val();
   var desc=$("#origin-desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
        $("#origin").css('border','1px solid red');
        $("#msg_origin_name").html("Origin Name field is required").css('color','red');
        $("#msg_origin_alias").html("Origin Alias field is required").css('color','red');
       $("#origin_alias").css('border','1px solid red');
       $("#msg_origin_desc").html("Origin desc field is required").css('color','red');
       $("#origin-desc").css('border','1px solid red');



    
      return false;
   }

   else if (name==="") {
      
      $("#msg_origin_name").html("Origin Name field is required").css('color','red');
      $("#origin").css('border','1px solid red');
      
      return false;


   }
   else if(alias==="")
   {
      
      $("#msg_origin_alias").html("Origin Alias field is required").css('color','red');
       $("#origin_alias").css('border','1px solid red');

     

    return false;
   }
   else if(desc==="")
   {
      
      $("#msg_origin_desc").html("Origin desc field is required").css('color','red');
       $("#origin-desc").css('border','1px solid red');

     

    return false;
   }

   else{
    return true;
   }


}

function checkOriginName()
{

var name=$("#origin").val();

   if(name.length>0)
   {
    
   	  $.ajax({
                
                method : "GET",
                url : "../admin/origin-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data==1)
                  {

                      $("#origin").css('border-color','red');
                     $("#msg_origin_name").html("Origin Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_origin_saved").prop('disabled', true);
                      $("#origin_alias").prop('disabled',true);
                   
                
                  }

                  else  if(data==2)
                  {

                      $("#origin").css('border-color','red');
                     $("#msg_origin_name").html("Origin Name has been Already Taken and Deleted. Please Contact Administrator.").css('color','red');
                     $("#btn_origin_saved").prop('disabled', true);
                      $("#origin_alias").prop('disabled',true);
                   
                
                  }
                  else
                  {

                      $("#origin").css('border-color','green');
                      $("#msg_origin_name").html("Origin Name Available").css('color','green');
                       $("#btn_origin_saved").prop('disabled', false);
                      $("#origin_alias").prop('disabled',false);
                     
                  }

                  

                }

          });
   

}
            else
            {         $("#origin").css('border','1px solid #ccc');
	                    $("#btn_origin_saved").prop('disabled', false);
                      $("#origin_alias").prop('disabled',false);
                      $("#msg_origin_name").html("");
                
              }

}

function checkOriginAlias()
{

   var alias=$("#origin_alias").val();

   if(alias.length>0)
   {
   
   	$.ajax({
                
                method : "GET",
                url : "../admin/origin-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                     
                    
                     var data=res;
                     
                  if(data==1)
                  {
                     $("#origin_alias").css('border-color','red');
                     $("#msg_origin_alias").html("Origin Alias Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_origin_saved").prop('disabled', true);
                      $("#origin").prop('disabled',true);
                     
                  }
                  else  if(data==2)
                  {
                     $("#origin_alias").css('border-color','red');
                     $("#msg_origin_alias").html("Origin Alias Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_origin_saved").prop('disabled', true);
                      $("#origin").prop('disabled',true);
                     
                  
                  

                  }
                  else
                  {
                     $("#origin_alias").css('border-color','green');
                     $("#msg_origin_alias").html("Origin Alias Name Available").css('color','green');
                     $("#btn_origin_saved").prop('disabled', false);
                      $("#origin").prop('disabled',false);
                     
                
                  }

                  

                }

          });

   }

   else
   { 
      $("#origin_alias").css('border','1px solid #ccc');
   	 $("#btn_origin_saved").prop('disabled', false);
   	  $("#origin").prop('disabled',false);
   	   $("#msg_origin_alias").html("");
   }



}

// update validation

$(document).ready(function(){

$("#btn_origin_updated").click(function(event){

  var name=$("#edit_origin").val();
   var alias=$("#edit_origin_alias").val();
   var desc=$("#edit_origin_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {
       
        $("#edit_origin").css('border','1px solid red');
        $("#msg_or_name_ed").html("Origin Name field is required").css('color','red');
        $("#msg_or_as_ed").html("Origin Alias field is required").css('color','red');
       $("#edit_origin_alias").css('border','1px solid red');
       $("#msg_or_desc_ed").html("Origin Desc field is required").css('color','red');
       $("#edit_origin_desc").css('border','1px solid red');



    
      return false;
   }

   else if (name==="") {
      
      $("#msg_or_name_ed").html("Origin Name field is required").css('color','red');
      $("#edit_origin").css('border','1px solid red');
      
      return false;


   }
   else if(alias==="")
   {
      
      $("#msg_or_as_ed").html("Origin Alias field is required").css('color','red');
       $("#edit_origin_alias").css('border','1px solid red');

     

    return false;
   }

   else if(desc===""){
    $("#msg_or_desc_ed").html("Origin Desc field is required").css('color','red');
       $("#edit_origin_desc").css('border','1px solid red');

   }

   else{
    return true;
   }





event.preventDefault();
})

})

function editOriginName()
{
  
    var name=$("#edit_origin").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
          $.ajax({
                
                method : "GET",
                url : "../admin/origin-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                    
                     $("#edit_origin").css('border','1px solid #ccc');
                      $("#msg_or_name_ed").html("Before assigned Origin Name this id").css('color','gray');
                      $("#btn_origin_updated").prop('disabled',false);
                      $("#edit_origin_alias").prop('disabled',false);
                     

                  }
                  else if(data==1)
                  {
                     $("#edit_origin").css('border-color','red');
                     $("#msg_or_name_ed").html("Origin Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_origin_updated").prop('disabled',true);
                     $("#edit_origin_alias").prop('disabled',true);
                    
                

                  }
                  else if(data==2)
                  {
                     $("#edit_origin").css('border-color','green');
                     $("#msg_or_name_ed").html("Origin Name Available").css('color','green');
                     $("#btn_origin_updated").prop('disabled',false);
                     $("#edit_origin_alias").prop('disabled',false);
                   
                
                  }

                   else if(data==3)
                  {
                     $("#edit_origin").css('border-color','red');
                     $("#msg_or_name_ed").html("Origin Name has been  Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_origin_updated").prop('disabled',true);
                     $("#edit_origin_alias").prop('disabled',true);
                    
                

                  }

                  

                }

          });

   }
   else
   {                  $("#edit_origin").css('border','1px solid #ccc');
   	                  $("#btn_origin_updated").prop('disabled',false);
                     $("#edit_origin_alias").prop('disabled',false);
                     $("#msg_or_name_ed").html("");
                     
                

   }


}

function editOriginAlias(){

    var alias=$("#edit_origin_alias").val();
     var id=$("#edit").val();
   if(alias.length>0)
   {
      
          $.ajax({
                
                method : "GET",
                url : "../admin/origin-alias-exist-edit/"+id+"/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                      // its check  before assigned name this id

                    
                     $("#edit_origin_alias").css('border','1px solid #ccc');
                      $("#msg_or_as_ed").html("Before assigned Origin Alias this id").css('color','gray');
                     $("#btn_origin_updated").prop('disabled',false);
                     $("#edit_origin").prop('disabled',false);
                     

                  }
                  else if(data==1)
                  {
                     
                      $("#edit_origin_alias").css('border-color','red');
                     $("#msg_or_as_ed").html("Alias Name Already Taken.Please Try Again").css('color','red');
                     $("#btn_origin_updated").prop('disabled',true);
                     $("#edit_origin").prop('disabled',true);
                    

                  }
                  else if(data==2)
                  {
                     $("#edit_origin_alias").css('border-color','green');
                     $("#msg_or_as_ed").html("Alias Name Available").css('color','green');
                     $("#btn_origin_updated").prop('disabled',false);
                     $("#edit_origin").prop('disabled',false);
                     

                  }
                   else if(data==3)
                  {
                     
                      $("#edit_origin_alias").css('border-color','red');
                     $("#msg_or_as_ed").html("Alias Name has been Already Taken and Deleted.Please Contact Administrator").css('color','red');
                     $("#btn_origin_updated").prop('disabled',true);
                     $("#edit_origin").prop('disabled',true);
                    

                  }


                  

                }

          });

   }
   else
   {                 $("#edit_origin_alias").css('border','1px solid #ccc');
   	                 $("#btn_origin_updated").prop('disabled',false);
                     $("#edit_origin_alias").prop('disabled',false);
                    $("#msg_or_as_ed").html("");
                
   }


}

$(document).ready(function(){

  $(".alert-success").delay('3000').fadeOut();
  $(".errors").delay('3000').fadeOut();

});






</script>


@endsection

@endsection
