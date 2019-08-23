<div class="tab-content">
@if (Session::has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error_message') }}
    </div>
@endif
    @if($threads->count() > 0)
    <ul class="chat msg tab-pane fade in active" id="chat-panel_0">
    @foreach($threads as $thread)
        <?php //var_dump($thread->creator()->filename);?>
        <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
        <li id="thread_list_{{$thread->id}}" class="left clearfix media alert {{ $class }}">
            <span class="chat-img pull-left">
                {{-- Проверка происходит через model users из-за метода setImage, вместо null возвращает объект--}}
                @if(!$thread->creator()->filename)
                    <img src="{{ 'images/avatar/default/no-photo-male.png'}}" alt="{{ $thread->creator()->login }}" class="img-circle avatar">
                @else
                    <img src="{{ 'images/avatar/'.$thread->creator()->avatar }}" alt="{{ $thread->creator()->login }}" class="img-circle avatar">
                @endif
            </span>
            {!! link_to('#chat-panel_' . $thread->id, $thread->subject, ['class' => 'show', 'data-href' => 'messages/' . $thread->id]) !!}
            <div class="chat-body clearfix">
                <div class="header">
                    <p>
                        <small class="pull-right primary-font">
                            <strong>Creator:</strong> {{ $thread->creator()->name }}<br>
                            <strong>Participants:</strong> {{ $thread->participantsString(Auth::id(), ['name']) }}
                        </small>
                    </p>
                </div>
                <p id="thread_list_{{$thread->id}}_text">{{ $thread->latestMessage->body }}</p>
            </div>
        </li>
    @endforeach
    </ul>
    @else
    <p>Пока ещё не создали ни одной темы!</p>
    @endif
</div>
