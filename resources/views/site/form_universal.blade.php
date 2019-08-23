@if($type == 'Webinar')
<p class="text-center text-white">Вебинар для родителей и учеников<br>Регистрируйтесь прямо сейчас</p>
    {!! Form::open(['id' => $id, 'url'=>'contact', 'method' => 'post', 'class'=>'form-inline mx-auto col-sm-8'])!!}
    <div class="form-group">
        {!! Form::email('email', old('email'), ['class'=>'form-control input-lg', 'placeholder' => 'Введите ваш Email', 'required' => 'required']) !!}
        {!! Form::hidden('type', $type) !!}
        {!! Form::submit('Зарегистрироваться', ['class'=>'form-control input-lg btn btn-lg', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
    </div>
    {!! Form::close() !!}
@else
    <p class="text-center text-white">Количество мест ограничено.<br>Регистрируйтесь прямо сейчас</p>
    {!! Form::open(['id' => $id, 'url'=>'contact', 'method' => 'post', 'class'=>'form-inline mx-auto col-sm-8'])!!}
    <div class="form-group">
        <div class="row mx-auto col-lg-6">
            {!! Form::text('name', '',  ['class'=>'form-control input-lg', 'placeholder' => 'Ваше имя', 'required' => 'required']) !!}
            {!! Form::email('email', old('email'), ['class'=>'form-control input-lg', 'placeholder' => 'Введите ваш Email', 'required' => 'required']) !!}
            {!! Form::text('phone','',  ['class'=>'form-control input-lg', 'placeholder' => 'Телефон', 'required' => 'required', 'data-mask' =>'+7-999-999-9999']) !!}
            {!! Form::hidden('type', $type) !!}
            {!! Form::hidden('subject', $subject) !!}
            {!! Form::submit('Зарегистрироваться', ['class'=>'form-control btn btn-lg input-lg', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
        </div>
    </div>
    {!! Form::close() !!}
@endif

