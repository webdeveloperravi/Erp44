{{-- <div class="body">
  <div id="new">
      <select  class="form-control" name="grade_id">
        <option selected >Choose Grade</option>
       
          @foreach($grade_data as $gkey => $gval)
            @if(!empty($assign_data) )
              @if(!array_key_exists($gkey, $assign_data->toArray()))
              <option value="{{ $gkey }}" >{{ $gval }}</option>
              @endif
            @else
                <option value="{{ $gkey }}" >{{ $gval }}</option>

            @endif
          @endforeach
       </select>
     </div>
     @php  
  echo "<script> $('#grade_option').html($('#new').html()); $('#new').hide();
      </script>";
     @endphp
       <div id="rate">
        <select  class="form-control" name="rate_profile_id">
        <option selected >Choose Rate Profile</option>
          @foreach($rateprofiles->sortBy('parent_sort') as $rkey => $rval)
            @if(!empty($assign_data) )

             @if(!in_array($rkey, $assign_data->toArray()))
              <option value="{{ $rkey }}">{{ $rval }}</option>
              @endif
            @else
                <option value="{{ $rkey }}">{{ $rval}}</option>

            @endif
          @endforeach
       </select>
     </div>
      @php

      echo "<script> $('#rate_option').html($('#rate').html()); $('#rate').hide(); 
        /*$('#grade-table').DataTable();*/
         </script>";


      // if(!empty($assign_data))
      // {
      //    dump($assign_data);
      // }
      @endphp
       <!--Assigned Grade And Rate Profile ---- Start Div--> --}}

     {{-- <div class="form-row m-t-10"> --}}
    {{-- <div class="form-group col-md-12">
       <h4 class="bg-transparent m-l-10"><small class="text-success text-uppercase">Assigned</small> - Grade And Rate Profile </h4>
      
 @if(!empty($assign_data))
 
        <ul>
        @foreach($assign_data as $akey => $aval)
          <div class="row">
           <div class="col md-12"> 
          <li class="list-group-item list-group-item-success m-10 z-depth-bottom-1 text-uppercase text-facebook text-danger font-weight-bold">
            <div class="row">
                 <div class="col md-1">
                   {{ $grade_data[$akey] }}
                 </div>

                 <div class="col md-4">
                   {{$rateprofiles[$aval]}} 
                 </div>

                 <div class="col-md-5">
                    <div id="profile_{{$akey}}" style="display: none">
                             <form id="update_form_{{$akey}}">
                              @csrf
                            <input type="hidden" name="product_id" value="{{$id}}">
                             <input type="hidden" name="grade_id" value="{{$akey}}">
                             @foreach($cate_grade_rate as $key =>$pgrf_val)

                                     <input type="hidden" name="id" value="{{$pgrf_val->id}}">
                                    
                               @endforeach

                             <div class="row">
                              <div class="col-md-9">
                                   <select class="form-control" name="rate_profile_id" id="profile_hide_show_{{ $akey }}">
                                   <option>Choose Rate Profile</option>
                                   @foreach($rateprofiles as $rp_key =>$rp_val)
                                         @if(!empty($assign_data) )
                                          @if(!in_array($rp_key, $assign_data->toArray()))
                                           <option value="{{ $rp_key }}" >{{ $rp_val }}1</option>
                                           @endif
                                            @else
                                           <option value="{{ $rp_key }}" >{{ $rp_val }}11</option>
                                           @endif
                                   @endforeach
                                  </select>
                               </div>
                               <div class="col-md-1">
                                <button  class="btn btn-sm btn-warning p-1 form-control" style="width:60px;" value="Update" onclick="updateCate('update_form_'+{{$akey}},{{$id}})" id="update_btn_id_{{$id}}">Update </button>
                                 
                               </div>
                               <div class="col-md-2">
                                    
                               </div>
                             </div>
                              <span class="m-r-20">
                                    <i onclick="$('#grade_{{$akey}}').show(); 
                                      $('#profile_{{ $akey }}').hide();
                                     " class="fas fa-times text-danger"> </i>
                                     </span>
                              

                              
                                    

                                 
                               
                        </form>  
                     </div>
                 </div>
                 <div class="col md-2">     
           <button class="btn btn-sm btn-warning p-1 float-right m-r-10" style="width:60px;" onclick="editGradeProfile('grade_'+{{$akey}} ,'profile_'+{{$akey}})" id="grade_{{$akey}}"> edit </button>
               </div>
          </div>
            
        
          </li>
        </div>
      </div>
          @endforeach


          
       </ul> 
  @endif
    
    </div> --}}
      
    
  {{-- </div> <!--Assigned Grade And Rate Profile ---- Start Close--> --}}

  <hr/>

     <!---Un Assigned Grade And Rate Profile ---- Start Div-->
  {{-- <div class="form-row">
    <div class="form-group col-md-6">
       <h4 class="text-center bg-faded">Grade - <small class="text-uppercase text-secondary" >Un-Assigned</small></h4>
       <ul id="un_assignd_grade">

        @foreach($grade_data as $gkey => $gval)

        

        @if( !empty($assign_data))

        @if(!array_key_exists($gkey, $assign_data->toArray()))
          <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{ $gval }}</li>
        @endif
        @else
           <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{ $gval }}</li>
        @endif

        @endforeach
       </ul>
      
    </div>
      <div class="form-group col-md-6">
       <h4 class="text-center bg-transparent">Rate Profile - <small class="text-uppercase text-secondary" >Un-Assigned</small></h4>
       <ul id="un_assignd_rate">
          @foreach($rateprofiles->sortBy('parent_sort') as $rp_key =>$rp_val)

          @php
          //dump($rp_key, $assign_data->toArray());
        @endphp

            @if(!empty($assign_data))

              @if(!in_array($rp_key, $assign_data->toArray()))
                <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{$rp_val}} </li>
              @endif
            @else

              <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{$rp_val}} </li>
          @endif
          @endforeach
       </ul>
    </div>  
  </div>  <!---Un Assigned Grade And Rate Profile ---- Close Div --> --}}




</div>