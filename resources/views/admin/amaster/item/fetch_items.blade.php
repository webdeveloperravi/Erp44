@php  
    use App\Helpers\Helper;
     $create=$edit=$view=$delete=1;
      if(Auth::guard('warehouse')->check())
      {    
              
           $permission_data=  Helper::getDepartment(Session::get('guard_id'));
         if($permission_data)
         {
            $create= $permission_data['create'];
             $view= $permission_data['view'];
              $edit= $permission_data['edit'];
               $delete= $permission_data['delete']; 
         }
      }
      
     
@endphp
<table class="table table-stripped" style="margin-top: 20px;" cellspacing="0" width="100%" id="item_table">  
	<thead class="bg-primary text-white">'

		<tr>
			<th>Sr</th>
				<th>Product Type</th>
				<th>Colors</th>
				<th>Clarity</th>
				<th>Grades</th>
				<th>status</th>
				<th>Action</th>
			</tr>
			</thead>


		<tbody id="item_tbody">
			  @if(!$items->isEmpty())
			@foreach($items as $item_key => $item_val)
			<tr>
				<td>{{$loop->iteration}}</td>
                <td>{{$item_val->category->name ?? ""}}</td>
				<td>{{$item_val->color->color ?? ""}}</td>
				<td>{{$item_val->clarity->clarity ?? ""}}</td>
				<td>{{$item_val->grade->grade ?? ""}}</td>
				
				<td class="text-success">{{($item_val->status==1?"Active":"In-active")}}</td>
				<td> 
					<!-- <a href="{{route('items.status',['id'=>$item_val->id , 'status'=>$item_val->status])}}" class='btn btn-warning btn-sm p-1' style="width:60px;">{{ ($item_val->status==1?"In-active":"Active")}} </a>  -->
					<button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$item_val->id}},'{{$item_val->status}}')"  style="width:60px;">{{($item_val->status==1?"In-active":"Active")}}</button>
					 
					   @if($view)
					    {{-- <button class="btn btn-info btn-sm p-1" data-toggle="modal" data-target=".bd-example-modal-lg" style="width:60px;" onclick="viewItem({{$item_val->id}} ,'{{$item_val->category->name}}','{{$item_val->color->color}}','{{$item_val->clarity->clarity}}','{{$item_val->grade->grade}}','{{$item_val->origin->origin}}','{{$item_val->specie->species}}','{{$item_val->shape->shape}}','{{$item_val->treatment->treatment}}','{{$item_val->sg}}','{{$item_val->ri}}','{{$item_val->length}}','{{$item_val->width}}','{{$item_val->depth}}','{{$item_val->weight}}','{{$item_val->status}}',)"> View </button>   --}}
                       @endif
				{{-- 	<a href="{{route('items.edit',['id'=>$item_val->id ,])}}" class='btn btn-sm btn-primary p-1' style="width:60px;">Edit</a>  --}}
				@if($edit)
				 <button type="button" class="btn btn-sm btn-primary p-1 btn-stock-edit" style="width: 60px;" value="{{$item_val->id}}">Edit</button>
				 @endif
				 @if($delete)
					<button class="btn btn-danger btn-sm p-1" onclick="messageDelete({{$item_val->id}})"  style="width:60px;">Delete</button>
					@endif
					</td>
                
			</tr>
			@endforeach
			  @else
             <tr>
            <td colspan="10"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
          </tr>

      @endif

		</tbody>

	</table>

