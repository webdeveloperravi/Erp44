
// origin saved

$(document).ready(function(){
  

 $("#origin").blur(function(){
  
   var name=$("#origin").val();

   if(name.length<=0)
   {
      $("#msg_origin_name").html(" ");
       $("#origin").css('border','1px solid #ccc');
   }
   else
   {
   	  $.ajax({
                
                method : "GET",
                url : "../admin/origin-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data>0)
                  {
                      $("#origin").css('border-color','red');
                     $("#msg_origin_name").html("Origin Name Already Taken").css('color','red');
                  }
                  else
                  {
                      $("#origin").css('border-color','green');
                   $("#msg_origin_name").html("Origin Name Available").css('color','green');
                  }

                  

                }

          });
   }

 });
  
  // Origin alias

$("#origin_alias").blur(function(){
  
   var alias=$("#origin_alias").val();

   if(alias.length<=0)
   {
      $("#msg_origin_alias").html(" ");
      $("#origin_alias").css('border','1px solid #ccc');
   }
   else
   {
   	$.ajax({
                
                method : "GET",
                url : "../admin/origin-alias-exist/"+alias,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data>0)
                  {
                     $("#origin_alias").css('border-color','red');
                     
                     $("#msg_origin_alias").html("Alias Name Already Taken").css('color','red');
                  }
                  else
                  {
                     $("#origin_alias").css('border-color','green');
                   $("#msg_origin_alias").html("Alias Name Available").css('color','green');
                  }

                  

                }

          });

   }

 });



});

// origin close

//origin start edit

$(document).ready(function(){



 $("#edit_origin").blur(function(){
  
    var name=$("#edit_origin").val();
     var id=$("#edit").val();
   if(name.length<=0)
   {
      $("#msg_or_name_ed").html(" ");
       $("#edit_origin").css('border','1px solid #ccc');
   }
   else
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
                     
                     $("#msg_or_name_ed").html(" ");
                     $("#edit_origin").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                      $("#edit_origin").css('border-color','red');
                     $("#msg_or_name_ed").html("Shape Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_origin").css('border-color','green');
                     $("#msg_or_name_ed").html("Shape Name Available").css('color','green');
                  }

                  

                }

          });

   }

 }); // close edit origin name



 $("#edit_origin_alias").blur(function(){
  
    var name=$("#edit_origin_alias").val();
     var id=$("#edit").val();
   if(name.length<=0)
   {
      $("#msg_or_as_ed").html("empty");
      $("#edit_origin_alias").css('border','1px solid #ccc');
   }
   else
   {
          $.ajax({
                
                method : "GET",
                url : "../admin/origin-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     $("#msg_or_as_ed").html(" ");
                     $("#edit_origin_alias").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                     
                      $("#edit_origin_alias").css('border-color','red');
                     $("#msg_or_as_ed").html("Alias Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_origin_alias").css('border-color','green');
                     $("#msg_or_as_ed").html("Alias Name Available").css('color','green');
                  }


                  

                }

          });

   }

 }); // close edit clarity alias





});



