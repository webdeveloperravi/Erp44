<div id="Grade_{{$cat_id}}" style="display: none;" class="list" >
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
	
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="grade">
			<h5 class="msgr">Grade</h5>
<div class="row">

	<div class="col-sm" > 
		<!-- <h5> Select <- </h5> -->
		<span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='grade_{{$cat_id}}_right'> 
                  
			@forelse($assigned_grade->sortBy('parent_sort') as $assignKey => $assignVal) 
                          
                         @if($assignVal->assignCategoryGrade()->where(['grade_id'=>$assignVal->id,'product_id'=>$cat_id])->exists())
             <li class="z-depth-0 p-2 m-2 sel bg-danger" style="background-color: darkseagreen;
    opacity: 1.5;"> {{$assignVal->grade}}</li>
                        @else
                       	<li  onclick="move('mgrade_'+{{$assignVal->id}}{{$cat_id}} , 'grade_'+{{$cat_id}}+'_')" direction="left" id="mgrade_{{$assignVal->id}}{{$cat_id}}" class="z-depth-0 p-2 m-2 sel" style="background-color: darkseagreen;
    opacity: 1.5;"> 
             
                    {{$assignVal->grade}}
			           
                   
     
  

 
				<input class="mgrade_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			    @endif
		
			@empty 
				
			@endforelse 
			
		</ul>
	</div>
	<div class="col-sm" >
		<!-- <h5> Un Select -> </h5> -->
			 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="grade_{{$cat_id}}_left">
			@foreach($grade->sortBy('parent_sort')->whereNotIn('id',$assigned_grade->pluck('id'))->sortBy('parent_sort') as $coKey =>$coVal)

				<li  onclick="move('mgrade_'+{{$coVal->id}}{{$cat_id}} , 'grade_'+{{$cat_id}}+'_')" direction="right" id="mgrade_{{$coVal->id}}{{$cat_id}}" class="z-depth-0 p-2 m-2 unsel" style="background-color: lavender;
    opacity: 1.5;"> {{$coVal->grade}} 
					<input class="mgrade_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div>
<div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach Grade">
</div>
</div>
</form>
</div>