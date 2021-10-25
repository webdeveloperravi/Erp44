<div class="card-block text-center">
 
@if($message)
    <span class="d-block text-c-pink f-28"> {{ $message }} </span> 
    <div class="progress">
    <div class="progress-bar bg-c-pink" style="width:100%"></div>
    </div>
@endif
@if(!empty($taskCompleted))
<span class="d-block text-c-green f-28"> {{ $taskCompleted }} </span> 
<div class="progress">
<div class="progress-bar bg-c-green" style="width:100%"></div>
</div>
@endif

    </div>