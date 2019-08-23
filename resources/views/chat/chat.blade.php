<div class="chat-panel panel panel-default">
    <div id="content-header" class="panel-heading">
        <i class="fa fa-comments fa-fw"></i>
        Чат
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-chevron-down"></i>
            </button>
            <ul class="dropdown-menu slidedown">
                <li>
                    <a id="create" href="#" data-toggle="modal" data-target="#create-modal">
                        <i class="fa fa-clock-o fa-fw"></i> Создать тему
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a id="list-friends" href="#">--}}
                        {{--<i class="fa fa-users fa-fw"></i> Список участников--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="divider"></li>
                <li>
                    <a id="list-tasks" href="#">
                        <i class="fa fa-check-circle fa-fw"></i> Обновить
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.panel-heading -->
    <div id="content-body" class="col-md-9 panel-body"></div>
    <div class="col-md-3 users chat-panel">
        {{--<div class="panel-heading">--}}
            {{--<i class="fa fa-comments fa-fw"></i>--}}
            {{--Users--}}
        {{--</div>--}}
        <div class="panel-body tab-content"></div>
    </div>
    <!-- /.panel-body -->

    {!! Form::open(['id' => 'chat-form', "role" => "form", "files" => true, "data-toggle" => "validator", "enctype" => "multipart/form-data"])!!}
    <div class="panel-footer">
        <div class="input-group">
            <img id="loadImg" src="images/bg/load.gif">
            {!! Form::textarea('message', null, ['class' => 'form-control input-sm', 'id' => 'message', 'rows' => '1']) !!}
            <div class="im_upload_wrap fl_r">
                <div id="im_upload" class="im_upload" title="Сюда можно перетаскивать файлы">
                    {!! Form::file('images[]', ['class' => 'form-control input-sm','id' => 'images', 'multiple' => true, 'size' => 28]) !!}
                </div>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-warning btn-sm" id="btn-chat">Отравить</button>
            </span>
        </div>
        <div id="chat-footer">
            <ul class="list-inline" id="preview-photo"></ul>
        </div>
    </div>
    <!-- /.panel-footer -->
    {!! Form::close()!!}
</div>
<!-- Модальное окно для создания сообщения -->
<div class="modal fade" id="create-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Создать новую тему</h3>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>