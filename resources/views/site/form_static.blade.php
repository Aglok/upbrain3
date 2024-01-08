@php
    if(!isset($type)) $type = '';
    if(!isset($subject)) $subject = '';
@endphp
<div class="container">
    <div class="row row-backbordered m-b-lg">
        <div class="col-sm-12">
            <div class="panel panel-default panel-floating panel-floating-inline">
                <div class="panel-body">
                    <div class="panel-content">
                        <h5 class="m-b-0"><strong>Оставьте заявку - сделайте первый шаг</strong></h5>
                        {{--<p class="text-subscribe"><small>Полную инструкцию вы получите на почту</small></p>--}}
                    </div>
                    <div class="panel-actions">
                        <div class="col-md-12">
                            {!! Form::open(['id' => $id ,'url'=>'contact', 'method' => 'post', 'class'=>'form-inline'])!!}
                            <div class="form-group">
                                {!! Form::text('name', '',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Ваше имя', 'required' => 'required']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Телефон', 'required' => 'required', 'data-mask' =>'+7-999-999-9999']) !!}
                                {!! Form::email('email', old('email'), ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Email', 'required' => 'required']) !!}
                                {!! Form::hidden('type', $type) !!}
                                {!! Form::hidden('subject', $subject) !!}
                                {!! Form::submit('Записаться', ['class'=>'form-control input-lg btn btn-lg col-md-2', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
