@extends(Auth::guard('admin')->check() ? 'layouts.admin.app' : 'layouts.warehouse.app')
  
@section('content')
@php  
    use App\Helpers\Helper;
     $create=$edit=$view=$delete=1;
      if(Auth::guard('warehouse')->check())
      {    
              
           $permission_data=  Helper::getDepartment(Session::get('guard_id'));
         if($permission_data)
         {
            $create= $permission_data['create'];
             $view= $permission_data['view'];
              $edit= $permission_data['edit'];
               $delete= $permission_data['delete']; 
         }
      }
      
     
@endphp
 <div class="container item_list">
	<div class="alert alert-success alert-dismissible" style="display: none" id="success_msg">
   <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 id="sucs"></h4>
   </div>
   <div class="alert alert-danger alert-dismissible" style="display: none" id="delete_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 id="del"></h4>
   </div>
      <div id="new_color"   class="row justify-content-center"style="display: none">

       <div class="col-md-12 col-sm-12">
        <div class="card" class="showForm" >
         <div class="row">
        <div class="col-md-8 col-sm-8"><span class="text-secondary m-10" style="font-size:32px">New Items </span> Gin :<span id="gin-top" style="font-size:32px;">dd</span></div>
       
         <div class="col-md-4 col-sm-4 hidden-sm hidden-sm-down"><p class="text-md-right text-xs-right m-r-10"><a type="button" class="close fa-2x text-danger edit-close" aria-label="Close">
  <span aria-hidden="true" onclick="closeForm()">&times;</span>
      </a></p> </div>
    </div>

          <div class="card-body">

           <div class="alert alert-danger alert-dismissible" style="display: none;" id="error_item">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
             <ul id="res"> </ul>
            </div>
           <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" id="item_form">
				                @csrf

            <div class="form-group row">

		     <div class="offset-md-1 col-md-5 col-sm-6">
		     <label for="color">Product <span class="alert-danger">*</span></label>
		     <select   id="category_id"  name="product_id" class="form-control  @error('name') is-invalid @enderror">
                    	<option value="0">Select Product</option>
						@foreach($category->sortBy('name') as $cat_key => $cat_val )
                                 <option value="{{$cat_val['id']}}">
								{{$cat_val['name']}}  
							</option> 
						@endforeach
			  </select>
				<strong><span id="msg_product" style="color:red"></span></strong>
				   </div>
                <div class=" col-sm-6 col-md-5">
          <label for="color">Origin <span class="alert-danger">*</span></label>
          <select name="origin_id"  id="origin_id"  class="form-control  @error('origin') is-invalid @enderror"  value="{{ old('origin') }}"  autocomplete="color" autofocus>
        <option>Select Origin</option>
        </select>
           <strong><span id="msg_origin" style="color:red"></span></strong>
        </div>
			   
			</div>

            <div class="form-group row">
		          <div class="offset-md-1 col-sm-6 col-md-5">
                <label for="color">Grade <span class="alert-danger">*</span></label>
         <select name="grade_id" id="grade_id" class="form-control  @error('grade') is-invalid @enderror"  value="{{ old('grade') }}"  autocomplete="color" autofocus>
         <option>Select Grade</option>
         </select>
         <strong><span id="msg_grade" style="color:red"></span></strong>
				  {{--  --}}
				  </div>
				  <div class="col-sm-6 col-md-5">
            <label for="color">Rate Profile<span class="alert-danger">*</span></label>
             <p id="msg">lllll</p>
          <input id="rate_profile" type="text" class="form-control @error('length') is-invalid @enderror"  value="{{ old('rate_profile') }}"  autocomplete="name" autofocus readonly="true">
          <span id="stand_rati">Stand Ratti</span> <span id="rati_rate">Rati Rate</span> <span id="mrp">MRP</span>
          <input id="profile_id" type="hidden" name="rate_profile_id">
        </div>
		   </div>

		   <div class="form-group row">
                <div class="offset-md-1 col-sm-6 col-md-5">
                    <label for="color">Weight <span class="alert-danger">*</span></label>
        <input id="weight" type="text" class="form-control @error('length') is-invalid @enderror" name="weight" value="{{ old('weight') }}"  autocomplete="name" autofocus  placeholder="Weight">
        
          </div>   
                <div class="col-md-5 col-sm-6">
                   <label for="color">Length <span class="alert-danger">*</span></label>
          <input id="length" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="length" value="{{ old('length') }}"  autocomplete="name" autofocus placeholder="Length">
        
            </div>
          </div>

          <div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
           <label for="color">Width <span class="alert-danger">*</span></label>
          <input id="width" type="text" class="form-control only-numeric @error('width') is-invalid @enderror" name="width" value="{{ old('width') }}"  autocomplete="name" autofocus  placeholder="Width">
             
			    </div>
          <div class="col-md-5 col-sm-6">
            <label for="color">Depth <span class="alert-danger">*</span></label>
          <input id="depth" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="depth" value="{{ old('depth') }}"  autocomplete="name" autofocus  placeholder="Depth">
          
           </div>
         </div>

         <div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
          <label for="color">Color <span class="alert-danger">*</span></label>
        <select name="color_id"  id="color_id" class="form-control  @error('color') is-invalid @enderror"  value="{{ old('color') }}"  autocomplete="color" autofocus>
        <option>Select Color</option>
         </select>
         <strong><span id="msg_color" style="color:red"></span></strong>
          </div>
				<div class="col-md-5 col-sm-6">
           <label for="color">Shape <span class="alert-danger">*</span></label>
        <select name="shape_id"  id="shape_id"  class="form-control  @error('shape') is-invalid @enderror"  value="{{ old('shape') }}"  autocomplete="color" autofocus>
        <option>Select Shape</option>
          </select>
          <strong><span id="msg_shape" style="color:red"></span></strong>
        </div>
        </div>

		<div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
          <label for="color">Clarity <span class="alert-danger">*</span></label>
           <select name="clarity_id"  id="clarity_id" class="form-control  @error('clarity') is-invalid @enderror" name="name" value="{{ old('clarity') }}"  autocomplete="color" autofocus>
         <option>Select Clarity</option>
         </select>
         <strong><span id="msg_clarity" style="color:red"></span></strong>
			  
			   </div>
			   <div class="col-sm-6 col-md-5">

          <label for="color">Treatment <span class="alert-danger">*</span></label>
         <select id="treatment_id"   class="form-control" name="treatment_id" >
         <option>Select Treatment</option>
           </select>
         <strong><span id="msg_treatment" style="color:red"></span></strong>
                
       </div>
	    </div>
        
        <div class="form-group row">
		       <div class="offset-md-1 col-sm-6 col-md-5">
          <label for="color">Specie <span class="alert-danger">*</span></label>
          <input type="text" name="specie" value="{{old('specie_id')}}" class="form-control" id="specie" readonly="">
           <input type="hidden" name="specie_id" id="specie_id" value="">
         <strong><span id="msg_specie" style="color:red"></span></strong>
          </div>
               <div class="col-sm-6 col-md-5">
                <label for="color">SG <span class="alert-danger">*</span></label>
         <input type="text" name="sg" value="{{old('sg')}}" class="form-control" id="sg_id" readonly="">

         <strong><span id="msg_sg" style="color:red"></span></strong>

			   </div>
	    </div>
        <div class="form-group row"> 
	          <div class="offset-md-1 col-sm-6 col-md-5">

               <label for="color">RI <span class="alert-danger">*</span></label>
         <input type="text" name="ri" value="{{old('ri')}}" class="form-control" id="ri_id" readonly="">
         <strong><span id="msg_ri" style="color:red"></span></strong> 
		      </div>
         <div class="col-sm-6 col-md-5">

        <label for="alias">GIN <span class="alert-danger">*</span> </label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="gin" value="{{ old('name') }}"  autocomplete="name" autofocus placeholder="GIN" readonly="">
        <strong><span id="msg_name" style="color:red"></span></strong>
        </div>
		 </div> 
       <div class="form-group row"> 
       <div class="offset-md-1 col-sm-6 col-md-5">
       <button type="submit" class="btn btn-info" style="margin-top:7px;"> Save</button>  
       </div>
      </div>
		</form>
      </div>
   </div>
   </div>
   </div>

  <!----Product Stock Edit Part ------>
  
  <div class="stock_edit_div" style="display: none">
