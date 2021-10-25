<div class="table-responsive">
			<table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
				<thead>
					<tr class="text-center">
						<th>Sr</th>
						<th>image</th>
						<th>Name</th>
						<th>Alias</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> 
				@if($product_type->isNotEmpty())
				@foreach($product_type as $val)
                <tr class="text-center">
				<td> {{$loop->iteration}}</td>
				<td><img  src="{{$val->image}}" class="img img-thumbnail" width="100"> </td>
				<td>{{$val->name}} </td>
				<td>{{$val->alias}} </td>
				<td class="text-success">
				@if ($val->status == 1)
				<button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$val->id}},0)"  style="width:60px;">Disable</button>
				@else
				<button class="btn btn-success btn-sm p-1 float-right" onclick="changeStatus({{$val->id}},1)"  style="width:60px;">Enable</button>
				@endif	
				</td>
				
				<td> 
					<a href="{{route('product.type.edit',['id'=>$val->id])}}" class="btn btn-sm btn-primary p-1" style="width:60px">Edit</a>
					<button class="btn btn-sm btn-primary p-1"  onclick="masterAttachView({{$val->id}})">Attach Masters</button>
					<button class="btn btn-sm btn-primary p-1"  onclick="unitAttachView({{$val->id}})">Attach Units</button>

					{{-- <a href="{{route('product.type.unit',['id'=>$val->id,'assign' =>$val->assign])}}"  class='btn btn-success btn-sm p-1' style="width:120px;"> Unit - {{ $val->assign==1 ? 'Assigned' : 'Un-Assigned' }}</a>
					 --}}
				</td> 

			</tr>
			@endforeach 
           @endif 
				</tbody>
			</table>
		</div>
		





     
