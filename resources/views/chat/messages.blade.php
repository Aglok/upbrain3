 <ul id="chat-panel_{{$thread->id}}" class="chat msg tab-pane fade thread_{{$thread->id}}">
        @foreach($thread->messages()->latest()->get() as $message)
            @if($message->body)
                @include('chat.html-message', $message)
            @endif
        @endforeach
 </ul>
