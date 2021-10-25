 <span>Grade<i class="fas fa-arrow-down"></i></span>  
            	<ul>
     <input type="hidden" name="cate_id" value="{{ $cate_id}}">
 
    
       @foreach($grades->sortBy('parent_sort') as $grade_key => $grade_val)

      
         @if(!empty($assigned_grades))

        
       <li class="list-group-item m-b-10 m-t-10  z-depth-0" id="grade_id{{$grade_val->id}}" style="background-color: lavender; cursor: pointer;
    opacity: 1.5;"><input type="radio" name="grade_id"  value="{{$grade_val->id}}" class="m-r-20" style="cursor: pointer;" {{($assigned_grades==$grade_val->id ?'checked':'' )}}  >{{$grade_val->grade}} -{{$grade_val->id }} 
      </li>
      @else
       <li class="list-group-item m-b-10 m-t-10  z-depth-0" id="grade_id{{$grade_val->id}}" style="background-color: lavender; cursor: pointer;
    opacity: 1.5;"><input type="radio" name="grade_id"  value="{{$grade_val->id}}" class="m-r-20" style="cursor: pointer;">{{$grade_val->grade}} -{{$grade_val->id }} 
      @endif
       @endforeach
      
            	
            </ul>