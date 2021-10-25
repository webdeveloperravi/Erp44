 
  <style>
    input[type=checkbox]{
      width: 20px;
      height: 20px;
    }
    .checkbox {
    --background: #fff;
    --border: #D1D6EE;
    --border-hover: #BBC1E1;
    --border-active: #1E2235;
    --tick: #fff;
    position: relative;
    input,
    svg {
        width: 21px;
        height: 21px;
        display: block;
    }
    input {
        -webkit-appearance: none;
        -moz-appearance: none;
        position: relative;
        outline: none;
        background: var(--background);
        border: none;
        margin: 0;
        padding: 0;
        cursor: pointer;
        border-radius: 4px;
        transition: box-shadow .3s;
        box-shadow: inset 0 0 0 var(--s, 1px) var(--b, var(--border));
        &:hover {
            --s: 2px;
            --b: var(--border-hover);
        }
        &:checked {
            --b: var(--border-active);
        }
    }
    svg {
        pointer-events: none;
        fill: none;
        stroke-width: 2px;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke: var(--stroke, var(--border-active));
        position: absolute;
        top: 0;
        left: 0;
        width: 21px;
        height: 21px;
        transform: scale(var(--scale, 1)) translateZ(0);
    }
    &.path {
        input {
            &:checked {
                --s: 2px;
                transition-delay: .4s;
                & + svg {
                    --a: 16.1 86.12;
                    --o: 102.22;
                }
            }
        }
        svg {
            stroke-dasharray: var(--a, 86.12);
            stroke-dashoffset: var(--o, 86.12);
            transition: stroke-dasharray .6s, stroke-dashoffset .6s;
        }
    }
    &.bounce {
        --stroke: var(--tick);
        input {
            &:checked {
                --s: 11px;
                & + svg {
                    animation: bounce .4s linear forwards .2s;
                }
            }
        }
        svg {
            --scale: 0;
        }
    }
}

@keyframes bounce {
    50% {
        transform: scale(1.2);
    }
    75% {
        transform: scale(.9);
    }
    100% {
        transform: scale(1);
    }
}

html {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}

* {
    box-sizing: inherit;
    &:before,
    &:after {
        box-sizing: inherit;
    }
}

