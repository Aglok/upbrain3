@php
    if(!isset($type)) $type = '';
    if(!isset($subject)) $subject = '';
@endphp
<div class="modal fade" id="contact-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Оставить заявку</h3>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => $id, 'url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                <div class="m-x m-y row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                            {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон', 'data-mask' =>'+7-999-999-9999']) !!}
                            {!! Form::email('email', old('email'), ['class'=>'form-control', 'placeholder' => 'Email']) !!}
                            {!! Form::hidden('type', $type)!!}
                            {!! Form::hidden('subject', $subject)!!}
                            <div class="checkbox">
                                {!! Form::label('special_offer', 'Получить специальное предложение при выборе от 2x и более предметов') !!}
                                {!! Form::input('checkbox', 'special_offer') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div><?php
