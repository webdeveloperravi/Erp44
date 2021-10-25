<div class="card" id="form">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Issue Stock</h5>
     </div>
    
    <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
        <button type="button" class="close" data-dismiss="alert">×</button>
      <ul id="res"></ul>
    </div>
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
     <div class="row">
              @csrf
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="ifscCode">Select Account</label>
                    <select class="form-control" name="credit_to" id="accountId">
                    <option value="0">Select Account</option> 
                    @foreach ($accounts as $account)
                    @if ($account->id == auth('store')->user()->id) 
                     @continue
                     @else   
                     <option value="{{ $account->id }}">{{ $account->name}} - ( {{ $account->store->name ?? ""}} )</option>
                    @endif
                  @endforeach
                  </select>
                </div>
               </div>   
            
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="selectAccount()">Issue Stock</button>
                    {{-- <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button> --}}
                  </div>
            </div>  
            {{-- <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="saveIssueStock()">Issue Stock</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>   --}}
          </div>
     </form>
  </div>
 </div>
 <div id="ginCreate"></div>
 <script>
    function selectAccount(){
     
      var id = $("#accountId").val();
      var url = "{{ route('stockLedger.issueStock.selectAccount',['/']) }}/"+id;
      // alert(url);
      $.get(url,function(data){
            $("#ginCreate").html(data);
      });
    }

    function saveAll(){
      var ledgerId = $("#ledgerId").val();
      var url ="{{ route('stockLedger.issueStock.saveAll',['/']) }}/"+ledgerId;
      $.get(url,function(data){
          alert('success');
      });
    }
 </script>