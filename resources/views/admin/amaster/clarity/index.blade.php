@extends('layouts.admin.app')
@section('title', $meta_title->title)
@section('meta_description',$meta_title->description)
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
                <div class="col-md-6 col-sm-6"><h2 class="text-secondary m-10">Clarity Form</h2></div>
                <div class="col-md-6 col-sm-6 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="$('#new_color').hide()">&times;</span>
      </a></p> </div>
           </div>
                <div class="card-body">

        

        

        <form method="POST" action="{{ route('clarity.store') }}" enctype="multipart/form-data">
            @csrf
             <span id="msg_error">&nbsp;</span>
           
            <div class="form-group row">
                    <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Clarity Name <span class="alert-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="clarity" type="text" class="form-control @error('clarity') is-invalid @enderror" name="clarity" value="{{ old('clarity') }}"  autocomplete="clarity" autofocus onblur="checkClarityName()">
                                   
                                   <span id="msg_clarity_name"></span>
                                   <span class="msg_add_clarity"></span>
                        @error('clarity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <input id="clarity_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="checkClarityAlias()">
                                  <span id="msg_clr_al"></span>
                                    <span class="msg_add_alias"></span>
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
                        <textarea id="clarity_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_clr_desc"></span>
                        
                    </div>
                </div>


               

                 <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return clarityValidation()" id="btn_clarity_saved">
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
          
                <div class="card-body">
                <form method="POST" action="{{ route('clarity.update') }}" enctype="multipart/form-data">
            @csrf

            <input id="edit" type="hidden" name="id" >
            <div class="form-group row">
                    <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Clarity Name <span class="alert-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="edit_clarity" type="text" class="form-control @error('clarity') is-invalid @enderror" name="clarity" value="{{ old('clarity') }}"  autocomplete="name" autofocus 
                        onblur="editClarityName()">
                                   <span id="edit_clr"></span>
                        @error('clarity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right  text-secondary">Alias <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <input id="edit_clarity_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editClarityAlias()">
                                         <span id="edit_als"></span>
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
                        <textarea id="edit_clarity_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="edit_desc"></span>
                        
                    </div>
                </div>


                

               
                           <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary"  id="btn_clarity_updated" >
                                   Update
                                </button>
                                 <button type="button" class="btn btn-danger"  onclick="$('#edit_color').hide()" >
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
  <div class="col-md-4 col-sm-4">
    <h2  class="text-left text-info">Clarity List</h2>
 </div>
 <div class="col-md-8 col-sm-8">
  <button onclick="showForm()" class="btn btn-success m-b-10 float-right">Add New Clarity</button>
  
 </div>
</div> 
<div class="sticky-top">
 <div class="row">
       <div class="col-12 col-sm-1 col-md-1 font-weight-bold ">UID</div>
       {{-- <div class="col-12 col-sm-1 col-md-1 font-weight-bold ">Sort No.</div> --}}
        <div class="col-12 col-sm-2 col-md-2 font-weight-bold ">Name</div>
         <div class="col-12 col-sm-2 col-md-2 font-weight-bold ">Alias Name</div>
         <div class="col-12 col-sm-6 col-md-5 font-weight-bold ">Description</div>
          <div class="col-12 col-sm-3 col-md-2  font-weight-bold text-center">Action</div> 
      </div>  
 </div>
    <ul  id="sortable1" class="list-group list-group-flush"  onmousemove="parentSort('sortable1')">
       @if($data->isNotEmpty())
       
     
     @foreach($data->sortBy('parent_sort')  as $data_key =>$data_val)
     
     <li class="list-group-item m-b-10 m-t-10 z-depth-0" id="parent_id_{{$data_val->id}}">
      <div class="row">
        <div class="col-sm-1 col-md-1"> <strong>{{ $data_val->id}}</strong>
        </div> 
        {{-- <div class="col-sm-1 col-md-1"> <strong>{{ $data_val->parent_sort}}</strong>
        </div>  --}}
        <div class="col-sm-2 col-md-2 text-primary font-weight-bold">{{ $data_val->clarity}}
        </div>  
        <div class="col-sm-2 col-md-2  font-weight-bold"> {{ $data_val->alias}}
        </div>  
        <div class="col-sm-6 col-md-4"> {{ $data_val->descr}}
        </div>  
        <div class="col-sm-3 col-md-3"> 
      <button type="button" class="btn btn-sm btn-primary p-1 float-right m-r-10" style="width:60px;" onclick="edit_color({{$data_val->id}},'{{$data_val->clarity}}','{{$data_val->alias}}',`{{ $data_val->descr }}`)"> edit </button>
      @if($data_val->status==1)
      <a href="{{route('clarity.status',['id'=>$data_val->id,'status'=>$data_val->status])}}" class="btn btn-warning btn-sm p-1 float-right m-r-10" style="width:60px;" > Disable</a> 
      @else
      <a href="{{route('clarity.status',['id'=>$data_val->id,'status'=>$data_val->status])}}" class="btn btn-success btn-sm p-1 float-right m-r-10" style="width:60px;" > Enable</a> 
        @endif  
       </div>  

    </div>

      </li>
       
      @endforeach
   
      @else
       <li class="list-group-item m-b-10 m-t-10 z-depth-0">No Recound Found</li>
      @endif
    </ul>
    <div class="m-t-10 float-right m-b-10"> 

</div>
</div>



@section('script')
<script type="text/javascript">



function closeForm(){
  $("#new_color").hide();
  $("#edit_color").hide();
}

$(document).ready( function () {
    $('#table_id').DataTable();
} );


function clarityValidation(){

   var name=$("#clarity").val();
   var alias=$("#clarity_alias").val();
   var desc=$("#clarity_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {

        $("#clarity").css('border','1px solid red');
        $("#msg_clarity_name").html("Name field is required").css('color','red');
        $("#msg_clr_al").html("Alias field is required").css('color','red');
       $("#clarity_alias").css('border','1px solid red');
       $("#msg_clr_desc").html("Description field is required").css('color','red');
       $("#clarity_desc").css('border','1px solid red');



        

     
      return false;
   }

   else if (name==="") {
      
       $("#msg_clarity_name").html("Name field is required").css('color','red');
      $("#clarity").css('border','1px solid red');

      
      return false;


   }
   else if(alias==="")
   {
      $("#msg_clr_al").html("Alias field is required").css('color','red');
      $("#clarity_alias").css('border','1px solid red');
      
     
    return false;
   }
   else if(desc==="")
   {
      $("#msg_clr_desc").html("Description field is required").css('color','red');
      $("#clarity_desc").css('border','1px solid red');
      
     
    return false;
   }

   else{
    return true;
   }


}

// clarity form to search clarity  name

function checkClarityName()
{

 var name=$("#clarity").val();

   if(name.length>0)
   
   {
        $.ajax({
                
                method : "GET",
                url : "../admin/clarity-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     var data=res;
                     
                  if(data==1)
                  {
                    
                      $("#clarity").css('border-color','red');
                     $("#msg_clarity_name").html("Clarity Name Already Taken then Please Try Again ").css('color','red');
                      $("#btn_clarity_saved").prop('disabled', true);
                      $("#clarity_alias").prop('disabled',true);
                     
                   
                  }
                  else if(data==2)
                  {

                       $("#clarity").css('border-color','red');
                     $("#msg_clarity_name").html("Clarity Name  has been Already Taken and Deleted. Please Contact Administrator ").css('color','red');
                      $("#btn_clarity_saved").prop('disabled', true);
                      $("#clarity_alias").prop('disabled',true);
                     

                  }
                  else
                  {
                     $("#clarity").css('border-color','green');
                   $("#msg_clarity_name").html("Clarity Name Availalble").css('color','green');
                   $("#btn_clarity_saved").prop('disabled', false);
                      $("#clarity_alias").prop('disabled',false);
                       
        
                  }

                  

                }

        });

   }
   else
   {
       
       $("#clarity").css('border','1px solid #ccc');
        $("#msg_clarity_name").html("");
     $("#btn_clarity_saved").prop('disabled', false);
      $("#clarity_alias").prop('disabled',false);
     
    

   }


}

// to search clarity alias name from database
function checkClarityAlias()
{
 var alias=$("#clarity_alias").val();

   if(alias.length>0)
 
   {
    
      $.ajax({
               
                method : "GET",
                url : "../admin/clarity-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                    if(res==1)
                  {
                     $("#clarity_alias").css('border-color','red');
                     $("#msg_clr_al").html("Alias Name Already Taken then Please Try Again").css('color','red');
                     $("#btn_clarity_saved").prop('disabled', true);
                     $("#clarity").prop('disabled',true);
                  }
                  else if(res==2)
                  {
                      $("#clarity_alias").css('border-color','red');
                     $("#msg_clr_al").html("Alias Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_clarity_saved").prop('disabled', true);
                     $("#clarity").prop('disabled',true);
                  }
                  else

                  {
                   $("#clarity_alias").css('border-color','green');
                   $("#msg_clr_al").html("Alias Name Availalble ").css('color','green');
                    $("#clarity").prop('disabled',false);
                    $("#btn_clarity_saved").prop('disabled', false);
                   
                  }
                  
                }

        });
   }
   else
   {
     $("#btn_clarity_saved").prop('disabled', false);  
      $("#clarity").prop('disabled',false);
      $("#clarity_alias").css('border','1px solid #ccc');
        $("#msg_clr_al").html("");
    
     
   }

}


