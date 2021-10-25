<form onsubmit="event.preventDefault(0)" id="checkBoxForm">
    @csrf
<div class="row">
    <div class="col-md-7">

    
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                <th>Sr.</th>
                <th>Column Name</th>
                <th>Products Left To Replace</th> 
            </tr>
        </thead>
        <tbody>
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="1">
                 </td>
                 <td>Product (Igroup)</td>
                 <td>{{ $product }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="2">
                 </td>
                 <td>Color </td>
                 <td>{{ $color }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="3">
                 </td>
                 <td>Shape </td>
                 <td>{{ $shape }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="4">
                 </td>
                 <td>Clarity </td>
                 <td>{{ $clarity }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="5">
                 </td>
                 <td>Treatment </td>
                 <td>{{ $treatment }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="6">
                 </td>
                 <td>Origin </td>
                 <td>{{ $origin }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="7">
                 </td>
                 <td>Specie </td>
                 <td>{{ $specie }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="8">
                 </td>
                 <td>Grade </td>
                 <td>{{ $grade }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="9">
                 </td>
                 <td>Ratti </td>
                 <td>{{ $ratti }}</td>
            </tr> 
             <tr>
                 <td>
                     <input type="checkbox" class="form-control" name="columns[]" value="10">
                 </td>
                 <td>Rate Profile </td>
                 <td>{{ $rateProfile }}</td>
            </tr> 
        </tbody>
    </table>
</div>
</div>
<div class="col-md-5 align-items-end">
    <div class="py-5"></div>
    <div class="progress progress-xl" id="inProgressMsgStep2" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-warning" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Operation in Progress Please Wait...</h5></div>
    </div>
    <div class="progress progress-xl" id="warningMsgStep2" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Please Select atleast 1 Column</h5></div>
    </div> 
    <div class="progress progress-xl" id="tableImportSuccessStep2" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Step 2 Complete</h5></div>
    </div> 
    <button class="btn btn-warning mx-auto" id="storeTablesBtn" onclick="columnsReplaceWithErpId()">Replace With ERP IDs</button>  
</div>
</div>
</form> 
