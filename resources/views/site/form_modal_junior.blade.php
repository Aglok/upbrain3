@php
    if(!isset($type)) $type = '';
    if(!isset($subject)) $subject = '';
   // foreach(\App\Models\School::all()->groupBy('district') as $k=>$v){
   //     dd($k, $v[0]->name);
   // }
@endphp
<div class="modal fade" id="contact-modal-junior">
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
{{--                            <div class="form-check">--}}
{{--                                <label>--}}
{{--                                    {!! Form::checkbox('special_offer', 'special_offer', false, ['class'=>'form-check-input checkbox'])!!}--}}
{{--                                    <span class="checkbox-custom"></span>--}}
{{--                                    <span class="label font-size-drop ml-1">Получить специальное предложение при выборе от 2x и более предметов</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Предметы</h4>
                        <div class="form-group">
                            <ul class="list-unstyled width-100">
                                @foreach(array("Математика", "Физика", "Программирование") as $subject)
                                    <li>
                                        <div class="form-check">
                                            <label>
                                                {!! Form::checkbox('subjects[]', $subject, false, ['class'=>'form-check-input checkbox'])!!}
                                                <span class="checkbox-custom"></span>
                                                <span class="label font-form ml-1">{{$subject}}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h4>Тип обучения</h4>
                        <div class="form-group">
                            <ul class="list-unstyled width-100">
                                <li>
                                    <div class="form-check">
                                        <label>
                                            {!! Form::checkbox('type_of_training[]', 'Поступление', false, ['class'=>'form-check-input checkbox'])!!}
                                            <span class="checkbox-custom"></span>
                                            <span class="label font-form ml-1">Поступление в школу</span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label>
                                            {!! Form::checkbox('type_of_training[]', 'Успеваемость', false, ['class'=>'form-check-input checkbox'])!!}
                                            <span class="checkbox-custom"></span>
                                            <span class="label font-form ml-1">Повышение успеваемости</span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mx-auto col-sm-12">
                        <h4>Можете выбрать школы</h4>
                        @foreach(\App\Models\School::all()->groupBy('district') as $district=>$schools)
                            <button class="btn-collapse" type="button" data-toggle="collapse" data-target="#collapse-{{$district}}" aria-expanded="false" aria-controls="collapse-{{$district}}">{{$district}}</button>
                            <div class="collapse" id="collapse-{{$district}}">
                                <div class="form-group">
                                    <ul class="list-unstyled width-100">
                                        @foreach($schools as $school)
                                            <li>
                                                <div class="form-check">
                                                    <label>
                                                        {!! Form::checkbox('schools[]', $school->name, false, ['class'=>'form-check-input checkbox'])!!}
                                                        <span class="checkbox-custom"></span>
                                                        <span class="label font-form ml-1">{{$school->name}}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        {!! Form::button('Записаться', ['class'=>'btn btn-block btn-primary', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
