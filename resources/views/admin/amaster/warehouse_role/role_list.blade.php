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
 
<div class="container">
   <ul class="listree listree-submenu-items">
   <li style="margin-left:30px;" class="saab">
      <div class="listree-submenu-heading btn btn-block btn-inverse  text-left" style="pointer-events: none;">Warehouse</div>
      @foreach($roles as $role)
      <ul class="listree-submenu-items">
   <li style="margin-left:30px;" class="saab">
      <div class="listree-submenu-heading btn btn-block {{ $role->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1" >{{ $role->name }}
        @if ($role->status == 1)
        <button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$role->id}})"  style="width:60px;">Disable</button>
        @else
        <button class="btn btn-success btn-sm p-1 float-right" onclick="changeStatus({{$role->id}})"  style="width:60px;">Enable</button>
        @endif
      
      <button class="btn btn-sm btn-warning p-1 mr-1 float-right" onclick="editConfigRole({{$role->id}})" style="width:60px;"> edit</button>
      
      <button class="btn btn-sm btn-primary p-1 float-right mr-1" onclick="editModules({{$role->id}})" style="width:60px;"> Modules</button>
</div> 
@includeWhen($role->subRoles->count() > 0,'admin.amaster.warehouse_role.subrole',['role'=>$role])
 
</li>
</ul>
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
 