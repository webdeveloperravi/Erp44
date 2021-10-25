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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">New Rate Profile Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div> 
                <div class="card-body">
              <span id="msg_error" class=" text-center">&nbsp;</span>
				

			<form method="POST" action="{{ route('rate.profile.store') }}" enctype="multipart/form-data">
				    @csrf
						<div class="form-group row">
				            <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Profile Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="rate_pro" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus onblur="checkRateProName()">
                                  <span id="msg_rate_pro"></span>
				                @error('name')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="rate_desc" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="name" autofocus onblur="checkDescriptionName()">
                                   <span id="msg_rate_desc"></span>
				                @error('description')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return rateValidation()" id="btn_saved">
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Edit Rate Profile Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">

			
				

				<form method="POST" action="{{ route('rate.profile.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Rate Profile Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="edit_rate_pro" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus onblur="editRateProfileNameExist()">
                                  <span id="msg_rate_pro_edit"></span>
				                @error('name')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="edit_rate_desc" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="name" autofocus onblur="editRateProfileDescExist()">
                                  <span id="msg_rate_desc_edit"></span>
				                @error('description')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary"   id="btn_edit_pro">
                                   update
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
	<button onclick="showForm()" class="btn btn-success"> Add New Rate Profile </button>
    </div>
</div>
    <h2 class="text-left text-info">Rate Profile List</h2>
     <div class="row">
       <div class="col-12 col-sm-1 col-md-1 font-weight-bold ">Sorting Number</div>
        <div class="col-12 col-sm-2 col-md-3 font-weight-bold ">Name</div>
         <div class="col-12 col-sm-6 col-md-4 font-weight-bold ">Description</div>
          <div class="col-12 col-sm-3 col-md-2  font-weight-bold text-center">Action</div> 
      </div>  
<ul  id="sortable1" class="list-group list-group-flush"  onmousemove="parentSort('sortable1')">
       @if($data->isNotEmpty())
     @foreach($data->sortBy('parent_sort') as $data_key =>$data_val)
     <li class="list-group-item m-b-10 m-t-10 z-depth-0" id="parent_id_{{$data_val->id}}">
   <div class="row">
    <div class="col-12 col-sm-1 col-md-1">
  <strong class="float-left m-r-10">{{$data_val->parent_sort}}</strong>
   </div>
    <div class="col-12 col-sm-2 col-md-4">
  <strong class="float-left m-r-10">{{$data_val->name}}</strong>
   </div>
   <div class="col-12 col-sm-2 col-md-7">
  <strong class="float-left m-r-10 font-weight-normal" >{{$data_val->description}}</strong>
   </div>
 
   </div>
      <a href="{{ route('r.w.rate_profile_assign_weight_range',['id'=>$data_val->id]) }}" class="btn btn-success btn-sm p-1 float-right m-r-10" style="width:136px;">Assign Weight & Price</a>
       {{--  </form> --}}
    <button type="button" class="btn btn-sm btn-primary p-1 float-right m-r-10" style="width:60px;" onclick="edit_color({{$data_val->id}},'{{$data_val->name}}',`{{$data_val->description}}`)"> edit </button>
      <a href="{{route('grade.del',['id'=>$data_val->id])}}" class="btn btn-danger btn-sm p-1 float-right m-r-10" style="width:60px;" onclick="return confirm('Are You Sure To Delete Menu Item')"> Delete</a>
       {{--  <a href="{{route('r.w.rate_profile_weight_range_index')}}" class="btn btn-success btn-sm p-1 float-right m-r-10" style="width:136px;">Assign Weight & Price</a> 
        --}}
          <a href="{{route('price.history.store_price_history',$data_val->id)}}" class="btn btn-info btn-sm p-1 float-right m-r-10" style="width:92px;">Price History</a> 
      </li>

      @endforeach

      @else
       <li class="list-group-item m-b-10 m-t-10 z-depth-0">No Recound Found</li>



      @endif
    </ul>
    <div class="m-t-10 float-right m-b-10"> 
   {{-- {{ $data->links() }} --}}
</div>
</div>

@section('script')
<script type="text/javascript">

$(document).ready(function(){

  $("#rate_profile_table").DataTable();
})

function closeForm()
{
  $("#new_color").hide();
   $("#edit_color").hide();
}


