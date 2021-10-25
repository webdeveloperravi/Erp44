@extends('layouts.store.app')
@section('content')
<div class="card">
 <div class="card-body">
    <div class="row">
    <div class="col col-xl-4 col-md-3">
        <div class="form-group">
            <label for="parentId">Enter GIN Number:</label>
            <input  type="number" id="gin" class="form-control" onkeypress="javascript: if(event.keyCode == 13) getTimeline();" autocomplete="off">
        </div>
    </div> 
    <div class="col col-xl-4 col-md-4">
<div class="form-group">
<label for="parentId" class="invisible d-block">Hidden</label>
<button class="btn btn-sm btn-dark"  onclick="getTimeline()">Fetch to Update</button>
</div>
</div>  
   
</div>  
</div> 
</div>
<div id="view">
</div>    
@endsection
@section('script')
<script>
    $("#gin").focus();
    function getTimeline(){ 
        var gin  = $("#gin").val();
        if(gin > 0){

        var url = "{{ route('productStockUpdate.getDetail',['/']) }}/"+gin;
        $.get(url,function(data){ 
            // $("#gin").val('');
            $("#view").html(data);
        });
        }
    }
   
    function update(){
        var url = "{{ route('productStockUpdate.update') }}";
        $.ajax({
            url : url,
            method:'POST',
            data: $('#updateForm').serialize(),
            success:function(data){ 
                if(data.success){
                  getTimeline();
                 swal(data.msg);
                }else{
                    notify(data.msg,'danger');
                }
            }
        });
    }
</script>
@endsection