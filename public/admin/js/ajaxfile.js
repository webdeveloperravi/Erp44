
$(document).ready(function(){

 

$("#myform").submit(function(e){
 
  var route=$("#myform").data('route');
  var form_data=$(this);
  //alert("yes Form data has been submited."+route);
   
   $.ajax({
    
      type:"POST",
      url:route,
      data:form_data.serialize(),
      success:function(Response)
      {
        if(Response.error)
        {
          console.log(Response.error);
        }
        else{
          console.log(Response.success);
        }
      }


   })

   e.preventDefault();
});

});
 
 


$("#sg_id").on('change',function(){
 
     alert($("#sg_id").val());
  
   });


function get_category(){

 alert("get category");
}



//}); dd

// get dates id from price history

$("#profile_weight_id").on('change',function(){
 
     profile_weight_id=$(this).val();
     var rate_profile_id=$("#rate_profile_id").val();
     if(rate_profile_id>0)
     {
           $.ajax({
       method:"GET",
       url:"../rate-profile-price-history-data/"+rate_profile_id+"/"+profile_weight_id,
       dataType:"json",
       data:{
         profile_weight_id : profile_weight_id
       },

       success:function(data){
           
           var data_length=data.length;
          if(data_length>0)
           {
              $("#res_info").html("");
             for(var i=0; i<data.length; i++)
              {
             // console.log(data[i].id+"Price"+data[i].price+"Updated "+data[i].updated_at);
                $("#res_info").append("<tr><td>"+(i+1)+"</td><td>"+data[i].price+"</td><td>"+data[i].updated_at+"</td></tr>")
              }

            }
            else
            {
              console.log("No Result Found");
            }

        }

      });

     }
     else
     {
        $("#res_info").html("");
      $("#res_info").append("<tr><td></td><td class='text-danger'>No Data Avaiable</td><td></td></tr>");
     
     }
  

  });

function on_record(){

   $("#dis").hide();
  console.log('dd1');

}
function getdata(){
  console.log("fine");
}



  $("#btn_grade").click( function(e){
 
  var route=$("#grade_form").attr('action');
  var form_data=$("#grade_form").serialize();

   $.ajax({
    type:"POST",
    url :route,
    data:form_data,
    dataType:'json',
    success:function(res){
       alert("Record Saved");
      console.log(res);
      $("#grade_modal").modal("hide");
      alert("Record Saved");
      },

      error:function(error)
      {
        console.log(error);
      }


   })

  e.preventDefault();

  });


  // edit grade 

  $(document).ready(function(){
  
   $(".btn_edit").click(function(){
    alert("l");
   $("#grade_edit_modal").modal('show');
 
   });
  
  });

