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
    <div class="alert alert-success alert-dismissible" id="succ">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                
       <h4>{{Session::get('success')}}</h4>
   </div>
@endif
 @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible errors" id="succ" >
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                
       <h4>{{Session::get('error')}}</h4>
   </div>
@endif


    <div id="new_color"  style="display: none;" class="row justify-content-center">
       <div class="col-md-12 col-sm-12">

            <div class="card">
              <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Color</h5>
                </div> 

 
               
        
                <div class="card-body">

                               
				<form method="POST" action="{{ route('color.store') }}" enctype="multipart/form-data" >
            <span id="msg_error">&nbsp;</span>
				    @csrf  
						<div class="form-group row">
							<label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Color Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="color_name" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}"  autocomplete="color" autofocus onblur="return colorNameCheck()">
                                  <span id="msg_color"></span>
				                @error('color')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="color_alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="colorAliasCheck()">
                                 <span id="msg_alias"></span>
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
                        <textarea id="color_desc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_desc"></span>
                        
                    </div>
                </div>



				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_color_saved">
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
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Color</h5>
                </div> 
                <div class="card-body">

				

				

				<form method="POST" action="{{ route('color.update') }}" enctype="multipart/form-data">
				    @csrf

				    <input id="edit" type="hidden" name="id" >
						<div class="form-group row">
				            <label for="ecolor" class="col-md-4 col-form-label text-md-right text-secondary">Color Name <span class="alert-danger">*</span></label>
				            <div class="col-md-6">
				                <input id="ecolor" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}"  autocomplete="color" autofocus onblur="editColorName()" >
                                  <span id="msg_ecolor"></span>
				                @error('color')
				                    <span class="invalid-feedback" role="alert">
				                        <strong>{{ $message }}</strong>
				                    </span>
				                @enderror
				            </div>
				        </div>
				        <div class="form-group row">
				            <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Alias <span class="alert-danger">*</span> </label>
				            <div class="col-md-6">
				                <input id="ealias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}"  autocomplete="name" autofocus onblur="editColorAlias()">
                                 
                                  <span id="msg_ealias"></span>
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
                        <textarea id="edesc" class="form-control @error('desc') is-invalid @enderror" name="desc" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_edesc"></span>
                        
                    </div>
                </div>

				       

				         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn_color_update">
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
       <button class="btn btn-dark float-right mb-3" onclick="$('#new_color').show()">Create Color</button>
     </div>
 </div> 
 <div class="card">
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Colors</h5>
</div> 

  <div class="card-body">   
    <div class="table-responsive">
      <table class="table"  id="table_id22" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
      <thead>
        <tr>
        <th>UID</th>
        <th>Color Name</th>
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
        <td>{{strtoupper($cval->color)}}</td>
       <td>{{strtoupper($cval->alias)}}</td>
       <td>{{str::limit($cval->descr,30)}}</td> 
        <td>
        @if ($cval->status == 1)
        <a href="{{route('color.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class="btn btn-sm btn-warning p-1"style="width:60px;">Disable</a>  
        @else
        <a href="{{route('color.status',['id'=>$cval->id , 'status'=>$cval->status])}}" class="btn btn-sm btn-success p-1"style="width:60px;">Enable</a> 
        @endif
        </td> 
        <td>
        <button class="btn btn-sm btn-primary p-1" onclick="edit_color({{$cval->id}} , '{{$cval->color}}', '{{$cval->alias}}','{{$cval->descr}}')" style="width:60px;"> Edit </button>  
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
<!-- 
<br/>
 
<ul id="sortable">
  <li class="ui-state-default" id="dd"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
</ul> -->
</div>


@section('script')
 
 <script type="text/javascript">

$(document).ready(function(){

$('#table_id22').DataTable();

});

