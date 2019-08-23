<div class="tab-content">
    <div id="chat-panel_{{$thread->id}}" class="tab-pane fade in active">
        <h3>{!! $thread->subject !!}</h3>

        <div id="thread_{{$thread->id}}">
            @foreach($thread->messages()->latest()->get() as $message)
                @include('messenger.html-message', $message)
            @endforeach
        </div>

        <h2>Add a new message</h2>
        {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
        </div>

        @if($users->count() > 0)
        <div class="checkbox">
            @foreach($users as $user)
                <label title="{{ $user->name }} {{ $user->surname }}"><input type="checkbox" name="recipients[]" value="{{ $user->id }}">{{ $user->name }}</label>
            @endforeach
        </div>
        @endif

        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
