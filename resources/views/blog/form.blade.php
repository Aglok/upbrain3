{!! Form::open() !!}
<li>{!! Form::text('header', null, ['placeholder' => 'Заголовок статьи', 'autocomplete' => 'off']) !!}</li>
<li>{!! Form::textarea('article', null, ['placeholder' => 'Текст статьи', 'autocomplete' => 'off']) !!}</li>
<li>{!! Form::text('link', null, ['placeholder' => 'Адрес статьи', 'autocomplete' => 'off']) !!}</li>
<li>{!! Form::submit('Добавить') !!}</li>
{!! Form::close() !!}