<!----include edit stock blade data using ajax --->
  
  </div>
<!-----Close Product stock edit--->
    @if($create)
     <div class="row float-right">
           <div class="col-md-4">
	       <button class="btn btn-success" id="new_rate" data-toggle="modal" data-target="#grade_modal" data-whatever="@getbootstrap" onclick="showForm()">Add New Item</button>
           </div>
     </div>
@endif


    <h2 class="text-left text-info">Stock List</h2>
  
   <div class='table-responsive items_list' >
       <!--- table info---->
       
   {{--     @if($permission_data->exists())
            @include('admin.amaster.item.fetch_items',['permission_data'=>$permission_data])
           @endif --}}
   </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title w-100 text-center text-primary" id="vw_pro_type_id" >Yellow Saphire</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
               </button>
              </div>
             <div class="modal-body">
             <div class="row">
             	<div class="col-sm-4 col-md-4">
                <label class="text-secondary" style="width:60px">Color</label> <label class="col-com m-l-15" id="vw_color">dd</label> 
                </div>	
                <div class="col-sm-4 col-md-4">
                <label class="text-secondary">Clarity</label> <label class="col-com  m-l-15" id="vw_clarity">dd</label>
                </div>	
                <div class="col-sm-4 col-md-4">
                 <label class="text-secondary">Grade</label> <label class="col-com  m-l-15" id="vw_grade">dd</label>
                </div>		
              </div>
              <hr/>
              <div class="row">
             	<div class="col-sm-4 col-md-4">
                <label class="text-secondary">Origin</label> <label class="col-com  m-l-15" id="vw_origin">dd</label> 
                </div>	
                <div class="col-sm-4 col-md-4">
                <label class="text-secondary">Shape</label> <label class="col-com  m-l-15" id="vw_shape">dd</label>
                </div>	
                <div class="col-sm-4 col-md-4">
                 <label class="text-secondary">Specie</label> <label class="col-com  m-l-15" id="vw_specie">dd</label>
                </div>		
              </div>
              <hr/>
              <div class="row">
             	<div class="col-sm-4 col-md-4">
                <label class="text-secondary">SG</label> <label class="col-com  m-l-15" id="vw_sg">dd</label> 
                </div>	
                <div class="col-sm-4 col-md-4">
                <label class="text-secondary">RI</label> <label class="col-com  m-l-15" id="vw_ri">dd</label>
                </div>	
                <div class="col-sm-4 col-md-4">
                 <label class="text-secondary">Treatment</label> <label class="col-com  m-l-15" id="vw_treatment">dd</label>
                </div>		
              </div>
              <hr/>
              <div class="row">
             	<div class="col-sm-4 col-md-4">
                <label class="text-secondary">Length</label> <label class="col-com  m-l-15" id="vw_length">dd</label> 
                </div>	
                <div class="col-sm-4 col-md-4">
                <label class="text-secondary">Weight</label> <label class="col-com  m-l-15" id="vw_weight">dd</label>
                </div>	
                <div class="col-sm-4 col-md-4">
                 <label class="text-secondary">Width</label> <label class="col-com  m-l-15" id="vw_width">dd</label>
                </div>		
              </div>
              <hr/>
              <div class="row">
             	<div class="col-sm-4 col-md-4">
                <label class="text-secondary">Depth</label> <label class="col-com  m-l-15" id="vw_depth">dd</label> 
                </div>	
                <div class="col-sm-4 col-md-4">
                <label class="text-secondary">Status</label> <label class="m-l-15" id="vw_status"></label>
                </div>	
                </div>
              <hr/>
          </div>

             </div>
        </div>
