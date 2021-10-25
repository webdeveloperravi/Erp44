@extends('layouts.store.app')
@section('content')
    <div class="row">
      <div class="col-md-12"> 
         <div class="row">
             <div class="col-md-12">
                 <button class="btn btn-dark float-right" onclick="create()">Create Account Group</button>
             </div>
         </div> 
      </div>
    </div>
    <div id="create" class="mt-3"></div>
    <div id="edit" class="mt-3"></div>
    <div id="all" class="mt-3"></div>
    <div id="editModules" class="mt-3"></div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        all();
    });
        function create(){
           
        var url = "{{ route('store.accountGroup.create') }}";
        $.get(url,function(data){
           $("#create").html(data);
        });
    }
     function all(){
            var url = "{{ route('store.accountGroup.all') }}";
        $.get(url,function(data){
          $("#all").html(data);
        });
    }

    function edit(groupId){
        $("#create").html("");
        var url = "{{ route('store.accountGroup.edit',['/']) }}/"+groupId;
        $.get(url,function(data){
            $("#edit").html(data);
        });
    }

    function addGroup(id){

      if(id==1){
       $('#parentId').attr('disabled', 'disabled');
        }
       else
       {
        $('#parentId').removeAttr('disabled');
       }

    }


   
</script>
@endsection