function rateValidation() {
	
	 var name=$("#rate_pro").val();
   var alias=$("#rate_desc").val();

     
   if(name==="" && alias==="")
   {
   
    
        $("#rate_pro").css('border','1px solid red');
        $("#msg_rate_pro").html("Rate Profile Name field is required").css('color','red');
        $("#msg_rate_desc").html("Description field is required").css('color','red');
         $("#rate_desc").css('border','1px solid red');

       
      return false;
   }

   else if (name==="") {
       $("#rate_pro").css('border','1px solid red');
      $("#msg_rate_pro").html("Rate Profile Name field is required").css('color','red');
      
      return false;


   }
   else if(alias==="")
   {
      
      $("#msg_rate_desc").html("Rate Profile Description field is required").css('color','red');
        $("#rate_desc").css('border','1px solid red');
     

    return false;
   }

   else{

    return true;
   }

	
}

function checkRateProName(){

var  name=$("#rate_pro").val();

   if(name.length>0 )
   {
      $.ajax({
        
           method : "GET",
           url    : "../admin/rate-profile-name-exist/"+name,
           dataType  : "Json",
           success   : function(res)
           {
           	 if(res==1)
           	 {
           	 	       $("#rate_pro").css('border-color','red');
                     $("#msg_rate_pro").html("Rate Profile Name Already Taken. Please Try Again").css('color','red');
                      $("#btn_saved").prop('disabled',true);
                      $("#rate_desc").prop('disabled',true);
                  
                
           	 }
             else if(res==2){

                     $("#rate_pro").css('border-color','red');
                     $("#msg_rate_pro").html("Rate Profile Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                      $("#btn_saved").prop('disabled',true);
                      $("#rate_desc").prop('disabled',true);
                  

             }
           	 else
           	 {
           	 	       $("#rate_pro").css('border-color','green');
                     $("#msg_rate_pro").html("Rate Profile Name Available").css('color','green');
                      $("#btn_saved").prop('disabled',false);
                      $("#rate_desc").prop('disabled',false);
                     
                
           	 }
           }

      });
   }
   else
   {
                       $("#rate_pro").css('border','1px solid #ccc');
                      $("#btn_saved").prop('disabled',false);
                      $("#rate_desc").prop('disabled',false);
                      $("#msg_rate_pro").html("");
   }
 

}

function checkDescriptionName(){


var  desc=$("#rate_desc").val();

   if(desc.length>0)
   {
    
       
      $.ajax({
        
           method : "GET",
           url    : "../admin/rate-profile-desc-exist/"+desc,
           dataType  : "Json",
           success   : function(res)
           {
           	if(res==1)
           	 {
           	 	       $("#rate_desc").css('border-color','red');
                     $("#msg_rate_desc").html("Rate Profile Description Already Taken. Please Try Again").css('color','red');
                     $("#btn_saved").prop('disabled',true);
                     $("#rate_pro").prop('disabled',true);
                      
                
           	 }
             else if(res==2)
             {
                     $("#rate_desc").css('border-color','red');
                     $("#msg_rate_desc").html("Rate Profile Description has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_saved").prop('disabled',true);
                     $("#rate_pro").prop('disabled',true);
                      
                
             }
           	 else
           	 {
           	 	       $("#rate_desc").css('border-color','green');
                     $("#msg_rate_desc").html("Rate Profile Description Available").css('color','green');
                     $("#btn_saved").prop('disabled',false);
                     $("#rate_pro").prop('disabled',false);
                    
           	 }
           }

      });
   }
  
       else
   { 
                       
                       $("#rate_desc").css('border','1px solid #ccc');
                      $("#btn_saved").prop('disabled',false);
                      $("#rate_pro").prop('disabled',false);
                      $("#msg_rate_desc").html("");
                      
   }
   

	
}

// update validation

$(document).ready(function(){

 $("#btn_edit_pro").click(function()
 {
    var edit_name=$("#edit_rate_pro").val();
    var edit_desc=$("#edit_rate_desc").val();
     
   if(edit_name==="" && edit_desc==="")
   {
   
    
        $("#edit_rate_pro").css('border','1px solid red');
        $("#msg_rate_pro_edit").html("Rate Profile Name field is required").css('color','red');
        $("#msg_rate_desc_edit").html("Rate Profile Description field is required").css('color','red');
         $("#edit_rate_desc").css('border','1px solid red');

       
      return false;
   }

   else if (edit_name==="") {
      
        $("#edit_rate_pro").css('border','1px solid red');
      $("#msg_rate_pro_edit").html("Rate Profile Name field is required").css('color','red');
      
      return false;


   }
    else if(edit_desc==="")
      {
      
      $("#msg_rate_desc_edit").html("Rate Profile Description field is required").css('color','red');
        $("#edit_rate_desc").css('border','1px solid red');
     

    return false;
   }

   else{

    return true;
   }
   


 });

})


function editRateProfileNameExist(){
   
   var edit_name=$("#edit_rate_pro").val();
   var id=$("#edit").val();
   
   if(edit_name.length>0)
   {
   	     
           
         $.ajax({
                
                method : "GET",
                url : "../admin/rate-profile-name-exist-edit/"+id+"/"+edit_name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                    
                     if(res==0)
                  {
                     
                     $("#msg_rate_pro_edit").html("Already Rate Profile Name Assigned This ID").css('color','gray');
                     $("#edit_rate_pro").css('border','1px solid #ccc');
                      $("#btn_edit_pro").prop('disabled', false);
                      $("#edit_rate_desc").prop('disabled',false);
                     

                  }
                  else if(res==1)
                  {
                      
                     $("#msg_rate_pro_edit").html("Rate Profile Name Already Taken. Please Try Again").css('color','red');
                     $("#edit_rate_pro").css('border-color','red');
                      $("#btn_edit_pro").prop('disabled', true);
                      $("#edit_rate_desc").prop('disabled',true);
                   

                  }
                  else if(res==2)
                  {
                   
                     $("#msg_rate_pro_edit").html("Rate Profile Name Available").css('color','green');
                     $("#edit_rate_pro").css('border-color','green');
                      $("#btn_edit_pro").prop('disabled', false);
                      $("#edit_rate_desc").prop('disabled',false);
                     

                  }
                   else if(res==3)
                  {
                      
                     $("#msg_rate_pro_edit").html("Rate Profile Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_rate_pro").css('border-color','red');
                      $("#btn_edit_pro").prop('disabled', true);
                      $("#edit_rate_desc").prop('disabled',true);
                   

                  }

                  

                }

          });
        
        
   }

  else
  {

                      $("#edit_rate_pro").css('border','1px solid #ccc');
                      $("#btn_edit_pro").prop('disabled', false);
                      $("#edit_rate_desc").prop('disabled',false);
                     $("#msg_rate_pro_edit").html("");

  }

}