// update validation

$(document).ready(function(){

 $("#btn_clarity_updated").click(function(){

 var name=$("#edit_clarity").val();
 var alias=$("#edit_clarity_alias").val();
 var desc=$("#edit_clarity_desc").val();

     
   if(name==="" && alias==="" && desc==="")
   {

        $("#edit_clarity").css('border','1px solid red');
        $("#edit_clr").html("Name field is required").css('color','red');
        $("#edit_als").html("Alias field is required").css('color','red');
       $("#edit_clarity_alias").css('border','1px solid red');
         $("#edit_desc").html("Description field is required").css('color','red');
       $("#edit_clarity_desc").css('border','1px solid red');



        

     
      return false;
   }

   else if (name==="") {
      
       $("#edit_clr").html("Name field is required").css('color','red');
      $("#edit_clarityt").css('border','1px solid red');

      
      return false;


   }
   else if(alias==="")
   {
      $("#edit_als").html("Alias field is required").css('color','red');
      $("#edit_clarity_alias").css('border','1px solid red');
       return false;
     
    return false;
   }
   else if(desc==="")
   {
      $("#edit_desc").html("Description field is required").css('color','red');
      $("#edit_clarity_desc").css('border','1px solid red');
       return false;
     
    return false;
   }

   else{
    return true;
   }
 })
  
})


