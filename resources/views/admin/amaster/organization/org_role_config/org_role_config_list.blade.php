@php
use App\Model\Admin\Organization\OrgRole;
@endphp
<table class="table table-bordered tbl_org_role_config">
<thead>
<tr>
<th>Org Role Name</th>
<th>Retail Model</th>
<th>Tax Type</th>
<th>Unit</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@if($org_role_config->isEmpty())
<td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
@else
@foreach($org_role as $role_val)
<tr>
<td> 
@if(in_array($role_val->id, $org_role_config->toArray()))
{{$role_val->name}}
@endif

</td>
<td>
<!----Neseted Table For Discount---Rate-- Start--->
<table class="table table-bordered">
@if($role_val->retailModel()->exists())
@foreach($role_val->retailModel as $dis_val )
<tr>
<td class="m-l-20">{{$dis_val->name ?? ""}}</td>
</tr>
@endforeach
@endif
</table>
<!----Neseted Table For Discount---Rate-- Close--->
</td>
<!-------Tax Type Table ---Start-->
<td>
<table class="table table-bordered">
@if($role_val->taxType()->exists())
@foreach($role_val->taxType as $dis_val )
<tr>
<td class="m-l-20">{{$dis_val->name ?? ""}}</td>
</tr>
@endforeach
@endif
</table>
</td>
<!-------Tax Type Table ---Close-->


<!-------Unit Table ---Start-->
<td>
<table class="table table-bordered">
@if($role_val->unit()->exists())
@foreach($role_val->unit as $dis_val )
<tr>
<td class="m-l-20">{{$dis_val->name ?? ""}}</td>
</tr>
@endforeach
@endif
</table>
</td>
<!-------Unit Table ---Close-->


<!-------Unit Table ---Start-->
<td>
<table class="table table-bordered">
@if($role_val->unit()->exists())
@foreach($role_val->unit as $dis_val )
<tr>
<td>  <button class="btn btn-sm btn-primary p-1" style="width:60px;" onclick="editOrgRoleConfing({{$role_val->id}})"> edit</button></td>
</tr>
@endforeach
@endif
</table>
</td>
<!-------Unit Table ---Close-->

</tr>
@endforeach
@endif
</tbody>

</table>