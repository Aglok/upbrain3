@if($users->count() > 0)
    <div data-href="#chat-panel_{{$thread->id}}" class="list-group tab-pane fade in active">
        @foreach($users as $user)
            <label for="recipients_{{ $user->id }}" title="{{ $user->full_name }}" class="list-group-item">
                    <i>{!! Form::input('checkbox', 'recipients[]', $user->id, ['id' => 'recipients_'.$user->id, 'class' => 'recipients']) !!}</i>
                    {{ $user->name }} {{ substr($user->surname, 0, 2) }}.
            </label>
        @endforeach
    </div>
@endif