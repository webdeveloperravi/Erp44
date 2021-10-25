@extends('layouts.admin.app')
@section('css')
  <style>
    input[type=checkbox]{
      width: 20px;
      height: 20px;
    }
  </style>
@endsection
@section('content') 
<div class="container">
  <div class="success_msg" style="display:none">
  </div>
  <div class="card">
    <div class="card-header">
      <h4 text-center>Attach Modules and Permissions : {{$role->name}} </h4>
       
    </div>
    <div class="card-block table-border-style">
      <div class="table-responsive">
        <form action="{{route('admin.role.module.store')}}" method="post">
          @csrf
          <table class="table table-styling">
            <thead>
              <tr class="table-primary">
                <th>#</th>
                <th>Modules</th>
                <!-- <th>Create</th>
                <th>Read</th>
                <th>Update</th>
                <th>Delete</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach($modules->sortBy('child_sort') as $module1)
                
               @foreach($module1->sub_module as $module)
                 @if($module->route!='')
               <tr>
                <td><input type="checkbox" data-level="parent" name="modules[{{$module->id}}]" value="{{$module->id}}"></td>
                <td>{{$module->title}}<input type="hidden" name="role_id" value="{{$role_id}}"></td>
                <ul>  
                 <!--  <td class="crud_table"><input type="checkbox" data-level="child"  name="modules[{{$module->id}}][create]"></td>
                  <td class="crud_table"><input type="checkbox" data-level="child"  name="modules[{{$module->id}}][read]"></td>
                    <td class="crud_table"><input type="checkbox" data-level="child"  name="modules[{{$module->id}}][update]"></td>
                    <td class="crud_table"><input type="checkbox" data-level="child"  name="modules[{{$module->id}}][delete]"></td> -->
                </ul>      
              </tr>
              @endif

              @endforeach
              @endforeach
            </tbody>
          </table>
          <button class="btn btn-success mt-5 float-right mr-5 mb-4" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div> 
@endsection
@section('script')
<script type="text/javascript">
// $('.crud_table').on('click', function(){
//    var checkbox = $(this).children('input[type="checkbox"]');
//    checkbox.prop('checked', !checkbox.prop('checked'));
// });

// ########################### for click child to check parent ###########################
$('input[type=checkbox][data-level="child"]').click(function (event) {
        var checked = $(this).is(':checked');
        if (checked) { 
          //when child checked
            $(this).closest('td').parent().children('td').first('td').children('input[type=checkbox][data-level="parent"]').prop('checked', true); 
        } else { //when child un-checked
            var countcheckedchild =  $(this).parent().parent().find('input[data-level="child"]:checked').length;

            if (countcheckedchild == 0)
            {                            
                $(this).closest('td').parent().children('td').first('td').children('input[type=checkbox][data-level="parent"]').prop('checked', false); 
            }
        }
});
$('input[type=checkbox][data-level="parent"]').click(function(event){
    $(this).parent().parent().find('input[data-level="child"]:checked').prop('checked',false);
});
</script>
@endsection