// to search edit clarity name from database

function editClarityName(){

     var name=$("#edit_clarity").val();
     var id=$("#edit").val();
   if(name.length>0)
   {
  
        $.ajax({
                
                method : "GET",
                url : "../admin/clarity-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                    
                 
                      $("#edit_clarity").css('border','1px solid #ccc');
                      $("#edit_clr").html("Before assigned Color Name this id").css('color','gray');
                      $("#btn_clarity_updated").prop('disabled',false);
                       $("#edit_clarity_alias").prop('disabled',false);
                     

                  }
                  else if(data==1)
                  {

                     $("#edit_clarity").css('border-color','red');
                   $("#edit_clr").html("Clarity Name Already Taken. Please Try Again").css('color','red');
                     $("#btn_clarity_updated").prop('disabled',true);
                     $("#edit_clarity_alias").prop('disabled',true);

                

                  }
                  else if(data==2)
                  {

                     $("#edit_clarity").css('border-color','green');
                     $("#edit_clr").html("Clarity Name Availalble").css('color','green');
                     $("#btn_clarity_updated").prop('disabled',false);
                     $("#edit_clarity_alias").prop('disabled',false);
                     $("#edit_als").html("");
                  }

                    else if(data==3)
                  {

                     $("#edit_clarity").css('border-color','red');
                   $("#edit_clr").html("Clarity Name has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_clarity_updated").prop('disabled',true);
                     $("#edit_clarity_alias").prop('disabled',true);

                

                  }

                  

                }

        });

   }
    else
     {
        $("#edit_clr").html("");
        $("#edit_clarity").css('border','1px solid #ccc');
        $("#btn_clarity_updated").prop('disabled',false);
        $("#edit_clarity_alias").prop('disabled',false);
     }

}


// edit clarity alias name from database

function editClarityAlias(){

var name=$("#edit_clarity_alias").val();
     var id=$("#edit").val();
   if(name.length>0)
 
   {
        $.ajax({
                
                method : "GET",
                url : "../admin/clarity-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                    
                     
                      $("#edit_clarity_alias").css('border','1px solid #ccc');
                      $("#edit_als").html("Before assigned Alias name this id ").css('color','gray');
                      $("#btn_clarity_updated").prop('disabled',false);
                       $("#edit_clarity").prop('disabled',false);
                      
                
                  }
                  else if(data==1)
                  {
                    
                   $("#edit_clarity_alias").css('border-color','red');
                     $("#edit_als").html("Clarity Alias Already Taken. Please Try Again").css('color','red');
                     $("#btn_clarity_updated").prop('disabled',true);
                     $("#edit_clarity").prop('disabled',true);
                    
              

                  }
                  else if(data==2)
                  {
                    $("#edit_clarity_alias").css('border-color','green');
                   $("#edit_als").html("Clarity Alias Availalble").css('color','green');
                   $("#btn_clarity_updated").prop('disabled',false);
                     $("#edit_clarity").prop('disabled',false);
                     
              
                  }

                    else if(data==3)
                  {

                      $("#edit_clarity_alias").css('border-color','red');
                     $("#edit_als").html("Clarity Alias has been Already Taken and Deleted. Please Contact Administrator").css('color','red');
                     $("#btn_clarity_updated").prop('disabled',true);
                     $("#edit_clarity").prop('disabled',true);
                    
              

                

                  }


                  

                }

        });

   }
   else
   {
      $("#edit_als").html("");
        $("#edit_clarity_alias").css('border','1px solid #ccc');
        $("#btn_clarity_updated").prop('disabled',false);
        $("#edit_clarity").prop('disabled',false);
   }


}
$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
 $(".errors").delay('3000').fadeOut();

  
});

// sorting clarity list

function parentSort(value){

$( "#"+value ).sortable({

       axis : 'y',
      cursor: "move",
       update : function(){

        var data1=$(this).sortable("serialize");
        
         $.ajax({
        
               url : "{{route('clarity.parentsort')}}",
               type : "get",

              // dataType:"json",
               data:data1,

             success : function(res)
             {
               
              
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

<!-- </body>

</html> -->