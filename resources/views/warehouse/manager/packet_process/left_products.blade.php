<div class="col-md-12">  
  
    @foreach ($products as $product)
        <div class="label-main">
        <label class="label label-inverse-info" style="font-size: 13px;" onclick="addToGemId({{$product->id}})">{{ $product->id }}</label>
        </div>  
    @endforeach
    @if($products->isEmpty())
     <script>
         finishPacketProcessChallan({{ $challan->id }});
     </script>
    <span class="d-block text-c-green f-28 text-center">Packet Process Complete</span>
    <div class="progress">
        <div class="progress-bar bg-c-green" style="width:100%"></div>
    </div> 
     
    @if ($challan->status == 'return-to-super')
    @if ($challan->authorization == 0)
    <span class=" f-28 text-center pt-3"><a  class="btn btn-primary text-white">Waiting for Accept</a></span>   
    @else
    <span class=" f-28 text-center pt-3"><a  class="btn btn-success text-white">Returned To Super</a></span>   
    @endif
    @else
   
    @if(\App\Helpers\CheckPermission::instance()->viewAction('return-to-super-packet-process-challan'))
    <span class=" f-28 text-center pt-3"><a href="{{ route('packet.returnToSuper',$challan->id) }}" class="btn btn-dark text-white">Packet Return To Super</a></span> 
    @endif
    @endif
    <span>
    <a href="{{ route('packetProcess.printLabel',$challan->packet->id) }}" target=“_blank” class="btn btn-secondary btn-sm"> Print Lables </a> 
    </span>
  


    @endif
     
    </div>