function closeForm(){
  $("#new_color").hide();
  $("#edit_color").hide();
}




 	// color validation on save
 $(document).ready(function(){
  $("#btn_color_saved").click(function(){


   var name=$("#color_name").val();
   var alias=$("#color_alias").val();
    var desc=$("#color_desc").val();

   
   
   if(name==="" && alias==="" && desc==="")
   {
    
     // $("#edit_ri_from").css('border','1px solid #ccc');
       $("#color_name").css('border','1px solid red');
        $("#msg_color").html("Name field is required").css('color','red');
        $("#msg_alias").html("Alias field is required").css('color','red');
       $("#color_alias").css('border','1px solid red');
       $("#msg_desc").html("Description field is required").css('color','red');
       $("#color_desc").css('border','1px solid red');
      return false;
   }

   else if (name==="") {
       

      $("#msg_color").html("Name field is required").css('color','red');
      $("#color_name").css('border','1px solid red');

      return false;


   }
   else if(alias==="")
   {
      
      $("#msg_alias").html("Alias field is required").css('color','red');
      $("#color_alias").css('border','1px solid red');
       return false;

   }
   else if(desc==="")
   {
      
      $("#msg_desc").html("Description field is required").css('color','red');
      $("#color_desc").css('border','1px solid red');
       return false;

   }

   else{
     
    return true;
   }


})

});  

// to searching color name from database

function colorNameCheck() {
	
 var color_name=$("#color_name").val();
  
  $("#color_alias").prop('disabled',false);
  $("#btn_color_saved").prop('disabled', false);
  $("#msg_alias").html("");
  $("#msg_color").html("");

                 
    
                
  if(color_name.length>0) 
  {
       
         
       $.ajax({
          
          type:"GET",
          url:"../admin/color-exist/"+color_name,
          dataType:"json",
          success:function(data){
            if(data==1){
                     $("#color_name").css('border-color','red');
                      $("#msg_color").html("Color Name Already Taken. Please  Try Again").css('color','red');
                      $("#btn_color_saved").prop('disabled', true);
                      $("#color_alias").prop('disabled',true);        
             }
           else if(data==2){
   

                     $("#color_name").css('border-color','red');
                    $("#msg_color").html("Color Name has been Already Taken and Deleted. Please Contact Adiministrator.").css('color','red');
                      $("#btn_color_saved").prop('disabled', true);
                      $("#color_alias").prop('disabled',true);  


           }  
            else
            {
                     $("#color_name").css('border-color','green');
                     $("#msg_color").html("Color Name Available").css('color','green');
                     $("#color_alias").prop('disabled',false);
                     $("#btn_color_saved").prop('disabled', false);
                     
                 }
            
           
            
          }
        
             
       })
       
        
     }
     else
     {
       $("#color_name").css('border','1px solid #ccc');
       $("#msg_color").html("");
       $("#color_alias").prop('disabled',false);
       $("#btn_color_saved").prop('disabled', false);
     }
   
   

}

// to searching a color alias name from database 

function colorAliasCheck(){
    
  var alias_name=$("#color_alias").val();          
  if(alias_name.length>0)
  {
    
         
        
       $.ajax({
          
          type:"GET",
          url:"../admin/color-alias-exist/"+alias_name,
          dataType:"json",
          success:function(data){
            if(data==1){

              $("#color_alias").css('border-color','red');
              $("#msg_alias").html("Alias Name Already Taken. Please Try Again").css('color','red');
              $("#btn_color_saved").prop('disabled', true);
              $("#color_name").prop('disabled',true);

                 
                 }
             else if(data==2)
             {
  
             $("#color_alias").css('border-color','red');
              $("#msg_alias").html("Alias Name has been Already Taken and Deleted. Please Contact Adiministrator").css('color','red');
              $("#btn_color_saved").prop('disabled', true);
              $("#color_name").prop('disabled',true);


             }    
           
             else
            {

               $("#color_alias").css('border-color','green');
               $("#msg_alias").html("Alias Name Available").css('color','green');
               $("#btn_color_saved").prop('disabled', false);
               $("#color_name").prop('disabled',false);
              
              
                
                  }
          
          },

       });

     }
     else
     {

       $("#color_alias").css('border','1px solid #ccc');
       $("#msg_alias").html("");
       $("#btn_color_saved").prop('disabled', false);
       $("#color_name").prop('disabled',false);
              
     }
    

 }


// edit validation

 $(document).ready(function(){
  $("#btn_color_update").click(function(){


   var name=$("#ecolor").val();
   var alias=$("#ealias").val();

   
   
   if(name==="" && alias==="")
   {
    
     // $("#edit_ri_from").css('border','1px solid #ccc');
       $("#ecolor").css('border','1px solid red');
        $("#msg_ecolor").html("Name field is required").css('color','red');
        $("#msg_ealias").html("Alias field is required").css('color','red');
       $("#ealias").css('border','1px solid red');
      return false;
   }

   else if (name==="") {
       

      $("#msg_ecolor").html("Name field is required").css('color','red');
      $("#ecolor").css('border','1px solid red');

      return false;


   }
   else if(alias==="")
   {
      
      $("#msg_ealias").html("Alias field is required").css('color','red');
      $("#ealias").css('border','1px solid red');
       return false;

   }

   else{
     
    return true;
   }


})

});  


