// Grade save

  // Grade alias

$("#grade_alias").blur(function(){
  
   

 });



});

// Grade saved close

// Grade Edit 



$(document).ready(function(){
  

 $("#edit_grade_name").blur(function(){
 
   var name=$("#edit_grade_name").val();
   var id=$("#edit").val();

   if(name.length<=0)
   {
      $("#msg_gr_ed").html("empty");
        $("#edit_grade_name").css('border','1px solid #ccc');

   }
   else
   {
       $("#msg_gr_ed").html(" ");
        $.ajax({
                
                method : "GET",
                url : "../admin/grade-exist-edit/"+id+"/"+name,
                dataType : "json",
                success:function(res){
                     
                     console.log(res);
                     var data=res;
                     if(data==0)
                  {
                     
                     $("#msg_gr_ed").html(" ");
                     $("#edit_grade_name").css('border','1px solid #ccc');
                  }
                  else if(data==1)
                  {
                      $("#edit_grade_name").css('border-color','red');
                     $("#msg_gr_ed").html("Grade Name Already Taken").css('color','red');
                  }
                  else if(data==2)
                  {
                   $("#edit_grade_name").css('border-color','green');
                     $("#msg_gr_ed").html("Grade Name Available").css('color','green');
                  }

                  

                }

          });
   }

 });
  
  // Grade alias

$("#edit_grade_alias").blur(function(){
  
  

 });



});





