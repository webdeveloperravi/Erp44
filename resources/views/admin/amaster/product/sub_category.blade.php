@foreach($sub as $nkey => $nVal)
	<div id="Child_{{$parent_id}}" class="card" style=" display:none; margin-left: 45px; border: 1px solid grey;">
		<div class="card-header">
			<h5 class="card-header-text" onclick="show('child_'+{{$nVal->id}})"> {{$nVal->name}}  </h5>

			@if(!$nVal->subcat()->exists()) 
                <a onclick="show('color_'+{{$nVal->id}})">
                    {{ ($nVal->subcat()->exists()?"":"Assign Color") }} 
                </a> 
                @include('admin.product.color',['cat_id'=>$nVal->id, 'color'=>$color,'assigned_color'=>$nVal->colors])
            @endif

			 <a onclick="show('ncat_'+{{$nVal->id}})" >+  Sub Category</a>
               <div id="ncat_{{$nVal->id}}" style="display:none;" > 
               	<form method="post" action="{{route('product.cat.store')}}"> 
               		@csrf
                    <input type="hidden" name="type_id" value="{{$pval->id}}">	
                    <input type="hidden" name="parent_id" value="{{$nVal->id}}">	
                    <input type="text" name="name" placeholder="category Name n">
                    <input type="text" name="alias" placeholder="alias name">
                    <button type="submit"> Save Category</button>
                </form>
              </div>
		</div>
		@if($nVal->subcat()->exists())
			@include('admin.product.sub_category', ['sub' => $nVal->subcat, "parent_id"=>$nVal->id ])
		@endif 
	</div>
	
@endforeach


