        <div class="user-box">
        @if(count($managerId->comments()->orderBy('updated_at','desc')->get()))
                @foreach ($managerId->comments()->orderBy('updated_at','desc')->get() as $comment)
            <div class="media m-b-20"> 
            <div class="media-body mb-0 pb-0 b-b-muted social-client-description">
            <div class="chat-header">{{ $comment->user->name ?? ""}}<span class="text-muted">{{ \Carbon\Carbon::parse($comment->updated_at)->toDayDateTimeString() }}</span></div>
            <p class="text-muted">{{ $comment->body }}</p>
            <p><a onclick="edit('{{$comment->id }}')" class="text-primary" style="cursor: pointer;">Edit</a></p>
            </div>
            </div>  
            @endforeach
                @else
                <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Comments</h2>
                 @endif
          
            </div>
            <div id="editComment">
                
                
            </div>

