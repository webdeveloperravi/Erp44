<div class="card-block">
    <div class="wrapper wrapper-">
       <div class="j-tabs-container">
          <input id="tab1" type="radio" name="tabs" checked="">
          <label class="j-tabs-label" for="tab1" title="Login">
          <i class="icofont icofont-login "></i>
          <span>Images</span>
          </label>
          <input id="tab2" type="radio" name="tabs">
          <label class="j-tabs-label" for="tab2" title="Registration">
          <i class="icofont icofont-ui-user"></i>
          <span>Videos</span>
          </label>  
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
          <div id="tabs-section-2" class="j-tabs-section">
            <form action="#" method="post" class="j-forms" novalidate="">
               <div class="content">
                  <div class="j-row">
                     <div class="span6">
                        <div class="divider-text gap-top-20 gap-bottom-45">
                           <span>Add Videos</span>
                        </div> 
                        <div class="row">  
                           <div class="col-md-12" id="videoCreate">
                                
                           </div> 
                       </div>

                     </div>
                     <div class="span6">
                        <div class="divider-text gap-top-20 gap-bottom-45">
                    <span>All Videos</span> 
                  </div> 
                  <div class="row">  
                           <div class="col-md-12" id="videosIndex">
                                
                           </div> 
                       </div> 
                     </div>
                  </div> 
               </div>
            </form>
          </div> 
       </div>
    </div>
 </div>
 <script>
	 $(document).ready(function(){
        ImageCreate();
        imagesIndex();
        videoCreate();
        videosIndex();
		
	 });

	function ImageCreate(){
		var productId = "{{ $product->id }}";
		var url = "{{ route('image.create',['/']) }}/"+productId;
            $.get(url,function(data){
                $("#imageCreate").html(data);
            }); 
	}

	function imagesIndex(){
		var productId = "{{ $product->id }}";
		var url = "{{ route('image.index',['/']) }}/"+productId;
			$.get(url,function(data){
				$("#imagesIndex").html(data);
			});
     }

     function videoCreate(){
		var productId = "{{ $product->id }}";
		var url = "{{ route('video.create',['/']) }}/"+productId;
            $.get(url,function(data){
                $("#videoCreate").html(data);
            }); 
	}

     

     function videosIndex(){
      var productId = "{{ $product->id }}";
      var url = "{{ route('video.index',['/']) }}/"+productId;
            $.get(url,function(data){
                $("#videosIndex").html(data);
            }); 
     }
 </script>
