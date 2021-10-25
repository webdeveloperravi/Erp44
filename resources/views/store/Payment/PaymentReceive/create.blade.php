<div class="card-footer p-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Receive Payment</h5>
 </div>
 <div class="card-body">
    <form  onsubmit="event.preventDefault();" id="createForm">
       @csrf
       <div class="row">
          
          <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">Date</label>
                <input type="text" name="date" class="form-control"  id="date1" value="{{ Carbon\Carbon::now()->isoFormat('DD-MM-YYYY') }}">
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">From Store</label>
                <select class="js-example-basic-single col-sm-12" name="from_store" id="storesList" onchange="getStoreAccounts(this.value)">
                   <option value="0">Select Store</option>
                   @foreach ($stores as $store)
                   <option value="{{ $store->id }}">{{ $store->company_name ?? ""}} ({{ $store->primaryAddress->city->name ?? ""}})</option>
                   @endforeach
                </select>
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">From Store Account</label>
                <select class="form-control" name="from" id="accountsList">
                   <option value="0">Select Account</option>
                </select>
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">UTR/Ch Number</label>
                <input type="text" class="form-control" id="gin" placeholder="UTR/Ch.Number" name="reference_number">
               </div>
          </div>
         <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">To Payment Mode</label>
                <select class="form-control" name="payment_mode" onchange="getPaymentModeAcounts(this.value)">
                   <option value="0">Select Payment Mode</option>
                   @foreach ($paymentModes  as $mode) 
                   @if ($mode->id == 1)
                   <option value="{{ $mode->id }}">Cash-In-Hand</option>
                   @else
                   <option value="{{ $mode->id }}">{{ $mode->name }}</option> 
                   @endif
                   @endforeach
                </select>
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="parentId">To Payment Account</label>
                <select class="form-control" name="to" id="paymentModeAccountsList"  onchange="getBalance(this.value)">
                   <option value="0">Select Payment Account</option> 
                </select>
                
                <span id="balance"></span> 
             </div>
          </div>  
          <div class="col-md-3">
             <div class="form-group">
                 <label for="parentId">Amount</label>
                 <input type="number" class="form-control" id="gin" placeholder="Amount" name="amount">
                </div>
            </div>
            
         <div class="col-md-3">
         </div>
         <div class="col col-xl-6 col-md-3">
            <div class="form-group">
              <label for="parentId">Comment</label>
          <textarea rows="1" name="comment" placeholder="enter Comment" id="comment"  class="form-control"></textarea>
            </div> 
         </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="parentId" class="invisible d-block">Hidden</label>
                    <button type="button" class="btn btn-inverse btn-sm" onclick="store()">Save</button>
                </div>
            </div>  
        </div>  
         </div> 
    </form>
    <div id="lastTransactions">
    </div>  
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>   