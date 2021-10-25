@php
use App\Helpers\Helper;
@endphp
 <style>
 .listree{
    overflow:hidden;
    max-width:100%;
 }
   .listree-submenu-heading {
    cursor: pointer;
    /* max-width: 350px; */
}
ul.listree {
    list-style: none;
}
ul.listree-submenu-items {
    list-style: none;
    /* border-left: 1px dashed black; */
    white-space: nowrap;
    /* margin-right: 4px; */
    padding-left: 20px;
}
div.listree-submenu-heading.collapsed:before {
    content: "+";
    margin-right: 4px;
}
div.listree-submenu-heading.expanded:before {
    content: "-";
    margin-right: 4px;
}

.scrollable-menu {
    height: auto;
    max-width: 800px;
    overflow-y: hidden;
}
.saab{
  border-left: 1px dashed #404e67;
}
 </style>

 <div class="card">
  <div class="card-footer p-0 mb-3" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Account Groups</h5>
   </div>
   <ul class="listree listree-submenu-items">
   <li style="" class="saab">
      <div class="listree-submenu-heading btn btn-block btn-inverse  text-left" style="pointer-events: none;">Account Group</div>
      @foreach($groups as $group)
      @if ($group->user_store_id == 0)
      <ul class="listree-submenu-items">
      <li style="" class="saab">
          <div class="listree-submenu-heading btn btn-block {{ $group->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1" >{{ $group->name }}
      @if ($group->status == '1')
      <button class="btn btn-danger btn-sm p-1 float-right" onclick="updateStatus({{$group->id}},'0')" ><i class="fa fa-ban"></i></button>
      @else
      <button class="btn btn-success btn-sm p-1 float-right" onclick="updateStatus({{$group->id}},'1')" ><i class="fa fa-check"></i></button>
      @endif    
      <button class="btn btn-sm btn-warning p-1 mr-1 float-right" onclick="edit({{$group->id}})"><i class="fa fa-edit"></i></button>
        
    </div> 
    @includeWhen($group->subGroups->count() > 0,'admin.amaster.account_group.sub_group',['group'=>$group])
    
    </li>
    </ul>
          
      @endif
@endforeach
</li>
</ul> 
</div>












 

 
<script> 

$(document).ready(function(){
  //  listTree();
});
function listTree(){
  const subMenuHeadings = document.getElementsByClassName("listree-submenu-heading");
    Array.from(subMenuHeadings).forEach(function(subMenuHeading){
      subMenuHeading.classList.add("collapsed");
      subMenuHeading.nextElementSibling.style.display = "none";
      subMenuHeading.addEventListener('click', function(event){
        event.preventDefault();
        const subMenuList = event.target.nextElementSibling;
        if(subMenuList.style.display=="none"){
          subMenuHeading.classList.remove("collapsed");
          subMenuHeading.classList.add("expanded");
          subMenuList.style.display = "block";
        }
        else {
          subMenuHeading.classList.remove("expanded");
          subMenuHeading.classList.add("collapsed");
          subMenuList.style.display = "none";
        }
        event.stopPropagation();
      });
    });
}
</script>
 