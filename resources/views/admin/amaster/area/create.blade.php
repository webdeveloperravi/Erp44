 
<div class="add_vendor" style="">
	<div class="card">
		<!--Header ---->
		<div class="card-footer p-0" style="background-color: #04a9f5">
			<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Zone</h5>
		 </div>
		
		<div class="card-body">
			<div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
				<button type="button" class="close" data-dismiss="alert">×</button>
			<ul id="res"></ul>
		</div>
		<form id="add_vendor_form" onsubmit="event.preventDefault();">
			<div class="form-group row">
				<label class="col-md-4 col-form-label text-md-right text-secondary">Country<span class="alert-danger">*</span></label>
				<div class="col-md-6">
					<select class=" selectpicker form-control" id="countryId" name="countryId" onchange="getStates(this.value)">
						<option disabled="" selected>Select Country</option>
						@foreach($countries as $country)
						<option value="{{$country->id}}">{{$country->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-4 col-form-label text-md-right text-secondary">State<span class="alert-danger">*</span></label>
				<div class="col-md-6" id="states">
					<select class=" selectpicker form-control" id="stateId" name="stateId">
						<option disabled="" selected>Select State</option>
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
				<div class="col col-sm-4 col-md-6">
					<input id="name" type="text" class="form-control " name="name" autofocus="">
				</div>
			</div>
			 
			 
			<div class="form-group row">
				<label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
				<div class="col col-sm-4 col-md-4">
					<button class="btn btn-success saveZone" onclick="saveZone()">Save</button> 
					<button class="btn btn-danger ml-4" onclick="closeZone()">Close</button> 
				</div>
			</div>
		</form>
	</div>
	
</div>
</div>
<script type="text/javascript">
function getStates(countryId){ 
	var url = "{{route('zone.states',['/'])}}/"+countryId;
	$.get(url,function(data){
	$("#states").html(data);
	});
}

   
   function saveZone(){
    
   $("#saveButton").attr('disabled',true);
   var countryId = $("#countryId").val();
   var stateId = $("#stateId").val();
   var name = $("#name").val();
   var alias = $("#alias").val();
   var description = $("#description").val(); 
   var token = "{{csrf_token()}}";
    
   
   $.ajax({
     url: "{{route('zone.store')}}",
     method: 'POST',
     data: {
       countryId :countryId,
       stateId :stateId,
       name :name,
       alias :alias,
       description :description,
      _token:token,
     },
     beforeSend:function(){
         $(".saveZone").attr('disabled',true);
     },
     success: function(data){
     	  $(".saveZone").attr('disabled',false);
      if($.isEmptyObject(data.errors)){
      	 $("#create").html("");
      	 $("#stateIndex").trigger('change');
      	
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