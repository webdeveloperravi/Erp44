 
	<div class="card">
		<!--Header ---->
		<div class="card-footer p-0" style="background-color: #04a9f5">
			<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create City ( {{ $state->name }} )</h5>
		   </div>
		
		<div class="card-body">
			<div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<ul id="res"></ul>
		</div>
		<form id="add_vendor_form" onsubmit="event.preventDefault();"> 
			<input type="hidden" name="stateId" id="stateId" value="{{$state->id}}">
			<div class="form-group row">
				<label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
				<div class="col col-sm-4 col-md-6">
					<input id="nameCity" class="form-control" type="text" class="form-control " name="name" autofocus="">
				</div>
			</div> 
			<div class="form-group row">
				<label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
				<div class="col col-sm-4 col-md-4">
					<button class="btn btn-success saveCity" onclick="saveCity()">Submit</button> 
					<button class="btn btn-danger ml-4" onclick="closeCity()">Close</button> 
				</div>
			</div>
		</form>
	</div>
	
</div> 
<script type="text/javascript">
function getStates(countryId){ 
	var url = "{{route('zone.states',['/'])}}/"+countryId;
	$.get(url,function(data){
	$("#states").html(data);
	});
}

   
   function saveCity(){
    
   $("#saveButton").attr('disabled',true); 
   var stateId = $("#stateId").val();
   var name = $("#nameCity").val();  
   var token = "{{csrf_token()}}";
   
   $.ajax({
     url: "{{route('city.store')}}",
     method: 'POST',
     data: { 
		stateId :stateId,
       name :name, 
      _token:token,
     },
     beforeSend:function(){
         // $(".saveZone").attr('disabled',true);
     },
     success: function(data){
         if(data.message){
            swal(data.message);
		 }else{
			if($.isEmptyObject(data.errors)){
      	 // create();
      	$("#create").html("");
      	  index(data.stateId);
      }else{ 
          $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000);   
      }
      }
	  $(".saveCity").attr('disabled',false);
		 }

     	  
       
   });

}

 function hideErrors(){ 
    $(".text-danger").remove(); 
 }


 

</script>