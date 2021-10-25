@extends('layouts.admin.app')
@section('css')
<style>


 

.noselect {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.dropdown-container, .instructions {
    width: 200px;
    margin: 20px auto 0;
    font-size: 14px;
    font-family: sans-serif;
    overflow: auto;
}

.instructions {
    width: 100%;
    text-align: center;
}

.dropdown-button {
    float: left;
    width: 100%;
    background: whitesmoke;
    padding: 10px 12px;

    cursor: pointer;
    border: 1px solid lightgray;
    box-sizing: border-box;
    
    .dropdown-label, .dropdown-quantity {
        float: left;
    }
    
    .dropdown-quantity {
        margin-left: 4px;
    }
    
    .fa-filter {
        float: right;
    }
}

.dropdown-list {
    float: left;
    width: 100%;

    border: 1px solid lightgray;
    border-top: none;
    box-sizing: border-box;
    padding: 10px 12px;
    
    input[type="search"] {
        padding: 5px 0;
    }
    
    ul {
        margin: 10px 0;
        max-height: 200px;
        overflow-y: auto;
        
        input[type="checkbox"] {
            position: relative;
            top: 2px;
        }
    }
}
</style>
@endsection
@section('content') 
			<div class="row"> 
		<div class="col">
			
			
			<button class="btn btn-dark float-right mb-2" onclick="create()">Add Zone</button>
			</div>
	</div> 
	<div id="create">
		
	</div>
	<div class="card">
		
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<select id="counrtyIndex" class="form-control" onchange="getStatesIndex(this.value),index(this.value,0)">
						<option value="0" selected="">Select Country</option>
					 @foreach($countries as $country)
					 <option value="{{$country->id}}">{{$country->name}}</option>
					 @endforeach
					</select>
				</div>
				<div class="col-md-3">
					<select id="stateIndex" class="form-control" onchange="index(0,this.value)" class="form-group">
						<option value="0" selected="">Select State</option>
					   </select>
				</div> 
	</div>
		</div>

	 
	</div>
	<div id="all"></div>
	
	<div id="index">
		
	</div>
	<div id="edit">
		
	</div>
	<div id="zoneViewTwo">
		
    </div>  
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
    // index(0,0);
    all();
});

function all(){
    var url = "{{ route('zone.all') }}";
    $.get(url,function(data){
       $("#all").html(data);
    });
}

function create(){

   var url ="{{route('zone.create')}}";
   $.get(url,function(data){
       $("#create").html(data);
   });

}

function edit(zoneId){
	var url ="{{route('zone.edit',['/'])}}/"+zoneId;
   $.get(url,function(data){
       $("#edit").html(data);
   });
}

function closeZone(){
	$("#create").html("");
}

function index(countryId,stateId){
      var url ="{{route('zone.view',['/','/'])}}/"+countryId+'/'+stateId;
      $.get(url,function(data){
        $("#zoneViewTwo").html('');
          $("#index").html(data);             
      });
}


 
function getStatesIndex(countryId){ 
	var url = "{{route('zone.states.index',['/'])}}/"+countryId;
	$.get(url,function(data){
	$("#stateIndex").html(data);
	});
}

function editModalHide(){

	$("#edit").html("");
}

function areasIndex(zoneId){
	 var url="{{route('area.index',['/'])}}/"+zoneId;
	 $.get(url,function(data){
         $("#areaIndex").html(data);
         
	 });
}

function closeAreaEdit(){
	$("#editArea").html("");
}


// Events
$('.dropdown-container').on('click', '.dropdown-button', function() {
        $(this).siblings('.dropdown-list').toggle();
	})
	.on('input', '.dropdown-search', function() {
    	var target = $(this);
        var dropdownList = target.closest('.dropdown-list');
    	var search = target.val().toLowerCase();
    
    	if (!search) {
            dropdownList.find('li').show();
            return false;
        }
    
    	dropdownList.find('li').each(function() {
        	var text = $(this).text().toLowerCase();
            var match = text.indexOf(search) > -1;
            $(this).toggle(match);
        });
	})
	.on('change', '[type="checkbox"]', function() {
        var container = $(this).closest('.dropdown-container');
        var numChecked = container. find('[type="checkbox"]:checked').length;
    	container.find('.quantity').text(numChecked || 'Any');
	});
 
 function attachAreasView(zoneId){
     var url = "{{ route('areas.attach.view',['/']) }}/"+zoneId;
     $.get(url,function(data){
         $("#attachAreasView").html(data);
         $('html,body').animate({ scrollTop: 9999 }, 'slow');

        });
    } 
    
    function attachAreas(){
        var url = "{{ route('areas.attach') }}";
        $.ajax({
         method :"POST",
         url : url,
         data : $("#areaAttachForm").serialize(),
         success: function(data){
            $("#attachAreasView").html('');
            $("#zoneViewRefresh").click();
            notify('Successfully Attached','success');

         }
     });
 }
 
</script>

@endsection