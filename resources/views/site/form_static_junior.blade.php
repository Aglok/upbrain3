@php
    if(!isset($type)) $type = '';
    if(!isset($subject)) $subject = '';
    if(!isset($link)) $link = '';
@endphp
<div class="container">
    <div class="row row-backbordered m-b-lg">
        <div class="col-sm-12">
            <div class="panel panel-default panel-floating panel-floating-inline">
                <div class="panel-body">
                    <div class="panel-actions">
                        <h5 class="m-b-0"><strong>Оставьте заявку - сделайте первый шаг</strong></h5>
                        {{--<p class="text-subscribe"><small>Полную инструкцию вы получите на почту</small></p>--}}
                        {!! Form::open(['id' => $id, 'url'=>'contact', 'method' => 'post'])!!}
                        <div class="form-row">
                            <div class="form-group row">
                                {!! Form::text('name', '',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Ваше имя']) !!}
                                {!! Form::text('phone','',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Телефон', 'data-mask' =>'+7-999-999-9999']) !!}
                                {!! Form::email('email', old('email'), ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Email']) !!}
                                {!! Form::hidden('type', $type)!!}
                                {!! Form::hidden('subject', $subject)!!}
                                {!! Form::hidden('link', $link)!!}
                            </div>
                        </div>
                        <div class="row mx-4">
                            <div class="form-group col-sm-6">
                                <h4><strong>Предметы</strong></h4>
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
                            <div class="form-group col-sm-6">
                                <h4><strong>Тип обучения</strong></h4>
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
                        <div class="row mx-4">
                            <div class="form-group col-sm-12">
                                <label>
                                    {!! Form::checkbox('individual', 'Индивидуальное занятие', false, ['class'=>'form-check-input checkbox'])!!}
                                    <span class="checkbox-custom"></span>
                                    <span class="label font-form ml-1">Хочу индивидуальное занятие</span>
                                </label>
                            </div>
                        </div>
                        <div class="row mx-4">
                            <div class="form-group">
                                <h4><strong>Выбрать школы</strong></h4>
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
                        <div class="row mx-4">
                            <div class="col-sm-6 col-sm-offset-3">
                                {!! Form::button('Записаться', ['class'=>'form-control input-lg btn btn-lg', 'onclick' =>'yaCounter45749043.reachGoal(\'sign_up\'); return true;'])!!}
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
