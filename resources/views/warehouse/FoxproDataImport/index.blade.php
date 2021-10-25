@extends('layouts.warehouse.app')
@section('content')

 <div class="card">
    <div class="card-footer p-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Step 1</h5> 
    </div>
    <div class="card-body">
        <form onsubmit="event.preventDefault(0)" id="createForm"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                    @csrf
                    <label for="">Select File (item.dbf)</label>
                    <input type="file" name="tbl_item" class="form-control">
                    <br>  
                </div>
                <div class="col-sm-6">  
                        <label for="">Select File (ifvalue.dbf)</label>
                        <input type="file" name="tbl_ifvalue" class="form-control">
                        <br> 
                       
                </div>
                <div class="col-md-8">
                    <div class="progress progress-xl" id="fileRequiredMsg" style="display:none;"> 
                        <div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">! Both Files Required to Process Importing</h5></div>
                     </div>  
                    <div class="progress progress-xl" id="fileInvalidMsg" style="display:none;"> 
                        <div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">! Files Not Match with our Record</h5></div>
                    </div>  
                    <div class="progress progress-xl" id="inProgressMsg" style="display:none;"> 
                        <div class="progress-bar progress-bar-striped progress-bar-warning" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Operation in Progress Please Wait...</h5></div>
                    </div>  
                    <div class="progress progress-xl" id="tableImportSuccess" style="display:none;"> 
                        <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Step 1 Complete</h5></div>
                    </div>  
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success float-right" id="storeTablesBtn" onclick="">Import Tables</button>  
                </div>
            </div>
        </form> 
    </div>
 </div>

 <div class="card">
    <div class="card-footer p-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Step 2</h5> 
    </div>
    <div class="card-body" id="leftPRoductsToReplaceWithErpIdView">
         
    </div>
 </div>

 <div class="card">
    <div class="card-footer p-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Step 3</h5> 
    </div>
    <div class="card-body" id="step3View">
         
    </div>
 </div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        getLeftPRoductsToReplaceWithErpId();
        leftProductStockImport();
    });
$('#storeTablesBtn').click(function(evt){
    // Stop the button from submitting the form:
    evt.preventDefault();
    
    // Serialize the entire form:
    var data = new FormData(this.form);
    
    var url = "{{route('foxproDataImport.storeTables')}}"; 
    $.ajax({
       url:url,
       method: "POST",
       data :data,
       cache: false,
        contentType: false,
        processData: false,
        beforeSend:function(){
            $(".pcoded-content").LoadingOverlay("hide");
            $("#inProgressMsg").show();
            $("#tableImportSuccess").hide();
        }, 
        complete:function(){
            $("#inProgressMsg").hide();
        }, 
       success : function(data){
          
          if(data.success){
            //   $('#createForm').hide();
              $("#tableImportSuccess").show();
              getLeftPRoductsToReplaceWithErpId();
          }  
          if(data.empty_files){ 
              $("#fileRequiredMsg").show();
              setTimeout(function(){
                $("#fileRequiredMsg").hide();
              },5000);
          }
          if(data.invalid_files){ 
              $("#fileInvalidMsg").show();
              setTimeout(function(){
                $("#fileInvalidMsg").hide();
              },5000);
          } 
       }
    });
});

function getLeftPRoductsToReplaceWithErpId(){
    var url = "{{ route('foxproDataImport.getLeftPRoductsToReplaceWithErpId') }}";
    $.get(url,function(data){
        $('#leftPRoductsToReplaceWithErpIdView').html(data);
    });
}

function columnsReplaceWithErpId(){
    var url = "{{ route('foxproDataImport.columnsReplaceWithErpId') }}";
    $.ajax({
        url : url,
        method:"POST",
        data : $("#checkBoxForm").serialize(),
        beforeSend:function(){
            $(".pcoded-content").LoadingOverlay("hide");
            $("#inProgressMsgStep2").show();
            $("#warningMsgStep2").hide();
        }, 
        complete:function(){
            $("#inProgressMsgStep2").hide();
        }, 
        success:function(data){
           if(data.success){
            $("#tableImportSuccessStep2").show();
            getLeftPRoductsToReplaceWithErpId();
            leftProductStockImport();
           }
           if(data.invalid_selection){
             $("#warningMsgStep2").show();
           }
        }
    });
}

function leftProductStockImport(){
    var url = "{{ route('foxproDataImport.leftProductStockImport') }}";
    $.get(url,function(data){
         $("#step3View").html(data);
    });
}

function importLatestStock(){
    var url = "{{ route('foxproDataImport.insertProductsInProductStock') }}";
    $.ajax({
        url : url,
        method:"POST",
        data : {
            _token : "{{ csrf_token() }}",
        },
        beforeSend:function(){
            $(".pcoded-content").LoadingOverlay("hide");
            $("#inProgressMsgStep3").show();
            $("#errorMsgStep3").hide();
        }, 
        complete:function(){
            $("#inProgressMsgStep3").hide();
        }, 
        success:function(data){
           if(data.success){
            $("#tableImportSuccessStep3").show();
            leftProductStockImport();
           }
           if(data.failed){
               $("#errorMsgStep3").show();
           }
        }
    });
}

</script>
@endsection