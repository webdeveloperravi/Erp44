<div id="Shape_{{$cat_id}}" style="display: none" class="list" >
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="shape">
			<h5 class="msgr">Shape</h5>
<div class="row"> 			
	<div class="col-sm" > 
		<!-- <h5> Select <- </h5> -->
		<span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='shape_{{$cat_id}}_right'> 
			@forelse($assigned_shape->sortBy('shape') as $assignKey => $assignVal) 
			<li  onclick="move('mshape_'+{{$assignVal->id}}{{$cat_id}} , 'shape_'+{{$cat_id}}+'_')" direction="left" id="mshape_{{$assignVal->id}}{{$cat_id}}"class="z-depth-0 p-2 m-2 sel" style="background-color: darkseagreen;
    opacity: 1.5;">  {{$assignVal->shape}}
				<input class="mshape_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			@empty 

			@endforelse 
		</ul>
	</div>
	<div class="col-sm" >
	<!-- 	<h5> Un Select -> </h5> -->
	 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="shape_{{$cat_id}}_left">
			@foreach($shape->sortBy('shape')->whereNotIn('id',$assigned_shape->pluck('id')) as $coKey =>$coVal)
				<li  onclick="move('mshape_'+{{$coVal->id}}{{$cat_id}} , 'shape_'+{{$cat_id}}+'_')" direction="right" id="mshape_{{$coVal->id}}{{$cat_id}}" class="z-depth-0 p-2 m-2 unsel" style="background-color: lavender;
    opacity: 1.5;" > {{$coVal->shape}} 
					<input class="mshape_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div> <div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach Shape">
</div>
</div>
</form>
</div>