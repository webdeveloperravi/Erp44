<div class="card">
  <!--Header ---->
  <div class="card-footer " style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-center">Clear Cheque</h5>
  </div>
  <div class="card-body">
     <form id="createForm" onsubmit="event.preventDefault();">
        @csrf  
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
               <label for="parentId">From Store</label>
               <select class="js-example-basic-single col-sm-12" name="store" id="storesList" onchange="getStoreAccountsFrom(this.value)">
                  <option value="0">Select Store</option>
                  @foreach ($stores as $store)
                  <option value="{{ $store->id }}">{{ $store->company_name ?? "" }} ({{ $store->primaryAddress->city->name ?? "" }})</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="col-md-3">
            <div class="form-group">
               <label for="parentId">From Store Account</label>
               <select  class="js-example-basic-single col-sm-12"  name="accountFrom" id="accountsListFrom"> 
                  <option value="0">Select Account</option>
               </select>
            </div>
         </div> 
           <div class="col-xl-4 col-md-6 col-12 my-auto">
              <div class="form-group mt-lg-4"> 
                 <button class="btn btn-inverse" onclick="getCheques()">Get</button> 
              </div>
           </div>
        </div>
           <div id="cheques">

           </div>
           
        </div>
     </form>
  </div>
</div>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>   
<script>
  

  function getStoreAccountsFrom(storeId){
      if(storeId != 0){
       var url = "{{ route('paymentIssue.getStoreManagers',['/']) }}/"+storeId;
       $.get(url,function(data){
          $("#accountsListFrom").html(data);
          
         });
      }
    }

  function getStoreAccountsTo(storeId){
      if(storeId != 0){
       var url = "{{ route('paymentIssue.getStoreManagers',['/']) }}/"+storeId;
       $.get(url,function(data){
          $("#accountsListTo").html(data);
          
         });
      }
    }

    function getCheques(){

var url ="{{route('chequeClear.getCheques')}}";
// var formData = $("#createFrom").serialize(); 
$.ajax({
      
     url : url, 
     method : "POST",
     data : {
        account : $("#accountsListFrom").val(),
        _token : "{{ csrf_token() }}",
     },
   success : function(data){
              
                $("#cheques").html(data); 
             }  
      });
  }

</script>