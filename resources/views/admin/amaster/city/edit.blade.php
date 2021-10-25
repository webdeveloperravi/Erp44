 
  <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer p-0" style="background-color: #04a9f5">
			<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit City</h5>
		   </div>
		
    <div class="md-content ">
     
   <form id="add_vendor_form" onsubmit="event.preventDefault();" class="pt-3"> 
      <input type="hidden" name="areaId" id="cityId" value="{{$city->id}}">
      <div class="form-group row">
        <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
        <div class="col col-sm-4 col-md-6">
          <input id="nameCityEdit" type="text" class="form-control " name="name" autofocus="" value="{{$city->name}}">
        </div>
      </div>
       
   

       <div class="form-group row py-3 justify-content-right" >
          <div class="col">
             <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateCity()">Update</button> 
          <button class="btn btn-danger float-right m-0 mr-2" onclick="editClose()">Close</button>  
          </div>
      
      </div> 
    </form>
    </div>

  </div>
  <div class="md-overlay"></div>
 
 
<script type="text/javascript">
function getStates(countryId){ 
  var url = "{{route('zone.states',['/'])}}/"+countryId;
  $.get(url,function(data){
  $("#states").html(data);
  });
}

   
   function updateCity(){ 
    
   $("#saveButton").attr('disabled',true); 
   var cityId = $("#cityId").val();
   var name = $("#nameCityEdit").val(); 
   var token = "{{csrf_token()}}";
    
   
   $.ajax({
     url: "{{route('city.update')}}",
     method: 'POST',
     data: { 
      cityId :cityId,
       name :name, 
      _token:token,
     },
     beforeSend:function(){
         // $(".saveZone").attr('disabled',true);
     },
     success: function(data){
        $(".saveZone").attr('disabled',false);
      if($.isEmptyObject(data.errors)){
        editClose();
        index(data.stateId);

         // create();
        
         // product_purchase_list(); 
         // zoneIndex(); 
         // $(".complete-loader").hide();
         // $("#successMsg").show();
         // setTimeout(function(){
         //    $("#successMsg").hide();
         // },3000);
      }else{ 
         // $(".complete-loader").hide(); 
          $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000);   
      }
      }
   });

}

 function hideErrors(){ 
    $(".text-danger").remove(); 
  }


 

</script>