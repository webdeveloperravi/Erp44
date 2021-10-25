 
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
    
  </style> 

<div class="container">
  <div class="success_msg" style="display:none">
  </div>
  <div class="card"> 
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Role : {{$role->name}}</h5>
    </div> 

    <div class="card-block table-border-style">
      <div class="table-responsiv">
        <form id="editModulesForm" action="javascript:void(0)">
          @csrf
          <input type="hidden" name="roleId" value="{{$role->id}}">
          <table class="table table-styling">
            @foreach ($modules as $module)
            @if($module->parent == 0)
            <div class="car">
              <div class="card-heade py-" id="heading{{ $module->id }}">
                <h2 class="mb-0">
                   <div class="row mt-2">
                     <div class="col-md-1">
                      
            <input class="float-right " type="checkbox" name="modules[{{$module->id}}]" checked value="{{$module->id}}" data-level='module'> 
                     </div>
                     <div class="col-md-10">
                      <button class="btn btn-block bg-inverse text-left"  style="pointer-events: none;"> {{ $module->title }}</button>
                      @if ($module->sub_module->count())
                      @includeWhen($module->sub_module->count() > 0,'admin.amaster.WarehouseRoleModule.modulecomponent',['moduleId'=>$module->id])
                      @endif
                     </div>
                   </div>
                </h2>
              </div>
            </div> 


            {{-- <button class="btn btn-block bg-inverse text-left mt-2"  style="pointer-events: none;"> {{ $module->title }}</button>
              @includeWhen($module->sub_module->count() > 0,'admin.amaster.WarehouseRoleModule.modulecomponent',['moduleId'=>$module->id])  --}}
              @endif
            @endforeach
         </tbody> 
          </table>
          <a href="{{ url()->previous() }}
            " class="float-right"><button class="btn btn-danger  mt-5 mb-4 mr-5" onclick="close($('#editModules').html(''))"> Close</button></a>
          <button class="btn btn-success mt-5 float-right mr-2 mb-4" type="button" onclick="updateModules()">Update</button>
        </form>
      </div>
    </div>
  </div>
</div> 
<script type="text/javascript"> 
// ########################### for click child to check parent ###########################



$('input[type=checkbox][data-level="module"]').click(function (event) {
        var checked = $(this).is(':checked');

       //Check All Child Actions
        if (checked) {
           var modules =  $(this).closest('.module');

           $(modules).find('input[type=checkbox][data-level="action"]').prop('checked',true);
           $(modules).find('input[type=checkbox][data-level="module"]').prop('checked',true);

        }else{

           var modules =  $(this).closest('.module');

           $(modules).find('input[type=checkbox][data-level="action"]').prop('checked',false);
           $(modules).find('input[type=checkbox][data-level="module"]').prop('checked',false);

            


            
        }

        // 
});

// ########################### for click child to check parent ###########################
$('input[type=checkbox][data-level="action"]').click(function (event) {

        var checked = $(this).is(':checked');
        
        //Check  Parent Module 
        if (checked){ 
          $(this).closest('.module').find('input[type=checkbox][data-level="module"]').prop('checked', true);
        }else{

          var checkedActionsLength =  $(this).closest('.module').find('input[type=checkbox][data-level="action"]:checked').length;
          if(checkedActionsLength == 0){
             $(this).closest('.module').find('input[type=checkbox][data-level="module"]').prop('checked', false);
          }
        }

        //
}); 
</script> 