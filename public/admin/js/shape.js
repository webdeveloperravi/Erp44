
  
  // shape alias

$("#alias").blur(function(){
  
  
 });



});
//shape close saved


// shape edit start

$(document).ready(function(){



 $("#edit_shape").blur(function(){
  
    
 }); // close edit clarity name



 $("#edit_shape_alias").blur(function(){
  
    var name=$("#edit_shape_alias").val();
     var id=$("#edit").val();
   if(name.length<=0)
   {
      $("#msg-as-ed").html("empty");
      $("#edit_shape_alias").css('border','1px solid #ccc');
   }
   else
   {
          $.ajax({
                
                method : "GET",
                url : "../admin/shape-alias-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     $("#msg-as-ed").html(" ");
                     $("#edit_shape_alias").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                     
                      $("#edit_shape_alias").css('border-color','red');
                     $("#msg-as-ed").html("Alias Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_shape_alias").css('border-color','green');
                     $("#msg-as-ed").html("Alias Name Available").css('color','green');
                  }


                  

                }

          });

   }

 }); // close edit clarity alias





});



function shapeValidation(){
  
   


}