</div>
<!-- Modal Close--->

</div> <!---Conttainer Div close-->

@section('script')
<script type="text/javascript">


function closeForm()
{
  $("#new_color").hide();
  $(".stock_edit_div").hide();
 
}

// get records from product using change action

$("#category_id").on('change',function(){
  //  generateGin();
   // gin=(""+Math.random()).substring(2, 10);
    var cat_id=$(this).val();
    var  url="{{route('items.records',['/'])}}"+'/'+cat_id;

    if(cat_id>0){
     
      $.ajax({
       method:"GET",
       url:url,
       dataType:"json",
     

       success:function(data){
       
         $("#specie_id").val(data['specie_id']);
        $("#specie").val(data['specie']);
         $("#color_id").empty();
         $("#clarity_id").empty();
         $("#grade_id").empty();
         $("#origin_id").empty();
         $("#shape_id").empty();
         $("#treatment_id").empty();
         $("#sg_id").empty();
         $("#ri_id").empty();
         $("#name").empty();

       var color=data["c"];  
       var clarity=data["clarity"];  
       var grade=data["grade"];  
       var origin=data["origin"];
       var shape=data["shape"];
       var specie=data["specie"];  
       var treatment=data["treatment"];
       var sg=data["sg"];
       var ri=data["ri"];  

     $("#sg_id").val(sg); 
     $("#name").val(data["gin"]);
     $("#gin-top").html(data["gin"]);
       console.log(sg);   
        $("#color_id").append("<option>Select Color</option>");
      $.each( data['c'], function( key, value ) {
       $("#color_id").append("<option value="+key+">"+value+"</option>");
     });
       // $("#clarity_id").append("<option>Select Clarity</option>");
      $.each(clarity, function( key, value ) {
       $("#clarity_id").append("<option value="+key+">"+value+"</option>");
     });
     
      $.each( grade, function( key, value ) {
       $("#grade_id").append("<option value="+key+">"+value+"</option>");
     });
      $("#origin_id").append("<option>Select Origin</option>");
      $.each( origin, function( key, value ) {
       $("#origin_id").append("<option value="+key+">"+value+"</option>");
     });
       $("#shape_id").append("<option>Select Shape</option>");
      $.each( shape, function( key, value ) {
       $("#shape_id").append("<option value="+key+">"+value+"</option>");
     });

      // $("#specie_id").val(specie);
  
      $("#treatment_id").append("<option>Select Treament</option>");
      $.each( treatment, function( key, value ) {
       $("#treatment_id").append("<option value="+key+">"+value+"</option>");
     });

           $("#ri_id").val(ri); 
       
       }


      })
      

    }
    else
    {
      alert("No Product Avaiable");
      $("#color_id").html('<option>Select Color</option>');
         $("#clarity_id").html('<option>Select Clarity</option>');
         $("#grade_id").html('<option>Select Grade</option>');
         $("#origin_id").html('<option>Select origin</option>');
         $("#shape_id").html('<option>Select Shape</option>');
         $("#specie").html('<option>Select Specie</option>');
         $("#treatment_id").html('<option>Select treatment</option>');
         $("#sg_id").html('<option>Select SG</option>');
         $("#ri_id").html('<option>Select RI</option>');
    }

   });

