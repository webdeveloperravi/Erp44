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
  <a href="{{route('receiveChallan.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  

<div class="card" id="all">

</div>

 
@endsection
@section('script')
<script>
    all(); 
    function all(){
        var url = "{{ route('receiveChallanUpdate.all',['/']) }}/"+"{{ $receiveChallan->id }}"; 
        $.get(url,function(data){
            $("#all").html(data);
        });
    }

    function addProduct(){
        var url = "{{ route('receiveChallanUpdate.addProduct') }}";
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
            }
        });
    }

    // function deleteProduct(ledgerDetailId){
    //     var url = "{{ route('receiveChallanUpdate.deleteProduct',['/']) }}/"+ledgerDetailId;
    //     $.get(url,function(data){
    //         notify('Product Deleted Success','success');
    //         all();
    //     });
    // }

    
    function deleteProduct(ledgerDetailId){
        swal({
            title: "Are you sure?",
            text: "You want to remove this product from Receive Challan",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
        .then((willDelete) => {
        if (willDelete) {
            var url = "{{ route('receiveChallanUpdate.deleteProduct',['/']) }}/"+ledgerDetailId;
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
 