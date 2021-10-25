<div class="row justify-content-center">
    <div class="col-md-12">
       <div class="card">
          <div class="card-footer p-0" style="background-color: #04a9f5">
             <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Attach Zones To :  ({{ $manager->name }})</h5>
          </div>
          <div class="card-block">
<form onsubmit="event.preventDefault(0)" id="getZonesForm">
    @csrf
    <div class="row"> 
        <input type="hidden" name="managerId" value="{{ $manager->id }}">
        <div class="col-xl-2 col-md-3 col-12 mb-1">
           <div class="form-group">
              <label for="state">Select Country</label> 
              <select class="form-control" name="country" onchange="getStates2(this.value)">
                 <option value="0">ALL</option>
                 @foreach($countries as $country)
              <option value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
              </select>
           </div>
        </div>
        <div class="col-xl-2 col-md-3 col-12 mb-1" id="states2">
           <div class="form-group">
              <label for="state">Select State</label> 
              <select class="form-control" name="state" onchange="getCities2(this.value)">
                 <option value="0">ALL</option>
              </select>
           </div>
        </div>
        <div class="col-xl-2 col-md-3 col-12 mb-1" id="cities2">
           <div class="form-group">
              <label for="state">Select City</label> 
              <select class="form-control" name="city">
                 <option value="0">ALL</option>
              </select>
           </div>
        </div> 
        <div class="col-xl-2 col-md-4 col-12 my-auto">
           <div class="form-group mt-lg-4"> 
              <button class="btn btn-primary" onclick="getZones()">Get Zones</button> 
           </div>
        </div>
     </div>
   </form>
   <div class="" id="attachZoneView"></div>
          </div>
       </div>
    </div>
</div>
   <script>
        
function getStates2(countryId){ 
	var url = "{{route('storeDiscount.attachZones.getStates',['/'])}}/"+countryId;
	$.get(url,function(data){
	    $("#states2").html(data);
	});
} 
function getCities2(stateId){ 
	var url = "{{route('storeDiscount.attachZones.getCities',['/'])}}/"+stateId;
	$.get(url,function(data){
	    $("#cities2").html(data);
	});
}

function getZones(){

    var url = "{{ route('managerZoneAttachView') }}";
    $.ajax({
        method : "Post",
        url : url,
        data : $("#getZonesForm").serialize(),
        success: function(data){
            $("#attachZoneView").html(data);
        }
    });

}

function attachZones(){
    var url = "{{ route('managerZoneAttach') }}";
    $.ajax({
        method :"POST",
        url : url,
        data : $("#zoneAttachForm").serialize(),
        success: function(data){
        $("#attachZoneIndex").html('');
        $("#zoneViewRefresh").click();
        notify('Successfully Attached','success');

        }
    });
 }
 
   </script>