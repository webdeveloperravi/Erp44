
@if(count($products) > 0)
<div class="col-md-12">  
    @foreach ($products as $product)
    <div class="label-main">
        <label class="label label-inverse-info" style="font-size: 13px;" onclick="addToGemId({{$product->id}})">{{ $product->id }}</label>
    </div>  
    @endforeach
</div>
@else 
 @if ($leftWeight == 0 && $leftPiece == 0)  
 <div class="col-md-12">
 <div class="progress progress-xl"> 
    <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Weight Process Complete</h5>
    </div>
 </div>
 </div>
 @else 
 <div class="col-md-12">
    <div class="progress progress-xl"> 
       <div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Recheck Weight Conflict</h5>
       </div>
    </div>
    </div>
 @endif
@endif 
  