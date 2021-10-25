<form  onsubmit="event.preventDefault();" id="createForm">
    <div class="card-footer p-2" style="background-color: #04a9f5">
       <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Journal</h5>
    </div>
    <div class="card-body">
          @csrf
          <div class="row"> 
             <div class="col col-xl-3 col-md-3">
                <div class="form-group">
                   <label for="parentId">From</label>
                   <select class="js-example-basic-single  col-sm-12" id="from"  name="from">
                      <option value="0">Select From Account</option> 
                      @foreach ($accountGroups as $group)
                  <optgroup label="{{ $group->name ?? "" }}">
                     @foreach ($accounts as $account)
                        @if ($account->account_group_id == $group->id)
                        @if ($account->type == 'lab' || $account->type == 'org')
                        <option value="{{ $account->id }}">{{ $account->company_name }} - ({{$account->primaryAddress->city->name ?? ""}})</option>
                        @else
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endif
                        @endif
                     @endforeach 
                  </optgroup>    
                      @endforeach 
                   </select>
                </div>
             </div>  
             <div class="col col-xl-3 col-md-3">
               <div class="form-group">
                  <label for="parentId">To</label>
                  <select  class="js-example-basic-single col-sm-12" id="to"  name="to">
                    <option value="0">Select To Account</option> 
                    @foreach ($accountGroups as $group)
                <optgroup label="{{ $group->name ?? "" }}">
                   @foreach ($accounts as $account)
                      @if ($account->account_group_id == $group->id)
                      @if ($account->type == 'lab' || $account->type == 'org')
                        <option value="{{ $account->id }}">{{ $account->company_name }} - ({{$account->primaryAddress->city->name ?? ""}})</option>
                        @else
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endif
                      @endif
                   @endforeach 
                </optgroup>    
                    @endforeach 
                  </select>
               </div>
            </div> 
             <div class="col col-xl-3 col-md-3">
                <div class="form-group">
                   <label for="parentId">Date</label>
                   <input type="text" name="date" class="form-control"  id="date1" value="{{ Carbon\Carbon::now()->isoFormat('DD-MM-YYYY') }}">
                </div>
             </div>
             <div class="col col-xl-3 col-md-3">
                 <div class="form-group">
                     <label for="parentId">Amount</label>
                     <input type="text" class="form-control" id="amountFrom" placeholder="Amount" name="amountFrom">
                    </div>
                </div>
             <div class="col col-xl-3 col-md-3"> 
               <div class="form-group">
                  <label for="parentId">Comment</label>
              <textarea name="commentFrom" placeholder="enter Comment" id="comment"  class="form-control"></textarea>
                </div>  
                </div>
                <div class="col col-xl-3 col-md-3">
                  <div class="form-group">
                      <label for="">&nbsp;</label>
                      <button type="button" class="btn btn-primary btn-sm form-control" onclick="store()">Submit</button>
                  </div>
              </div> 
               
            </div> 
    </div> 
   </form>
   <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>   