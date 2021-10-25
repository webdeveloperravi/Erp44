{{-- <div class="card-header">
    <h5 class="card-header-text">Comments</h5> 
    </div> --}} 
    {{-- <div class="card-block"> --}}
        <div class="user-box">
            @if($lead->converted_to_store !== 1)
            <div class="media"> 
                <div class="media-body">
                <form id="commentForm" action="javascript:void(0);">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                <div class="">
            <textarea rows="2" cols="5" class="form-control" placeholder="Write Something here..." name="body"></textarea>
                 <div class="text-right m-t-20">
                    @can('store-create', 'lead.index')
                    <button class="btn btn-sm btn-primary waves-effect waves-light" onclick="storeComment()">Post</button>
                    @endcan  
                    </div>
                </div>
                </form>
                </div>
                </div>
                @endif
                @if(count($lead->comments()->orderBy('updated_at','desc')->get()))
                @foreach ($lead->comments()->orderBy('updated_at','desc')->get() as $comment)
            <div class="media m-b-20"> 
            <div class="media-body mb-0 pb-0 b-b-muted social-client-description">
            <div class="chat-header">{{ $comment->user->name ?? ""}}<span class="text-muted">{{ \Carbon\Carbon::parse($comment->updated_at)->toDayDateTimeString() }}</span></div>
            <p class="text-muted">{{ $comment->body }}</p>
               @if($lead->converted_to_store !== 1)
            <p>
                @can('store-update', 'lead.index')
                @if (Carbon\Carbon::parse($comment->updated_at) > Carbon\Carbon::now()->subMinutes(5)->toDateTimeString() )
                <a onclick="editComment('{{$comment->id }}')" class="text-primary" style="cursor: pointer;">Edit</a>
                @endif
                @endcan  

            </p>
            @endif
            </div>
            </div>  
            @endforeach
                @else
                <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Comments</h2>
                 @endif
          
            </div>
    {{-- </div>  --}}
