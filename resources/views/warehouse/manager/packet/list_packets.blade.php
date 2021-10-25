 
@if ($packets->count() > 0)
<div class="row">
  <div class="col-md-12">
      <div class="card">
          <div class="card-footer p-0" style="background-color: #04a9f5">
              <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Packets List</h5>
           </div>      
<div class="invoiceView">  
  <div class="table-responsive "> 
  <table class="table table-bordered table-hover ">
  <thead class="table-active">
  <tr>
  <th>S.No</th> 
  <th>Invoice</th>
  <th>Number</th>
  <th>Grade</th>
  <th>Pieces</th>
  <th>Ratti</th> 
  <th>Return to super</th> 
  <th>Export Label</th> 
  </tr>
  </thead>
  <tbody> 
    @foreach ($packets as $packet) 
      <tr class="text-center">
        <td>{{ $loop->iteration }}</td>
      <td><label>{{ $packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</label></td>
      <td><label>{{ $packet->number }}</label></td>
      <td><label>{{$packet->invoiceDetailGrade->grade->grade }}</label></td>
      <td><label>{{ $packet->total_piece }}</label></td>
      <td><label>{{ $packet->ratti->rati_standard }}</label></td> 
      @if ($packet->return_to_super == '1')
      @if ($packet->authorization == 0)
      <td> <span class="f-20"><i class="fa fa-circle-o-notch text-primary"></i></span></td> 
      @else
      <td> <span class="f-20"><i class="fa fa-check text-success"></i></span></td> 
      @endif
      <td><a href="{{ route('packet.labelPrint',$packet->id) }}"><button type="button" class="btn btn-secondary btn-sm">Export Label</button></a></td> 
      @else    
      @if(\App\Helpers\CheckPermission::instance()->viewAction('weight-challan-packet-retun-to-super'))
      <td> <a  onclick="returnToSuper({{ $packet->id }})"><i class="fa fa-mail-reply"></i></a></td> 
      <td><a href="{{ route('packet.labelPrint',$packet->id) }}"><button type="button" class="btn btn-secondary btn-sm">Export Label</button></a></td> 
      @endif
      @endif
      </tr>  
   @endforeach
  </tbody>
  </table>
  </div> 

<!--Modal Part-->
<div class="modal-part"></div>


</div>
</div>
</div>
</div>  
@endif
<script>

</script>
 