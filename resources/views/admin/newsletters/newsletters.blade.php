@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Рассылка задач
            </h1>
            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
    <ul class="nav nav-tabs" id="newsletters-tab">
        <li class="active"><a href="#newsletters_users">Пользователи</a>
        </li>
        <li class=""><a href="#newsletter_message">Сообщение</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
                {!! Form::open(['id' => 'newsletters-form', "role" => "form", "files" => true, "data-toggle" => "validator", "enctype" => "multipart/form-data"]) !!}
            <div class="tab-content">
                <div class="tab-pane fade active in" id="newsletters_users">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover upbrain" id="dataTable">
                            <thead>
                            <tr>
                                @foreach ($columns as $column)
                                    <th>{!! $column !!}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rows as $user)
                                <tr>
                                    @foreach ($user->getAttributes() as $key => $val)
                                        <td>
                                            @if($key == 'id')
                                                {!! Form::checkbox('id', $user->id , false) !!}
                                            @elseif($key == 'firstname')
                                                {!! $user->firstname !!}
                                            @elseif($key == 'lastname')
                                                {!! $user->lastname !!}
                                            @elseif($key == 'email')
                                                {!! $user->email !!}
                                            @elseif($key == 'subjects')
                                                {!! $user->subjects !!}
                                            @elseif($key == 'type_of_training')
                                                {!! $user->type_of_training !!}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="newsletter_message">

                    <!-- Тип сообщений -->
                    <div class="form-group">
                        {!! Form::label('mail-type', 'Тип сообщения', ['class' => 'control-label']) !!}
                        <div class="radio"><label>{!! Form::radio('mail-type', '1', true) !!} Html</label></div>
                        <div class="radio"><label>{!! Form::radio('mail-type', '0') !!} Простой текст</label></div>
                    </div>

                    <!-- Отправитель -->
                    <div class="form-group">
                        {!! Form::label('mail-from', 'От', ['class' => 'control-label']) !!}
                        {!! Form::text('mail-from', 'email@upbrain.ru' , ['class' => 'form-control', 'id'=>'create-mail-from', 'required' => true]) !!}
                    </div>

                    <!-- Заголовок письма -->
                    <div class="form-group">
                        {!! Form::label('subject', 'Тема', ['class' => 'control-label']) !!}
                        {!! Form::text('subject', null, ['class' => 'form-control', 'id'=>'create-subject', 'required' => true]) !!}
                    </div>

                    <!-- Тело письма -->
                    <div class="form-group">
                        {!! Form::label('body', 'Сообщение', ['class' => 'control-label']) !!}
                        {!! Form::textarea('body', '', ['class' => 'ckeditor form-control', 'id'=>'create-body', 'cols' => '10', 'rows'=>'10', 'required' => true]) !!}
                    </div>

                    <!-- Прикрепить -->
                    <div class="form-group">
                        {!! Form::label('files', 'Прикрепить файл', ['class' => 'control-label']) !!}
                        {!! Form::file('files[]', ['id'=>'attach-file', 'multiple' => true]) !!}
                    </div>
                    <div class="progressbar"></div>
                </div>
            </div>
                    {!! Form::button('<i class="fa fa-plus"></i> Отправить', ['id'=> 'button-send-newsletters', 'class' => 'btn btn-primary navbar-btn']) !!}
                    {!! Form::close() !!}
        </div>
    </div>
    {{--{!! Html::script('js/aglok/newsletters.js') !!}--}}
    {{--{!! Html::script('packages/sleepingowl/ckeditor/ckeditor.js') !!}--}}
@stop

