<div class="row">
    {!! Form::open(['route' => 'messages.store', 'data-toggle' => 'validator', 'id' => 'create-form']) !!}

    <div class="col-md-7">
        <!-- Subject Form Input -->
        <div class="form-group">
            {!! Form::label('subject', 'Тема', ['class' => 'control-label']) !!}
            {!! Form::text('subject', null, ['class' => 'form-control', 'id'=>'create-subject', 'required' => true]) !!}
        </div>

        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::label('message', 'Сообщение', ['class' => 'control-label']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control', 'id'=>'create-message', 'cols' => '10', 'rows'=>'10', 'required' => true]) !!}
        </div>
    </div>
    <div class="col-md-3">

        @if($users->count() > 0)
        <div class="checkbox list-group">
            @foreach($users as $user)
                <label for="recipients_{{ $user->id }}" title="{{ $user->full_name }}" class="list-group-item">
                    <i>{!! Form::input('checkbox', 'recipients[]', $user->id, ['id' => 'recipients_'.$user->id, 'class' => 'recipients']) !!}</i>
                    {{ $user->name }} {{ $user->surname }}
                </label>
            @endforeach
        </div>
        @endif
    </div>
    <div class="col-md-7">
        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::button('Отправить', ['class' => 'btn btn-primary form-control', 'id' => 'send-thread' , 'data-dismiss' => 'modal', 'aria-hidden' => 'true']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
