@extends('layouts.store.app')
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
<div class="card">
    <div class="card-body">
       <form onsubmit="event.preventDefault(0)" id="getStoresForm">
        @csrf
        <div class="row"> 
            <div class="col-xl-2 col-md-3 col-12 mb-1">
               <div class="form-group">
                  <label for="state">Select Country</label> 
                  <select class="form-control" name="country" onchange="getStates(this.value)">
                     <option value="0">ALL</option>
                     @foreach($countries as $country)
                  <option value="{{$country->id}}">{{$country->name}}</option>
                  @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-2 col-md-3 col-12 mb-1" id="states">
               <div class="form-group">
                  <label for="state">Select State</label> 
                  <select class="form-control" name="state" onchange="getCities(this.value)">
                     <option value="0">ALL</option>
                  </select>
               </div>
            </div>
            <div class="col-xl-2 col-md-3 col-12 mb-1" id="cities">
               <div class="form-group">
                  <label for="state">Select City</label> 
                  <select class="form-control" name="city">
                     <option value="0">ALL</option>
                  </select>
               </div>
            </div>
            <div class="col-xl-2 col-md-3 col-12 mb-1" id="cities">
               <div class="form-group">
                  <label for="">Select Address Type</label> 
                  <select class="form-control" name="addressType">
                     <option value="0">ALL</option>
                     @foreach ($addressTypes as $type)
                      <option value="{{ $type->id }}">{{ $type->name }}</option>   
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-2 col-md-4 col-12 my-auto">
               <div class="form-group mt-lg-4"> 
                  <button class="btn btn-primary" onclick="getStores()">Get Stores</button> 
               </div>
            </div>
         </div>
       </form>
    </div>
 </div>
 <div class="" id="allStores"></div>
 <div class="" id="editStoreRole"></div>
@endsection
@section('script')
<script type="text/javascript">

function getStates(countryId){ 
	var url = "{{route('storeDiscount.getStates',['/'])}}/"+countryId;
	$.get(url,function(data){
	    $("#states").html(data);
	});
} 

function getCities(stateId){ 
	var url = "{{route('storeDiscount.getCities',['/'])}}/"+stateId;
	$.get(url,function(data){
	    $("#cities").html(data);
	});
}

function getStores(){

    var url = "{{ route('storeDiscount.getStores') }}";
    $.ajax({
        method : "Post",
        url : url,
        data : $("#getStoresForm").serialize(),
        success: function(data){
            $("#allStores").html(data);
        }
    });
}

function attachZonesIndex(storeId){
     var url = "{{ route('storeDiscount.zoneAttachIndex',['/']) }}/"+storeId;
     $.get(url,function(data){
         $("#attachZoneIndex").html(data);
         $('html,body').animate({ scrollTop: 9999 }, 'slow');
        });
} 

function attachZonesView2(storeId){
     var url = "{{ route('storeDiscount.zoneAttachView',['/']) }}/"+storeId;
     $.get(url,function(data){
         $("#attachZoneView").html(data);
         $('html,body').animate({ scrollTop: 9999 }, 'slow');

        });
} 
    
function attachZones(){
    var url = "{{ route('storeDiscount.zoneAttach') }}";
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
 
 function editStoreRole(storeId){
     var url = "{{ route('storeDiscount.editStoreRole',['/']) }}/"+storeId;
     $.get(url,function(data){
         $("#editStoreRole").html(data); 
         
        });
    }
    
    function updateStoreRole(){
        var url = "{{ route('storeDiscount.updateStoreRole') }}";
        $.ajax({
         method :"POST",
         url : url,
         data : $("#editStoreRoleForm").serialize(),
         success: function(data){
            $("#editStoreRole").html('');
            getStores();
            notify('Successfully Updated','success');
    
         }
     });
    }

    function alertConverToDistributor(){
    swal('Change Store Role with retail type Distributor to assign zones');
    }
    
</script>

@endsection