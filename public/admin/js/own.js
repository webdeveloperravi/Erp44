$(document).ready(function(){
	$("#msg").hide();
	$(".form").on('submit',function(e){
    	$("#msg").show();
		token = $('input[name="_token"]').val(); //$this
		data = $(this).serialize();

	  $.post("product-category-assign-color",data, function(result){

	    $("#msg").text(result);
	    var refreshId = setInterval(function () {
	        $("#msg").hide();
	    },3000);
	  });

	return false;

	});
	
$(".single_associate").on('submit', function(){
	
	data = $(this).serialize();
	$.post("product-category-assign-single",data, function(result){
		$("#msg").show();
		$("#msg").text(result);
		var refreshId = setInterval(function () {
	        $("#msg").hide();
	    },3000);
	});

	return false;
});

$(".update_category").on('submit',function(){

data = $(this).serialize();
	$.post("product-category-update",data, function(result){
		$("#msg").show();
		$("#msg").text(result);
		var refreshId = setInterval(function () {
	        $("#msg").hide();
	    },3000);
	});


	return false;


});


});

 



function showForm(){
	
$("#new_color").show();
$("#product_type").show();
$(".edit_image").toggle();
$("#edit_color").hide()
$("#edit_product").hide();
$("#color_name").focus(); 
$("#clarity").focus();
$("#grade_name").focus();
$("#rate_pro").focus();
$("#ri_from").focus();
$("#sg_from").focus();
$("#shape").focus();
$("#speice").focus();
$("#origin").focus();
$("#treatment").focus();
$("#name").focus();
$(".stock_edit_div").hide();

}

function edit_color(id, name, alias,desc,origin_code, eraticode ){

 
	
  $("#edit_color").show();
	$("#new_color").hide();
	$("#edit").val(id);
//colour
	$("#ecolor").val(name);
	$("#ealias").val(alias);
	$("#edesc").val(desc);
	$("#ecolor").focus(); 

  //clarity
    $("#edit_clarity").focus();
	$("#edit_clarity").val(name);
	$("#edit_clarity_alias").val(alias);
	$("#edit_clarity_desc").val(desc);

//shape
   $("#edit_shape_name").val(name);
   $("#edit_shape_alias").val(alias);
   $("#edit_shape_desc").val(desc);
    $("#edit_shape_name").focus();

// grade 
   $("#edit_grade_name").val(name);
   $("#edit_grade_alias").val(alias);
   $("#edit_grade_desc").val(desc);
    $("#edit_grade_name").focus();

   // orgin

  
    $("#edit_origin").val(name);
    $("#edit_origin_alias").val(alias);
    $("#edit_origin_code").val(origin_code);
     $("#edit_origin_desc").val(desc);
    $("#edit_origin").focus();

   // speice

    $("#edit_speice").val(name);
   $("#edit_speice_alias").val(alias);
   $("#edit_speice_desc").val(desc);
    $("#edit_speice").focus();

   // rate profile

    $("#edit_rate_pro").val(name);
   $("#edit_rate_desc").val(alias);
    $("#edit_rate_pro").focus();
  
  // treatment

    $("#edit_treat_name").val(name);
   $("#edit_treat_desc").val(alias);
   $("#edit_treat_name").focus();

   // SG 

    $("#edit_sg_from").val(name);
    $("#edit_sg_to").val(alias);
    $("#edit_sg_desc").val(desc);
    $("#edit_sg_from").focus();


   // RI

    $("#edit_ri_from").val(name);
    $("#edit_ri_desc").val(desc);
    $("#edit_ri_To").val(alias);
    $("#edit_ri_from").focus();



   
	

    //$("#edesc").attr("src",$(this).data('edesc'));
	
}


function show1(id){

  $(".list").hide();
	console.log(id);
	$("#"+id).toggle();

}

function show_Form(cls,id,name,desc)
{

 if(cls=='edit_master')
 {

  $("."+cls).show();
  $("#id").val(id);
  $("#edit_name").val(name);
  $("#edit_description").val(desc);
  $("#edit_name").focus();
  $(".add_master").hide();
 }
 else
 {
  
  $("."+cls).show();
  $("#name").focus();
  $(".edit_master").hide();
 } 
 
}

function close_form(cls)
{

  $("."+cls).hide();
}

function  move(id, associate){
 
   

 
	direction = $("#"+id).attr('direction');
	if(direction=="right"){
		 
		$("#"+id).attr('direction','left').css('background-color' ,'darkseagreen' );
		$("."+id).attr('name','attach[]');
	}else{
          $("#"+id).attr('direction','right').css('background-color' ,'lavender' );
          		$("."+id).attr('name','detach[]');

		

	}

	

	$("#"+associate+direction).append($("#"+id));
}


function associate_category(e){

	e.preventDefault();


token = $('input[name="_token"]').val();

  $.post("product-category-assign-color", {"_token": token, 'cat_id':12}, function(result){
    
    console.log(result);
  });

}

function only_number(){
$(this).bind("keypress", function (e) {
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

  }
function numericvalue(e){

    if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
  

}


function Demo(){


}

$(".only-numeric").bind("keypress", function (e) {
          var keyCode = e.which ? e.which : e.keyCode
             var leng=$(this).val().length;

          if (!(keyCode >= 48 && keyCode <= 57)) {
             $(".error").css("display", "inline");
            return false;
          }
              if(leng>=10)
              {
                return false;
              }
          else{
            $(".error").css("display", "none");
          }
        });












