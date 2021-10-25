@extends('layouts.store.app')
@section('content')
    <div class="row">
      <div class="col-md-12"> 
         <div class="row" id="createRole">
             <div class="col-md-12">
                 <button class="btn btn-dark float-right" onclick="create()">Create Role</button>
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

    function all(){
        var url = "{{ route('manager.role.all') }}";
        $.get(url,function(data){
          $("#all").html(data);
        });
    }

    function create(){
        $("#edit").html("");
        var url = "{{ route('manager.role.create') }}";
        $.get(url,function(data){
            
           $("#create").html(data);
        });
    }

    function store(){ 

        var data = $("#createForm").serialize();
            $.ajax({
            method : "POST",
            url : "{{ route('manager.role.store') }}",
            data :  $("#createForm").serialize(),
            success : function(data){
               
               if(data.success){
                 notify('Role Successfully Created','success');
                closeCreate();
                all();
               }else{
                  $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
               }
            }, 
        });
    }

    function edit(roleId){
        $("#create").html("");
        var url = "{{ route('manager.role.edit',['/']) }}/"+roleId;
        $.get(url,function(data){
            $("#edit").html(data);
             var offset = $("#createRole").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

        });
    }

    function update(){
  
            $.ajax({
             method:"POST",
            url : "{{ route('manager.role.update') }}",
            data :  $("#updateForm").serialize(),
            success : function(data){
                // alert(data);
                if(data.errors){
                    $.each(data.errors,function(field_name,error){
                         $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                }); 
                setTimeout(hideErrors,5000); 
                    
                }else{
                    notify('Role Successfully Updated','success');
                    closeUpdate();
                     all();
                    }
            
            },
        });
    }

    function closeCreate(){
        $("#create").html("");
    }
    function closeUpdate(){
        $("#edit").html("");
    }

    function editModules(roleId){
     var url ="{{ route('manager.role.module.edit',['/']) }}/"+roleId;
     $.get(url,function(data){
         $("#editModules").html(data);

         var offset = $("#editModules").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

     });
  }

  function updateModules(){
      
      $.ajax({
          url : "{{ route('manager.role.module.update') }}",
        method : "POST",
        data : $("#editModulesForm").serialize(),
        success : function(data){ 
             all();
             $("#editModules").html("");
             notify('Modules Updated Successfully','success');
        },
      });
  }
</script>
@endsection