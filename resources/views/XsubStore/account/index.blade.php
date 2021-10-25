 <ul class="nav nav-tabs m-2" role="tablist" >
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#nav_details">Details</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_address" onclick="storeAddressIndex()">Address</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_manager" onclick="managerAccountIndex()">Manager</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_comment" onclick="commentIndex()">Comment</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_image" onclick="imageIndex()">Image2</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_order">Order</a>
    </li>
  </ul>

 
  <div class="tab-content">
    <div id="nav_details" class="container tab-pane active"><br>
    <div id="detail">
    

    </div>
</div>
    <div id="nav_address" class="container tab-pane fade"><br>
      <div id="addressIndex2"> </div> 
    

    </div>

    <div id="nav_manager" class="container tab-pane fade"><br>
    <div id="manager">

    </div>
    </div>


    <div id="nav_comment" class="container tab-pane fade"><br>
    <div id="comment">

    </div>
    </div>


    <div id="nav_image" class="container tab-pane fade"><br>
    <div id="image">

    </div>
    </div>

    <div id="nav_order" class="container tab-pane fade"><br>
      <div id="order">
        
      </div>
    </div>
  </div>
 


<script>
    $(document).ready(function(params) {
        view();  
       });

function view(){
 
    var url = "{{route('subStoreAccount.view',['/'])}}/"+"{{$store->id}}";
    $.get(url,function (data) {
       $("#detail").html(data);   
    });
}

function storeAddressIndex()
{   
   var storeId = "{{ $store->id ?? "" }}";
   var  url ="{{route('storeAccount.address.index',['/'])}}/"+storeId; 
   $.get(url,function(data){
      $("#addressIndex2").html(data);
   }); 
}

function managerAccountIndex(){
     var url = "{{ route('subStore.managerAccount.index',['/']) }}/"+"{{ $store->id }}";
     $.get(url,function(data){
        $("#manager").html(data);
     });
 }


function commentIndex(){

 var managerId = "{{ $store->id ?? "" }}";
   var  url ="{{route('manager.comment.index',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#comment").html(data);
   }); 

}

function imageIndex(){
 var managerId = "{{ $store->id ?? "" }}";
   var  url ="{{route('manager.image.index',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#image").html(data);
   }); 


}







</script>