function editRateProfileDescExist(){

   var edit_desc=$("#edit_rate_desc").val();
   var id=$("#edit").val();
   if(edit_desc.length>0)
   {
   	  

   	        $.ajax({
                
                method : "GET",
                url : "../admin/rate-profile-desc-exist-edit/"+id+"/"+edit_desc,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                    
                     if(res==0)
                  {
                     
                $("#msg_rate_desc_edit").html("Already Rate Profile Description Assigned This ID").css('color','gray');
                $("#edit_rate_desc").css('border','1px solid #ccc');
                 $("#btn_edit_pro").prop('disabled', false);
                 $("#edit_rate_pro").prop('disabled',false);
                  
                  }
                  else if(res==1)
                  {
                      
                     $("#msg_rate_desc_edit").html("Rate Profile Description Already Taken. Please Try Again").css('color','red');
                     $("#edit_rate_desc").css('border-color','red');
                      $("#btn_edit_pro").prop('disabled', true);
                      $("#edit_rate_pro").prop('disabled',true);
                    

                  }
                  else if(res==2)
                  {
                   
                     $("#msg_rate_desc_edit").html("Rate Profile Name Available").css('color','green');
                     $("#edit_rate_desc").css('border-color','green');
                     $("#btn_edit_pro").prop('disabled', false);
                     $("#edit_rate_pro").prop('disabled',false);
                      
 
                  }

                   else if(res==3)
                  {
                      
                     $("#msg_rate_desc_edit").html("Rate Profile Description has been  Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#edit_rate_desc").css('border-color','red');
                      $("#btn_edit_pro").prop('disabled', true);
                      $("#edit_rate_pro").prop('disabled',true);
                    

                  }

                  

                }

          });

   	       
   }
   else
   {
                      $("#edit_rate_desc").css('border','1px solid #ccc');
                      $("#btn_edit_pro").prop('disabled', false);
                      $("#edit_rate_pro").prop('disabled',false);
                     $("#msg_rate_desc_edit").html("");
                   

   }
  
}

function parentSort(value){

$( "#"+value ).sortable({

       axis : 'y',
      cursor: "move",
       update : function(){

        var data1=$(this).sortable("serialize");
        
         $.ajax({
        
               url : "{{route('rate.profile.parentsort')}}",
               type : "GET",

               dataType:"json",
               data:data1,

             success : function(res)
             {
                alert("updated parent sort");
              
                   setTimeout(function () {
        //alert('Reloading Page');
        location.reload(true);
      }, 2000);


             }

         });

       }


    });


}



$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
 $(".errors").delay('3000').fadeOut();
 
})




</script>
@endsection

@endsection
