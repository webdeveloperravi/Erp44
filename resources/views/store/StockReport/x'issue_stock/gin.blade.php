<form id="addGin" onsubmit="event.preventDefault()">
    @csrf
<div class="col-xl-4 col-md-6 col-12 mb-1">
    <div class="form-group">
    <label for="basicInput">Enter Gin</label>
    <input type="hidden" id="ledgerId" name="ledgerId" value="{{ $ledger->id }}">
    <input name="gin" id="gin" type="number" class="form-control"  placeholder="Gin" />
    </div>
    <div class="form-group">
        <button class="btn btn-primary" onclick="addGin()">Add</button>
    </div>
</div> 
</form> 
<div id="allGins"></div>
<button onclick="saveAll()">Final Submit</button>
<script>
    function addGin(){ 
       $.ajax({
          url : "{{ route('stockLedger.issueStock.addGin') }}",
          method : "POST",
          data : $("#addGin").serialize(),
          success: function(data){
             getGins(); 
          }
       });
    }
    function getGins(){
         var ledgerId = $("#ledgerId").val();
         var url = "{{ route('stockLedger.issueStock.getGins',['/']) }}/"+ledgerId;
         $.get(url,function(data){
           $("#allGins").html(data);
         });
    }
</script>