<p class="text-center text-white">Вебинар для родителей и учеников<br>Регистрируйтесь прямо сейчас</p>
    {!! Form::open(['id' => $id, 'url'=>'contact', 'method' => 'post', 'class'=>'form-inline mx-auto col-sm-8'])!!}
    <div class="form-group">
        {!! Form::email('email', old('email'), ['class'=>'form-control input-lg', 'placeholder' => 'Введите ваш Email', 'required' => 'required']) !!}
        {!! Form::hidden('type', 'Webinar') !!}
        {!! Form::submit('Зарегистрироваться', ['class'=>'form-control input-lg btn btn-lg'])!!}
    </div>
    {!! Form::close() !!}