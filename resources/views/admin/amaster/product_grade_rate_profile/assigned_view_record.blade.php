<table  class="table  table-bordered" id="grade-table">
  <thead class="bg-primary text-white">
     <tr>
        <th>Category Name </th>
        <th colspan="2">Grade Name <span style="margin-left: 22%"> Rate Profile Name</span>
        </th>
     </tr>
  </thead>
  <tbody>
     @php 
     // dump($grade_assign);
     // dump($profile_assign,$profile_unassign);
     @endphp
     @foreach($cat as $ckey => $cval)
     @if(empty($grade_unassign) && !$cval->grade()->exists()) 
     @continue
     @endif
     @if(empty($grade_assign) && $cval->grade()->exists())
     @continue
     @endif
     <tr>
        <td>  {{ $cval->name }}</td>
        <td>
           @if($cval->grade()->exists() && !empty($grade_assign))
           <table class="table  table-bordered">
              @foreach($cval->grade->sortBy('parent_sort') as $gkey => $gval)
              @php
              $profile = $gval->assignProfile()
              ->where(['product_id'=>$cval->id,'grade_id'=>$gval->id]);
              //dump($profile->first());
              @endphp
              @if(empty($profile_assign) && $profile->exists() )
              @continue
              @endif
              @if(empty($profile_unassign) && !$profile->exists() )
              @continue
              @endif
              <tr>
                 <td>{{-- {{ $gval->id }}- --}}{{ $gval->grade }}  </td>
                 <!--Rate profile data--->
                 <td>
                    @if($profile->exists())
                    {{$profile->first()->assignRateProfile->name}}
                    @else
                    <span class="bg-danger p-2"> un-assigned</span>
                    @endif
                 </td>
              </tr>
              @endforeach
           </table>
           @elseif(!empty($grade_unassign)) 
           <span class="bg-danger p-2"> un-assigned</span>
           @endif
        </td>
     </tr>
     @endforeach
  </tbody>
</table>