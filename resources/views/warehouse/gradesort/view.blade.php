
  @if(!empty($gradeSort)) 
  @if($gradeSort->count() > 0)  
  <div class="card"><!--Card Start-->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Grade Sort View</h5>
   </div>
  <div class="card-body p-0">
    <div class="table-responsive ">
    <table class="table table-bordered ">
    <thead>
    <tr class="table-active">
    <th>S.No</th> 
    <th>Grade</th>
    <th>Weight</th>
    <th>Piece</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
      
      @foreach ($gradeSort as $sort)
      <tr class="text-center">
        <td><label>{{$loop->iteration }}</label></td>
        <td><label>{{ $sort->grade->grade }}</label></td>
        <td><label>{{ $sort->carat }}</label></td>
        <td><label>{{ $sort->piece }}</label></td>
        {{-- <td><label>110</label></td> --}}
        <td>
         
        @if(!$sort->gradeProdctsCount($sort->id))
        
      @if($generateIdPossible)
          @if(\App\Helpers\CheckPermission::instance()->viewAction('generate-id'))
           <button type="button" id="disbtn" class="btn btn-info btn-sm" onclick="generateProducts({{ $sort->id }})">Gernate ID</button>
           @endif
        @endif
          @if(\App\Helpers\CheckPermission::instance()->viewAction('gradesort-edit'))
           <button type="button" class="btn btn-warning btn-sm"  onclick="edit(event,{{ $sort->id }})">Edit</button>
          @endif
        @if(\App\Helpers\CheckPermission::instance()->viewAction('gradesort-delete'))
         <button type="button" class="btn btn-danger btn-sm" onclick="deleteGrade({{$sort->id}})">Delete</button>
        @endif
      @else  
        <button type="button" class="btn btn-success btn-sm" disabled>Products Generated</button>
        @if(\App\Helpers\CheckPermission::instance()->viewAction('print-label'))
         <a href="{{ route('gradesort.product.print.pdf',$sort->id) }}"><button type="button" class="btn btn-secondary btn-sm">Export Pdf</button></a>
        @endif
        @if(\App\Helpers\CheckPermission::instance()->viewAction('print-label'))
         <a href="{{ route('gradesort.product.export.excel',$sort->id) }}"><button type="button" class="btn btn-secondary btn-sm">Export Excel</button></a>
        @endif
        @endif
        
        @if ($sort->managerChallanIssued($sort->id)) 
        <button type="button" class="btn btn-danger btn-sm" disabled>Issued to Manager</button>
        @else
        @if($sort->gradeProdctsCount($sort->id))
        {{-- @if(\App\Helpers\CheckPermission::instance()->viewAction('issue-to-manager-for-weight')) --}}
        <button type="button" class="btn btn-primary btn-sm" onclick="IssueToManager({{ $sort->id }})">Issue to Manager</button>
        {{-- @endif --}}
        @endif
        @endif
        {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Issue to Manager</button> --}}
        {{-- <button type="button" class="btn btn-success btn-sm">Received from Manager</button> --}}
        </td>
        </tr>
      @endforeach
    
   
    </tbody>
    </table>
    </div>
  </div>
  </div>
  @endif
  <!--Card End-->

<!--Modal Part-->
<div class="modal-part">
  
</div> 

 @endif

 