// Center & dribbble
body {
    min-height: 100vh;
    display: flex;
    font-family: 'Roboto', Arial;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: #F6F8FF;
    .grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-gap: 24px;
    }
    .dribbble {
        position: fixed;
        display: block;
        right: 20px;
        bottom: 20px;
        img {
            display: block;
            height: 28px;
        }
    }
    .twitter {
        position: fixed;
        display: block;
        right: 64px;
        bottom: 14px;
        svg {
            width: 32px;
            height: 32px;
            fill: #1da1f2;
        }
    }
}
 /* final styles */
 .wtree {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.wtree {
  padding: 50px;
  font-family: helvetica, arial, sans-serif;
}

.wtree ul {
  margin-left: 20px;
}

.wtree li {
  list-style-type: none;
  margin: 10px 0 10px 10px;
  position: relative;
}
.wtree li:before {
  content: "";
  position: absolute;
  top: -10px;
  left: -20px;
  border-left: 1px dotted black;
  border-bottom: 1px dotted black;
  width: 20px;
  height: 15px;
}
.wtree li:after {
  position: absolute;
  content: "";
  top: 5px;
  left: -20px;
  border-left: 1px dotted black;
  border-top: 1px dotted black;
  width: 20px;
  height: 100%;
}
.wtree li:last-child:after {
  display: none;
}
.wtree li span {
  display: block;
  border: 1px solid #ddd;
  background-color: white;
  padding: 10px;
  color: #888;
  text-decoration: none;
}

.wtree li span:hover, .wtree li span:focus {
  background: rgb(255, 253, 253);
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span:hover + ul li span, .wtree li span:focus + ul li span {
  background: #eee;
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span:hover + ul li:after, .wtree li span:hover + ul li:before, .wtree li span:focus + ul li:after, .wtree li span:focus + ul li:before {
  border-color: #aaa;
}

/* Checkbox Final */
.checkbox {
  --background: #fff;
  --border: #D1D6EE;
  --border-hover: #BBC1E1;
  --border-active: #1E2235;
  --tick: #fff;
  position: relative;
}
.checkbox input,
.checkbox svg {
  width: 21px;
  height: 21px;
  display: block;
}
.checkbox input {
  -webkit-appearance: none;
  -moz-appearance: none;
  position: relative;
  outline: none;
  background: var(--background);
  border: none;
  margin: 0;
  padding: 0;
  cursor: pointer;
  border-radius: 4px;
  transition: box-shadow 0.3s;
  box-shadow: inset 0 0 0 var(--s, 1px) var(--b, var(--border));
}
.checkbox input:hover {
  --s: 2px;
  --b: var(--border-hover);
}
.checkbox input:checked {
  --b: var(--border-active);
}
.checkbox svg {
  pointer-events: none;
  fill: none;
  stroke-width: 2px;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke: var(--stroke, var(--border-active));
  position: absolute;
  top: 0;
  left: 0;
  width: 21px;
  height: 21px;
  transform: scale(var(--scale, 1)) translateZ(0);
}
.checkbox.path input:checked {
  --s: 2px;
  transition-delay: 0.4s;
}
.checkbox.path input:checked + svg {
  --a: 16.1 86.12;
  --o: 102.22;
}
.checkbox.path svg {
  stroke-dasharray: var(--a, 86.12);
  stroke-dashoffset: var(--o, 86.12);
  transition: stroke-dasharray 0.6s, stroke-dashoffset 0.6s;
}
.checkbox.bounce {
  --stroke: var(--tick);
}
.checkbox.bounce input:checked {
  --s: 11px;
}
.checkbox.bounce input:checked + svg {
  -webkit-animation: bounce 0.4s linear forwards 0.2s;
          animation: bounce 0.4s linear forwards 0.2s;
}
.checkbox.bounce svg {
  --scale: 0;
}

@-webkit-keyframes bounce {
  50% {
    transform: scale(1.2);
  }
  75% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes bounce {
  50% {
    transform: scale(1.2);
  }
  75% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
}


  </style> 
    {{-- <label class="checkbox bounce">
        <input type="checkbox" checked>
        <svg viewBox="0 0 21 21">
            <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
        </svg>
    </label> --}}
  <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$role->name}} </h5>  
  </div>
 <div class="card-body p-0">
    <form action="javascript:void(0)" id="editModulesForm">
      @csrf
      <input type="hidden" name="roleId" value="{{$role->id}}">
      @foreach ($modules as $module)
      @if($module->parent == 0)
      <ul class="wtree">
        <li>
          <span>
              <input type="checkbox" name="modules[{{$module->id}}]" {{ in_array($module->id,$roleModulesIds) ? "checked" : "" }} value="{{$module->id}}" data-level='module'> 
              {{ $module->title }}
              @if($module->route !== null )
              <div>
                  <input type="checkbox" name="modules[{{ $module->id }}][create]">Create 
                  <input type="checkbox" name="modules[{{ $module->id }}][read]">Read 
                  <input type="checkbox" name="modules[{{ $module->id }}][update]">Update 
                  <input type="checkbox" name="modules[{{ $module->id }}][delete]">Delete 
              </div>
              @endif
          </span>
          @includeWhen($module->sub_module->count() > 0,'store.manager_role_module.modulecomponent',['modules'=>$module->sub_module,'roleId' => $role->id])
        </li> 
      </ul>
      @endif
      @endforeach
      
      <button class="btn btn-danger  mt-5 mb-4 mr-5 float-right" onclick="$('#editModules').html('')"> Cancel</button>
      <button class="btn btn-success mt-5 float-right mr-2 mb-4" onclick="updateModules()">Update</button>
    </form>
</div>  

 
<script type="text/javascript"> 
// ########################### for click child to check parent ###########################
// function checkAll(){ 
//     $('input[type="checkbox"').map(i => i.checked = true);
         
//         // $('input:checkbox').prop('checked', this.checked);  
// // });
// }


// $('input[type=checkbox][data-level="module"]').click(function (event) {
//         var checked = $(this).is(':checked');

//        //Check All Child Actions
//         if (checked) {
//            var modules =  $(this).closest('.module');

//            $(modules).find('input[type=checkbox][data-level="action"]').prop('checked',true);
//            $(modules).find('input[type=checkbox][data-level="module"]').prop('checked',true);

//         }else{

//            var modules =  $(this).closest('.module');

//            $(modules).find('input[type=checkbox][data-level="action"]').prop('checked',false);
//            $(modules).find('input[type=checkbox][data-level="module"]').prop('checked',false); }
 
// });

// // ########################### for click child to check parent ###########################
// $('input[type=checkbox][data-level="action"]').click(function (event) {

//         var checked = $(this).is(':checked');
        
//         //Check  Parent Module 
//         if (checked){ 
//           $(this).closest('.module').find('input[type=checkbox][data-level="module"]').prop('checked', true);
//         }else{

//           var checkedActionsLength =  $(this).closest('.module').find('input[type=checkbox][data-level="action"]:checked').length;
//           if(checkedActionsLength == 0){
//              $(this).closest('.module').find('input[type=checkbox][data-level="module"]').prop('checked', false);
//           }
//         }
 
// });

$(function() {
  $("input[type='checkbox']").change(function () {
    $(this).parent('span').siblings('ul')
           .find("input[type='checkbox']")
           .prop('checked', this.checked);
  });
});

$(function() {
  $(".module-checkbox").change(function () {
    $(this).siblings("input[type='checkbox']") 
           .prop('checked', this.checked);
  });
});
 
 
</script>
 


 