function generateGin() {
  var gin;
   var d=new Date();
   var day=d.getDay();
   var month=d.getMonth()+1;
   var year=d.getFullYear();
   gin=(""+Math.random()).substring(2,4);
   alert(gin);



}







// weight code
$("#weight").on('focusout',function(){

  category_id=$("#category_id").val();
  origin_id=$("#origin_id").val();
  weight_val=$("#weight").val();
  rate_id=$("#profile_id").val();
  
 var url="{{ route('items.calculate.weight',['/','/']) }}/"+weight_val+"/"+rate_id;
  
    if(category_id>0 && origin_id>0 && weight_val>0)
   {
          if(rate_id=="")
          {
                 alert("Not Set Grade");
          }
          else
          {

         $.ajax({
       
         url : url,
         type : "GET",
         success : function(res)
         {
             console.log();
             if(res['notexist']=='Rate Profile is not assigned Range')
             {
               alert("Rate Profile is not assigned Range");
             }
             else{
             if(res['0'].true)
              {
                
                $("#stand_rati").html("Stand Rati:"+res['0'].true).css('color','green');
                $("#rati_rate").html("Rati Rate:"+res['rati']).css('font-weight','bold');
                $("#mrp").html("MRP :"+res['mrp']).css('font-weight','bold');
             }
             else
             {
                
                $("#stand_rati").html("Stand Rati:"+res['0'].false).css('color','red');
               $("#rati_rate").html("Rati Rate:"+res['rati']).css('font-weight','bold');
                $("#mrp").html("MRP :"+res['mrp']).css('font-weight','bold');
             }
         }
       }

    });
      }
   }
   else
   {
    alert("Not Select Something");
   }


})

   $(document).ready(function(){
       fetch_item_list();
   $("#item_form").on('submit', function(event){
    event.preventDefault();
     $.ajax({
    
      type:"POST",
      url :"{{route('items.store')}}",
      data :$("#item_form").serialize(),
      success : function(successData)
       {
         $("#item_form")[0].reset(); // reset form 
         $("#stand_rati").html('');
         $("#rati_rate").html('');
         $("#mrp").html('');
          alert(successData["success"]);
          $("#new_color").hide();
           fetch_item_list();
             //location="../admin/items";
        },
       error:function(errorData)
       {
       	  
       	  // var response=JSON.parse(errorData.responseText);
       	    alert("Erros");
       	    $("#length").focus();
       	     $("#error_item").show();
             $("#res").empty();

             // console.log(response.errors.name);
            
             $.each(errorData.responseJSON.errors, function(index,items){
     
             $("#res").append("<ul><li>"+items+"</li></ul>");
             

             });
             $(function(){
                      $("#error_item").delay(10000).fadeOut();
                       });
             

         console.log(errorData);
       }	
  
    }); // ajax bracket close 

}); // btn click  bracket close


}); // main document close


