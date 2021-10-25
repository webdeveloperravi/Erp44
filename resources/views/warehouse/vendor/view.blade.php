<table class="table table-bordered tbl_vendor_list">
<thead>
<tr>
<th>Sr.No.</th>
<th>Company Name</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@if($vendors->isEmpty())
<td colspan="7"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
@else
@foreach($vendors as $vendor)

<tr>
<td>{{$loop->iteration}}</td> 
<td>{{$vendor->company_name}}</td>
<td>{{$vendor->name}}</td>
<td>{{$vendor->email}}</td>
<td>{{$vendor->phone}}</td>
@if($vendor->status==0)
<td class="text-warning">In-active</td>
@else
<td class ="text-success">Active</td>
@endif
<td>
<button class="btn btn-info btn-sm p-1" onclick="status({{$vendor->id}},'{{$vendor->status}}')"  style="width:60px;">{{($vendor->status==1?"In-active":"Active")}}</button>
<a href="{{route('warehouse.vendor.show',$vendor->id)}}" class="btn btn-primary btn-sm p-1"  style="width:60px;">View</a>

</td>
</tr>
@endforeach
@endif
</tbody>
</table>
