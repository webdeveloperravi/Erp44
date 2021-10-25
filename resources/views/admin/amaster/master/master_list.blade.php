<table class="table table-bordered tab_master_list">
<thead>
<tr class="text-left">
<th>#</th>
<th>Name</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@if($master_list->isEmpty())
<tr>
 <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
</tr>
@else
@foreach($master_list as $mas_val)
<tr>
   <td>{{$loop->iteration}}</td>  
   <td>{{$mas_val->name}}</td>  
   <td>{{$mas_val->description}}</td>  
   <td>
    @if ($mas_val->status == 1)
    <button class="btn btn-danger btn-sm p-1 " onclick="changeStatus({{$mas_val->id}},'{{$mas_val->status}}')"  style="width:60px;">Disable</button>
    @else
    <button class="btn btn-success btn-sm p-1 " onclick="changeStatus({{$mas_val->id}},'{{$mas_val->status}}')"  style="width:60px;">Enable</button>
    @endif
   </td>
   
   <td> 
  <button type="button" class="btn btn-primary btn-sm p-1" style="width:60px" onclick="show_Form('edit_master',{{$mas_val->id}},'{{$mas_val->name}}',`{{$mas_val->description}}`)">Edit</button>
</td>
</tr>
@endforeach	
@endif
</tbody>
</table>