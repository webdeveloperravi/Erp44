 <div class="row">
<div class="col col-md-4">
  <form id="createForm" onsubmit="event.preventDefault();">
   
              @csrf
           
                <div class="form-group">
                  @if($id==1)
                  <label for="ifscCode">Manager Accounts</label>
                  @else
                       <label for="ifscCode">Accounts</label>
                  @endif
                    <select class="form-control" onchange="getLedger(this.value)">
                      @if($id==1)
                    <option value="0">Select All Manager</option> 
                    @else
                     <option value="0">Select All Account</option> 
                    @endif
                    @foreach ($accounts as $account)
                    @if ($account->id == auth('store')->user()->id) 
                     <option value="{{ $account->id }}">{{ $account->name }}</option>
                     @else   
                     <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endif
                  @endforeach
                  </select>
                </div>
           
     </form>
   </div>  
 </div>

 
