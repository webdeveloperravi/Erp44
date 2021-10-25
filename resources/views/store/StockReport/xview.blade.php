<div class="card" id="form">
    <!--Header ---->

    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Stock Transactions</h5>
     </div>
    
    <div class="card-body">

      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="createForm" onsubmit="event.preventDefault();">
     <div class="row">
              @csrf
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="ifscCode">Select Account</label>
                    <select class="form-control" onchange="getLedger(this.value)">
                    <option value="0">Select Account</option> 
                    @foreach ($accounts as $account)
                    @if ($account->id == auth('store')->user()->id) 
                     <option value="{{ $account->id }}">{{ $account->name }}</option>
                     @else   
                     <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endif
                  @endforeach
                  </select>
                </div>
               </div>     
          </div>
     </form>
  </div>
  <div id="ledgerView" class="mt-3">

</div> 
 </div>