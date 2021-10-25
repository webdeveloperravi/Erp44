<div class="progress progress-xl" id="errorMsgStep3" style="display:none;"> 
    <div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Please Complete Step 2 First</h5></div>
</div> 
<div class="col-md-5 align-items-end"> 
    <div class="progress progress-xl" id="inProgressMsgStep3" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-warning" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Operation in Progress Please Wait...</h5></div>
    </div> 
    <div class="progress progress-xl" id="tableImportSuccessStep3" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Step 3 Complete</h5></div>
    </div> 
    @if ($itemsCount == 0)
    <div class="progress progress-xl"> 
        <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Product Stock Up to Date</h5></div>
    </div> 
    @else
    <h1>{{ $itemsCount }}</h1>
    <button class="btn btn-warning mx-auto" id="" onclick="importLatestStock()">Import Into Product Stock</button>  
    @endif
</div>