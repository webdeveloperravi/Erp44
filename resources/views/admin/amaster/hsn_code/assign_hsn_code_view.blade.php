<table class="table table-bordered tbl_assigned_rate">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>HSN-Code</th>
          <th>Tax Rate</th>
          <th>Created Date</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
            @if(empty($assign_hsn_rate))
            <td colspan="5"><h2 style="color:red; text-align: center;">Not Assign Tax Rate </h2></td>
           @else
             <tr>
               <td>{{$assign_hsn_rate->id}}</td>
               <td>{{$assign_hsn_rate->hsn_code_id}}</td>
               <td>{{$assign_hsn_rate->tax_rate_id}}</td>
               <td>{{$assign_hsn_rate->created_date}}</td>
               <td><button type="button" class="btn btn-primary btn-sm">Edit</button></td>

             </tr>
           @endif

    </tbody>

  </table>