@extends('layouts.admin.app')
@section('content')
<div class="container">
	<div class="success_msg" style="display:none"> </div>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card" class="showForm" id="add_menu" style="display: none;">
				<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
					<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Module</h5> </div>
				<div class="card-body">
					<!---Error Messages---->
					<div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<ul id="res"> </ul>
					</div>
					<!----Eerro Messages Close--->
					<form method="POST" enctype="multipart/form-data" id="menu_form"> @csrf
						<div class="form-group row">
							<label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Title<span class="alert-danger">*</span></label>
							<div class="col-md-6">
								<input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus> </div>
						</div>
						<div class="form-group row">
							<label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Description<span class="alert-danger"></span></label>
							<div class="col-md-6">
								<textarea id="description" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Route </label>
							<div class="col-md-6">
								<input id="route" type="text" class="form-control m-b-10 @error('route') is-invalid @enderror" name="route" value="{{ old('route') }}" autocomplete="off"> </div>
						</div>
            <div class="form-group row">
							<label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Guard<span class="alert-danger">*</span></label>
							<div class="col-md-6">
								<select name="guard" class="form-control" onchange="getParentModules(this.value)">
									<option value="0">Select Guard</option> 
                  @foreach ($guards as $guard)  
									<option value="{{ $guard->id }}">{{ $guard->name }}</option>  
                  @endforeach 
                </select>
							</div>
						</div>
						<div class="form-group row">
							<label for="parent" class="col-md-4 col-form-label text-md-right text-secondary">Parent Menu<span class="alert-danger"></span> </label>
							<div class="col-md-6" id="parent_menu">
								<select class="form-control parent_title" name="parent" value="{{ old('parent') }}">
									<option value="0"> Select Parent Menu</option>
								</select>
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<button type="button" class="btn btn-primary" id="btn_menu_saved" onclick="addModule()"> Save </button>
								<input type="button" name="cancel" class="btn btn-danger m-l-10" onclick="closeForm()" value="Close"> </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-----Edit Menu Form----------------------->
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="" class="showForm" id="edit_menu" style="display: none;"> </div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<button class="btn btn-dark float-right mb-3" onclick="showMenuForm()">Create Module</button>
		</div>
	</div>
	<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
		<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Modules</h5> </div>
	<div class="menu_page" style="margin-top: 20px;"></div>
	<br/> </div>
@section('script')
<script type="text/javascript">
  
$(document).ready(function(){
       
      //  fetchParentMenu();
       fetchMenuList();

})

  function showMenuForm()
  {
     $("#add_menu").show();
     $("#edit_menu").hide();
     $(".parent_menu").hide();
     $("#title").focus();

  }

// form close 
function closeForm(){

  $("#add_menu").hide();
  $("#edit_menu").hide();

}

  // add parent menu/title in select tag (parent menu)

function getParentModules(id){

var url="{{ route('menu.parent.menu',['/']) }}/"+id;
$.ajax({
      url:url,
      type:"GET",
      success:function(res)
      {
        $("#parent_menu").html(res); 
     }
});
}


//fetch Module List
function fetchMenuList(){

    $.ajax({

      url:"{{route('menu.list')}}",
        type:"GET",
        success:function(res)
        {
          $(".menu_page").html(res);
        }

    });

}

// Add Module // Store Module Menu

function addModule()
{
  var url="{{route('menu.store') }}";
  var form_data=$("#menu_form").serialize();
 
 $.ajax({
        url : url,
        type : "POST",
        data :form_data,
        success:function(data)
        {
          if(data.success){ 
            // $("#menu_form")[0].reset();
            // $("#add_menu").hide();
            // fetchParentMenu();
            fetchMenuList();
            notify('Successfully Saved', 'success'); 
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
        },
        error : function(errorData)
        {
          var messages=errorData.responseJSON["message"];
          alert("errors");
          $("#error_msg").show();
          $("#res").empty();
           for (var i =0; i<messages.length; i++) {
              $("#res").append("<ul><li>"+messages[i]+"</li></ul>");
           }
            $(function(){
              $("#error_msg").delay(10000).fadeOut();
            });
        }
      });
}


 // edit record to show on Edit Form

$(document).on('click','.btn_edit_module',function(event){

    var module_id=$(this).val();
    var url ="menu-edit";

        $.get(url + '/' +module_id, function (data) {
             $("#add_menu").hide();
              $("#edit_menu").show();
             
            $("#edit_menu").html(data);
            $("#etitle").focus();
          
      
          });
  event.preventDefault();


})

// Update Module Record
 function updateModule()
{
   var update_data=$("#edit_menu_form").serialize();
   var url="{{ route('menu.update') }}";
  
  $.ajax({

        url:url,
        type : "POST",
        data : update_data,
        success:function(data)
        {
          if(data.success){ 
            $("#edit_menu").html(''); 
            fetchMenuList();
            notify('Successfully Updated', 'success'); 
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
        },

      });


}


      


// // drag and drop menu

//   $(document).ready(function(){
//  //   alert("fine");
// //     $( ".list-group-flush" ).sortable();
    
// //   });

 function mouseFn(value){

    $( "#"+value ).sortable({
        items: "li",
      
       axis : 'y',
      cursor: "move",
       update : function(){

        var form_data=$(this).sortable("serialize");
        
         $.ajax({
               
               type : "GET",
               url : "./menu-parentsort",
               data : form_data,
               dataType : 'Json',
               success : function(res)
             {
                alert("updated parent sort");
                 fetchMenuList();
             }

         });

       }


    });

}


// child sort function with ajax

function sortchild(childvalue)
{
  
   $( "."+childvalue ).sortable({
    
      item:"li",
      cursor: "move",
      axis : 'y',
       update : function(){

        var child_form=$(this).sortable("serialize");
        
         $.ajax({
        
               url : "./menu-childsort",
               type : "get",
               data:child_form,
               dataType : 'json',

             success : function(res)
             {
                //alert("updated Child sort");
                 fetchMenuList();
             }

         });

       }


    });
}


// function clickChild()
// {
//   alert("ok");
// }


// $(function () {
//     $('#childsort').on('mouseenter mouseover', 'li > ul', function () {
//         $(this).draggable({
//             revert: true,
//             revertDuration: 0
//         });

//     });
// });

// Alert Message For Delete 

function messageDelete(id)
{
     var conf=confirm("Are You Sure to Delete Record")

     if(conf == true)
     {
         deleteRecord(id);
      return true;
     }
     else
     {
      
      return false;

     }

}

function deleteRecord(id)
{
  var path_url="{{ route('menu.destroy',['/']) }}/"+id;
    $.ajax({
    
      type:"GET",
      url : path_url,
      success : function(successData)
       {
        
          alert(successData["success"]);
          
          $("#sucs").show();
          $("#sucs").focus();
           $("#sucs").html(successData["success"]);
            $(function(){
                      $("#sucs").delay(3000).fadeOut();
                       });
           fetchMenuList();
            
        }
      
    }); // ajax bracket close 




}


</script>
@endsection
@endsection