//product stock edit----
  $(document).on('click','.btn-stock-edit',function(e){
       
  var stock_id=$(this).val();
  var url="{{route('items.edit',['/'])}}/"+stock_id;

  $.ajax({
      
    url : url,
    type : "Get",
  success : function(data)
  {
      console.log(data);
      $("#new_color").hide();
      $(".stock_edit_div").show();
      $(".stock_edit_div").html(data);
      $("#edit_length").focus();
  }


});
   e.preventDefault();


});

// update product stock---

function updateStock(){

 var update_form=$("#edit_item_form").serialize();
 var url="{{ route('items.update') }}";
 $.ajax({
     
       type: "POST",
       url : url,
       data :update_form,
       success : function(res)
       {
         fetch_item_list();
          $("#success_msg").show();
          $("#sucs").html(res["success"]);
          $(function(){
           $("#success_msg").delay(3000).fadeOut();
           });
          $(".stock_edit_div").hide();

       },
       error:function(errorData)
       {
          
          // var response=JSON.parse(errorData.responseText);
             alert("Erros");
             $("#edit_length").focus();
             $("#edit_error_item").show();
             $("#edit_res").empty();

             // console.log(response.errors.name);
            
             $.each(errorData.responseJSON.errors, function(index,items){
     
             $("#edit_res").append("<ul><li>"+items+"</li></ul>");
             

             });
             $(function(){
                      $("#edit_error_item").delay(10000).fadeOut();
                       });
             

         console.log(errorData);
       }


 })




  }

   $(document).ready(function(){
   $("#edit_item_form").on('submit', function(event){
    event.preventDefault();

    alert("ok");


 
}); // btn click  bracket close


}); // main document close



