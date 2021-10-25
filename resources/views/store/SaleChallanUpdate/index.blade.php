@extends('layouts.store.app')
@section('css')
<style>
   th {
   text-align: left !important;
   }
</style>
@endsection
@section('content')
<div class="row">
<div class="col">
  <a href="{{route('saleChallan.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  

<div class="card" id="all">

</div>

 
@endsection
@section('script')
<script>
    all();
    function all(){
        $("#gin").focus();
        var url = "{{ route('saleChallanUpdate.all',['/']) }}/"+"{{ $saleChallan->id }}"; 
        $.get(url,function(data){
            $("#all").html(data);
            $("#gin").focus();
        });
    }

    function addProduct(){
        var url = "{{ route('saleChallanUpdate.addProduct') }}";
        $.ajax({
            url : url,
            method : "POST",
            data : $("#createForm").serialize(),
            success : function(data){
                if(data.success){
                 notify('Product Added','success');
                 all();
                }
                if(!data.success){
                notify(data.msg,'danger'); 
                }
                $("#gin").val('');
                $("#gin").focus();
            }
        });
    }

    function deleteProduct(ledgerDetailId){
        swal({
            title: "Are you sure?",
            text: "You want to remove this product from Sale Challan",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
        .then((willDelete) => {
        if (willDelete) {
            var url = "{{ route('saleChallanUpdate.deleteProduct',['/']) }}/"+ledgerDetailId;
            $.get(url,function(data){
                if(data.success){ 
                     all();
                     swal("Product Remove Successfully", {
                    icon: "success",
                    });
                }else{
                    swal('! Last Record Cannot be Deleted');
                }
            });
           
        } 
        });
     
    }
</script>

@endsection
 