<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
 <div class="card">
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Grade Rate Profiles : {{ $product->name }} </h5> 
   </div>

    <div class="card-body">
       <div class="table-responsive">
          <table class="table" id="table_id21" style="width:100">
             <thead>
                <tr> 
                   <th>UID</th>
                   <th>Grade</th>
                   <th>Rate Profile</th> 
                   <th>Action</th> 
                </tr>
             </thead>
             <tbody>
                 @foreach ($product->assignProductGradeRateProfile as $profile)
                 <tr> 
                     <td>{{ $profile->id }}</td> 
                     <td>{{ $profile->getGrade($profile->grade_id)->grade }}</td> 
                     <td>{{ $profile->getRateProfile($profile->rate_profile_id)->name }}</td> 
                     <td><button  onclick="editRateProfile({{ $product->id }},{{ $profile->getGrade($profile->grade_id)->id }},{{ $profile->getRateProfile($profile->rate_profile_id)->id }})">Edit</button>
                        @if(in_array($profile->grade_id,$duplicateGradeData))
                        <button  onclick="changeStatus({{$profile->id}})">Disable</button></td> 
                          @endif</td> 
                  </tr>
                @endforeach
             </tbody>
             <tfoot>
                <tr>
                    <th>UID</th>
                    <th>Grade</th>
                    <th>Rate Profile</th> 
                    <th>Action</th> 
                </tr>
             </tfoot>
          </table>
       </div>
    </div>
 </div> 

 <div class="form-row">
    <div class="form-group col-md-6">
       <h4 class="text-center bg-faded">Grade - <small class="text-uppercase text-secondary" >Un-Assigned</small></h4>
       <ul id="un_assignd_grade">
         @foreach ($unsignedGrades as $grade)
         <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{ $grade->grade }}</li>
         @endforeach
       </ul>
      
    </div>
      <div class="form-group col-md-6">
       <h4 class="text-center bg-transparent">Rate Profile - <small class="text-uppercase text-secondary" >Un-Assigned</small></h4>
       <ul id="un_assignd_rate">
          @foreach($unsignedRateProfiles as $profile)
                <li class="list-group-item list-group-item-secondary m-10 z-depth-bottom-1">{{ $profile->name }} </li>
          @endforeach
       </ul>
    </div>  
  </div>  <!---Un Assigned Grade And Rate Profile ---- Close Div -->
 
 <script>
     //  window.$('#table_id').DataTable();
     $(document).ready(function(){

     // Setup - add a text input to each footer cell
     $('#table_id21 tfoot th').each( function () {
         var title = $(this).text();
         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
     } );
  
     // DataTable
     var table = $('#table_id21').DataTable({
         initComplete: function () {
             // Apply the search
             this.api().columns().every( function () {
                 var that = this;
  
                 $( 'input', this.footer() ).on( 'keyup change clear', function () {
                     if ( that.search() !== this.value ) {
                         that
                             .search( this.value )
                             .draw();
                     }
                 } );
             } );
         }
     });
     });
  </script>