function fetch_item_list() {
        $.ajax({
  
    url:"{{route('items.all')}}",
    type : 'GET',
    success:function(data)
     {

       $('.items_list').html(data)
        $("#item_table").DataTable();

     }

   });


}

// Pop up  Message for View

function viewItem( id,category,color,clarity,grade,origin,specie,shape,treatment,sg,ri,length,width,depth,weight,status){
	
  $(".text-secondary").css('width','60px');
  $(".col-com").css('font-weight','normal');
	$("#vw_pro_type_id").html(category);$("#vw_color").html(color);$("#vw_clarity").html(clarity);$("#vw_grade").html(grade);
	$("#vw_origin").html(origin);$("#vw_shape").html(shape);$("#vw_specie").html(specie);$("#vw_sg").html(sg);
	$("#vw_ri").html(ri);$("#vw_treatment").html(treatment);$("#vw_length").html(length);$("#vw_width").html(width);
	$("#vw_depth").html(depth);$("#vw_weight").html(weight);

	if(status==1)
	{
		$("#vw_status").html("Active").css("color","#0ac282");
	}
	else
	{
		$("#vw_status").css("color","orange").html("In-Active");
	}
}

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

    $.ajax({
    
      type:"GET",
      url :"../admin/items-delete/"+id,
      success : function(successData)
       {
        
          alert(successData["success"]);
          
          $("#delete_msg").show();
           $("#del").html(successData["success"]);
           fetch_item_list();
            
        },
      
    }); // ajax bracket close 




}



// change status

function changeStatus(id,status)
{
 var url="{{route('items.status',['/','/'] )}}/"+id+"/"+status
$.ajax({
    
      type:"GET",
      url :url,
      success : function(successData)
       {
        
        $("#success_msg").show();
           $("#sucs").html(successData["success"]);
             fetch_item_list();
            $("#success_msg").delay('5000').fadeOut();

            
        },
      
    }); // ajax bracket close 


}

// Action on Grade Change
$("#grade_id").on('change',function(event){

  val =$(this).val();
  cate_id=$('#category_id').val();
  var url="{{ route('item.grade-rate',['/','/'])}}/"+cate_id+'/'+val;

   
   $.ajax({
     
         url :url,
         type : "GET",
         success : function(res)
         {
          
          console.log(res);
           $("#rate_profile").val(res['profile_name']);
           $("#profile_id").val(res['profile_id']);
         }
    
        });


});

$(".only-numeric").on("keypress", function (evt) {
        var $txtBox = $(this);
        var charCode = (evt.which) ? evt.which : evt.keyCode
          ("#msg").append(charCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        else {
            var len = $txtBox.val().length;
            var index = $txtBox.val().indexOf('.');
            //alert(index);
            if (index > 0 && charCode == 46) {
              return false;
            }
            if (index > 0) {
                var charAfterdot = (len + 1) - index;
                if (charAfterdot > 3) {
                    return false;
                }
            }
        }
        return $txtBox; //for chaining
    });




$("#weight").bind("keypress", function (e) {
          var keyCode = e.which ? e.which : e.keyCode
             var leng=$(this).val().length;

          if (!(keyCode >= 48 && keyCode <= 57)) {
             $(".error").css("display", "inline");
            return false;
          }
              if(leng>10)
              {
                return false;
              }
          else{
            $(".error").css("display", "none");
          }
        });


     




 </script>
  
@endsection
@endsection
