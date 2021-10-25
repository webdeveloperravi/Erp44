<table class="table table-bordered tbl_make_type_list">
<thead>
<tr>
<th>Sr.No.</th>
<th>Name</th>
<th>Alias</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@if($make_type_list->isEmpty())
<td colspan="7"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
@else
@foreach($make_type_list as $key => $val)

<tr>
<td>{{$loop->iteration}}</td> 
<td>{{$val->name}}</td>
<td>{{$val->alias}}</td>
<td style="white-space: inherit;">{{$val->description}}</td>

<td>
    @if ($val->status == 1)
    <button class="btn btn-danger btn-sm p-1" onclick="changeStatus({{$val->id}},'{{$val->status}}')"  style="width:60px;">Disable</button>
    @else
    <button class="btn btn-success btn-sm p-1" onclick="changeStatus({{$val->id}},'{{$val->status}}')"  style="width:60px;">Enable</button>
    @endif</td> 

   
 
<td>
    <button class="btn btn-sm btn-primary p-1 " onclick="editMakeType({{$val->id}},'{{$val->name}}','{{$val->alias}}',`{{$val->description}}`)" style="width:60px;">Edit</button>
</td> 
</tr>
@endforeach
@endif
</tbody>
</table>
