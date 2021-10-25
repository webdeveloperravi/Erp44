// speice saved

$(document).ready(function(){
  

 $("#speice").blur(function(){
  
   var name=$("#speice").val();

   if(name.length<=0)
   {
      $("#msg_sp_name").html(" ");
       $("#speice").css('border','1px solid #ccc');
   }
   else
   {
   	  $.ajax({
                
                method : "GET",
                url : "../admin/speices-exist/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log
                     var data=res;
                     
                  if(data>0)
                  {
                      $("#speice").css('border-color','red');
                     $("#msg_sp_name").html("Speices Name Already Taken").css('color','red');
                  }
                  else
                  {
                      $("#speice").css('border-color','green');
                   $("#msg_sp_name").html("Speices Name Available").css('color','green');
                  }

                  

                }

          });
   }

 });
  
  // Speices alias

$("#speice_alias").blur(function(){
  
 
 });



});

// speices close


//speice start edit

$(document).ready(function(){



 $("#edit_speice").blur(function(){
  
    var name=$("#edit_speice").val();
     var id=$("#edit").val();
   if(name.length<=0)
   {
      $("#msg_sp_name_ed").html(" ");
       $("#edit_speice").css('border','1px solid #ccc');
   }
   else
   {
          $.ajax({
                
                method : "GET",
                url : "../admin/speices-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     $("#msg_sp_name_ed").html(" ");
                     $("#edit_speice").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                      $("#edit_speice").css('border-color','red');
                     $("#msg_sp_name_ed").html("Speice Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_speice").css('border-color','green');
                     $("#msg_sp_name_ed").html("Speice Name Available").css('color','green');
                  }

                  

                }

          });

   }

 }); // close edit origin name



 $("#edit_speice_alias").blur(function(){
  
    var name=$("#edit_speice_alias").val();
     var id=$("#edit").val();
   if(name.length<=0)
   {
      $("#msg_sp_as_ed").html("empty");
      $("#edit_speice_alias").css('border','1px solid #ccc');
   }
   else
   {
          $.ajax({
                
                method : "GET",
                url : "../admin/speices-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     $("#msg_sp_as_ed").html(" ");
                     $("#edit_speice_alias").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                     
                      $("#edit_speice_alias").css('border-color','red');
                     $("#msg_sp_as_ed").html("Alias Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_speice_alias").css('border-color','green');
                     $("#msg_sp_as_ed").html("Alias Name Available").css('color','green');
                  }


                  

                }

          });

   }

 }); // close edit speice alias





});



// function saveValidation(){
//   alert("speice");
// }






