<div class="row">
    {!! Form::open(['route' => 'messages.store', "data-toggle" => "validator"]) !!}
    <div class="col-md-7">
        <!-- Subject Form Input -->
        <div class="form-group">
            {!! Form::label('subject', 'Тема', ['class' => 'control-label']) !!}
            {!! Form::text('subject', null, ['class' => 'form-control', 'id'=>'create_subject', 'required' => true]) !!}
        </div>

        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::label('message', 'Сообщение', ['class' => 'control-label']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control', 'id'=>'create_message', 'cols' => '10', 'rows'=>'10', 'required' => true]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class=" alert alert-warning">Выберите участников темы</div>
        @if($users->count() > 0)
        <div class="checkbox list-group">
            @foreach($users as $user)
                <a class="list-group-item">
                    <label title="{{ $user->name }} {{ $user->surname }}">
                        <input type="checkbox" required name="recipients[]" value="{{ $user->id }}">{{ $user->name }}
                    </label>
                </a>
            @endforeach
        </div>
        @endif
    </div>
    <div class="col-md-7">
        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Отправить', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
