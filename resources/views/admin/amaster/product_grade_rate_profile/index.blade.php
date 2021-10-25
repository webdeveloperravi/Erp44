@extends('layouts.admin.app')
@section('content')
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-2 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Assign Rate Profile To Grade <a class="btn btn-sm mb-2 mr-2 btn-danger float-right" href="{{ route('category.grade.view') }}">View All </a></h5>
     </div>
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none;" id="error_assign_grade">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <ul id="res"> </ul>
      </div>
      <form id="createForm" onsubmit="event.preventDefault(0)">
      <div class="row">
         @csrf 
       <div class="col-xl-3 col-md-6 col-12 mb-1">
         <div class="form-group">
            <label for="inputState">Products<span class="alert-danger">*</span></label>
            <select id="cat_id" class="form-control" name="product_id" onchange="getUnsignedGradesAndRateProfiles(this.value)">
               <option selected>Choose Product</option>
               @foreach($categories as $category)
               <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach  
            </select>
         </div> 
       </div>  
       <div class="col-xl-3 col-md-6 col-12 mb-1">
         <div class="form-group">
            <label for="inputState">Grades<span class="alert-danger">*</span></label>
             <div id="gradeList">
               <select id="grade_id" class="form-control" name="grade_id">
               <option selected >Choose Grade</option>
               </select>
            </div> 
       </div> 
       </div> 
       <div class="col-xl-3 col-md-6 col-12 mb-1">
         <div class="form-group">
            <label for="inputState">Rate Profiles<span class="alert-danger">*</span></label>
            <div id="rateProfileList">
               <select class="form-control" name="rate_profile_id" >
                  <option selected>Choose Rate Profile</option>
               </select>
         </div> 
       </div> 
       </div>  
       <div class="col-xl-3 col-md-6 col-12 my-auto">
           <div class="form-group"> 
            <label for="inputState"></label>
            <div>
            <button class="btn btn-primary" onclick="save()">Submit</button>
            </div>
             </div>
       </div>  
     </div>
      </form>
    </div>
  
<div id="unsignedGradesAndRateProfiles"> </div> 
<div id="edit"> </div> 
</div>
 
@section('script')

<script type="text/javascript">
 function getGradeList(id){
    var url = "{{ route('product.getGradeList',['/']) }}/"+id;
    $.get(url,function(data){
       $("#gradeList").html(data);
    });
}

function getRateProfileList(id){
    var url = "{{ route('product.getRateProfileList',['/']) }}/"+id;
    $.get(url,function(data){
       $("#rateProfileList").html(data);
    });
}

function getUnsignedGradesAndRateProfiles(id){
    if(id > 0){
        getGradeList(id);
        getRateProfileList(id);
    var url ="{{ route('getUnsignedGradesAndRateProfiles',['/']) }}/"+id;
        $.get(url,function(data){
        $("#unsignedGradesAndRateProfiles").html(data);
        });
    }else{
        $("#unsignedGradesAndRateProfiles").html("");
    }
}

function save(){
    $.ajax({
      method: "POST",
      url: "{{route('grade.rate.prof.store')}}",
      data: $("#createForm").serialize(),
      success:function(data){
            cate_id = $("#cat_id").val(); 
            getUnsignedGradesAndRateProfiles(cate_id);
            $("#success_msg").show();
            $("#sucs").html(response.success);
            $(function() {
                $("#success_msg").delay(3000).fadeOut();
            });
      },
      error: function(error) {
            $("#error_assign_grade").show();
            $("#res").empty();
            $.each(error.responseJSON.failure, function(key, value) {
                $("#res").append("<ul><li>" + value + "</li></ul>");
            });
            $(function() {
                $("#error_assign_grade").delay(5000).fadeOut();
            });
        }
    });
}


function editRateProfile(productId,gradeId,rateProfileId) {
   var url = "{{ route('editProductGradeRateProfile',['/','/','/']) }}/"+productId+'/'+gradeId+'/'+rateProfileId;
   $.get(url,function(data){
       $("#edit").html(data);
   });
}


function changeStatus(productId,gradeId,rateProfileId) {
   var url = "{{ route('statusProductGradeRateProfile',['/','/','/']) }}/"+productId+'/'+gradeId+'/'+rateProfileId;
   $.get(url,function(data){
    cate_id = $("#cat_id").val(); 
            getUnsignedGradesAndRateProfiles(cate_id);
   });
}

function updateRateProfile(){
    // alert("Saab");
    $.ajax({
        url : "{{ route('updateProductGradeRateProfile') }}",
        method : "POST",
        data: $("#editForm").serialize(),
        success :  function(data){
            cate_id = $("#cat_id").val(); 
            getUnsignedGradesAndRateProfiles(cate_id);
            $("#cat_id").trigger('change');
           $("#edit").html(""); 

        },
    });
}




//update Category Form
function updateCate(id, cate_id) {

    var ct = cate_id;


    data = $("#" + id).serialize();
    // alert(data);
    $.ajax({

        url: "{{route('category-grade-rate.update')}}",
        type: "post",
        data: data,
        success: function(res) {

            console.log(res);

            get_data_by_cat_id(ct);
        }



    });



}



</script>

@endsection

@endsection
