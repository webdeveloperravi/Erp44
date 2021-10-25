
// edit color 



// edit color 
$(document).ready(function(){
   
$("#ecolor").blur(function(){
    
  var color_name=$("#ecolor").val();
  var id=$("#edit").val();

  if(color_name.length<=0)
  {
      $("#msg_ecolor").html(" ");
       $("#ecolor").css('border','1px solid #ccc');
  }
  else
  {
     
        
       $.ajax({
          
          type:"GET",
          url:"../admin/color-exist-edit/"+id+'/'+color_name,  // 
        
          
          dataType:"json",
          success:function(data){
            if(data==0)
            {
              $("#msg_ecolor").html("Before assign Color Name this id").css('color','gray');;
              $("#ecolor").css('border','1px solid #ccc');

            }
            else if(data==1)
            {
              $("#ecolor").css('border-color','red');
                     $("#msg_ecolor").html("Color Name Already Taken").css('color','red');
                
            }
            else if(data==2)
            {
              $("#ecolor").css('border-color','green');
                     $("#msg_ecolor").html("Color Name Available").css('color','green');
                
            }
          }

       });

     }

    
   }); // edit color name close


  // edit color alias name



$("#ealias").blur(function(){
    
  var alias_name=$("#ealias").val();
  var id=$("#edit").val();
  if(alias_name.length<=0)
  {
      $("#msg_ealias").html(" ");
       $("#ecolor").css('border','1px solid #ccc');
  }
  else
  {
     
       $.ajax({
          
          type:"GET",
          url:"../admin/color-alias-exist-edit/"+id+'/'+alias_name,  // 
        
          
          dataType:"json",
          success:function(data){
            if(data==0)
            {
              $("#msg_ealias").html("Before assign Alias name this id ").css('color','gray');
              $("#ealias").css('border','1px solid #ccc');

            }
            else if(data==1)
            {
               $("#ealias").css('border-color','red');
               $("#msg_ealias").html("Alias Name Already Taken").css('color','red');
                
            }
            else if(data==2)
            {
               $("#ealias").css('border-color','green');
               $("#msg_ealias").html("Alias Name Available").css('color','green');
            
            }
          }

       });

     }

    
   });  // edit color alias name close






});



















