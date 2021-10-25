@extends('layouts.store.app')
@section('content')
<div class="row"> 
   <div class="col mb-2"> 
      <a class="btn btn-inverse text-white float-right" href="{{ route('ledgerMedia.finishUploading',$ledger->id) }}">Finish Image Uploading</a>
   </div>
</div>
<div class="card-footer p-0" style="background-color: #04a9f5">
   <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Add Images for Voucher No.{{ $ledger->voucher_number ?? '' }}</h5>
   </div> 
       <div class="j-tabs-container">
          <input id="tab1" type="radio" name="tabs" checked=""> 
          <div id="tabs-section-1" class="j-tabs-section">
             <form action="#" method="post" class="j-forms" novalidate="">
                <div class="content">
                   <div class="j-row">
                      <div class="span6">
                         <div class="divider-text gap-top-20 gap-bottom-45">
                            <span>Add Images</span>
                         </div> 
                         <div class="row">  
                            <div class="col-md-12" id="imageCreate">
                                 
                            </div>
                            {{-- <div class="col-md-6" id="videoCreate">
                                 
                            </div> --}}
                        </div>

                      </div>
                      <div class="span6">
                         <div class="divider-text gap-top-20 gap-bottom-45">
							<span>Uploaded Images</span> 
						 </div> 
						 <div class="row">  
                            <div class="col-md-12" id="imagesIndex">
                                 
                            </div> 
                        </div> 
                      </div>
                   </div> 
                </div>
             </form>
          </div>
          
       </div> 
@endsection
@section('script')
    
 <script>
	 $(document).ready(function(){
        ImageCreate();
        imagesIndex(); 
		
	 });

	function ImageCreate(){
		var productId = "{{ $ledgerId }}";
		var url = "{{ route('ledgerMedia.create',['/']) }}/"+productId;
            $.get(url,function(data){
                $("#imageCreate").html(data);
            }); 
	}

	function imagesIndex(){
		var productId = "{{ $ledgerId }}";
		var url = "{{ route('ledgerMedia.all',['/']) }}/"+productId;
			$.get(url,function(data){
				$("#imagesIndex").html(data);
			});
     } 
 </script>
@endsection
