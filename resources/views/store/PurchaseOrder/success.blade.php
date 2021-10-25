<div class="alert alert-success alert-dismissible fade show" id="hideMessage">
      <strong>Your Order Placed Successfully !</strong> Your Purchase Order Number is <b>#{{ $purchaseOrder->po_number }}</b>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<script type="text/javascript">
	setTimeout(hideMessage,5000); 
	function hideMessage(){
   $(".alert-success").remove(); 
  }
</script>