// to edit color name field to search color name from database

function editColorName(){
    
  var color_name=$("#ecolor").val();
  var id=$("#edit").val();
  



  if(color_name.length>0)
  {
     
        
       $.ajax({
          
          type:"GET",
          url:"../admin/color-exist-edit/"+id+'/'+color_name,  // 
        
          
          dataType:"json",
          success:function(data){
            if(data==0)
            {
              $("#msg_ecolor").html("Before assigned Color Name this id").css('color','gray');;
              $("#ecolor").css('border','1px solid #ccc');
              $("#btn_color_update").prop('disabled',false);
              $("#ealias").prop('disabled',false);
              

            }
            else if(data==1)
            {
              $("#ecolor").css('border-color','red');
              $("#msg_ecolor").html("Color Name Already Taken. Please Try Again").css('color','red');
              $("#btn_color_update").prop('disabled',true);
              $("#ealias").prop('disabled',true);
              
                
            }
            else if(data==2)
            {
              $("#ecolor").css('border-color','green');
              $("#msg_ecolor").html("Color Name Available").css('color','green');
              $("#btn_color_update").prop('disabled',false);
              $("#ealias").prop('disabled',false);
                
            }
           else if(data==3)
            {
              $("#ecolor").css('border-color','red');
              $("#msg_ecolor").html("Color Name has been Already Taken and Deleted. Please Contact Adiministrator").css('color','red');
              $("#btn_color_update").prop('disabled',true);
              $("#ealias").prop('disabled',true);
              
                
            }

          }

       });

     }
     else
     {
     	$("#msg_ecolor").html("");
       $("#ecolor").css('border','1px solid #ccc');
      $("#btn_color_update").prop('disabled',false);
      $("#ealias").prop('disabled',false);
     }

    
  

   } // edit color name close

// to search the edit alias name from database
   function editColorAlias(){

  var alias_name=$("#ealias").val();
  var id=$("#edit").val();
  if(alias_name.length>0)
    {
     
       $.ajax({
          
          type:"GET",
          url:"../admin/color-alias-exist-edit/"+id+'/'+alias_name,  // 
        
          
          dataType:"json",
          success:function(data){
            if(data==0)
            {
              $("#msg_ealias").html("Before assigned Alias name this id ").css('color','gray');
              $("#ealias").css('border','1px solid #ccc');
              $("#btn_color_update").prop('disabled',false);
              $("#ecolor").prop('disabled',false);

            }
            else if(data==1)
            {
               $("#ealias").css('border-color','red');
               $("#msg_ealias").html("Alias Name Already Taken,Please Try Again").css('color','red');
               $("#btn_color_update").prop('disabled',true);
              $("#ecolor").prop('disabled',true);
              
                
            }
            else if(data==2)
            {
               $("#ealias").css('border-color','green');
               $("#msg_ealias").html("Alias Name Available").css('color','green');
                $("#btn_color_update").prop('disabled',false);
                $("#ecolor").prop('disabled',false);
               
            }

       else if(data==3)
            {
               $("#ealias").css('border-color','red');
               $("#msg_ealias").html("Alias Name has been Already Taken and Deleted. Please Contact Adiministrator").css('color','red');
                $("#btn_color_update").prop('disabled',true);
                $("#ecolor").prop('disabled',true);
               
            }



          }

       });

     }
     else
     {
     	
     	$("#msg_ealias").html("");
      $("#btn_color_update").prop('disabled',false);
      $("#ecolor").prop('disabled',false);
       $("#ealias").css('border','1px solid #ccc');
               

      }

    
     // edit color alias name close

   }


$(document).ready(function(){

 $(".alert-success").delay('3000').fadeOut();
  $(".errors").delay('3000').fadeOut();


})

function editColor(name)
{
  alert("fine");
}
  $( function() {
    $( "#sortable" ).sortable();
    
  } );







 </script>
@endsection
@endsection
