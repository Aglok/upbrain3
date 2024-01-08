<div class="modal fade" id="registration-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Регистрация</h3>
            </div>
            <div class="modal-body">
                <div class="m-x m-y row">
                    <div class="col-md-6" style="border-right: 1px solid #ddd;">
                        {!! Form::open(['url'=>'/auth/registration', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                        <div class="form-group">
                            {!! Form::text('name','', ['class'=>'form-control', 'placeholder' => 'Имя']) !!}
                            {!! Form::email('email', old('email'), ['class'=>'form-control']) !!}
                            {!! Form::password('password', ['class'=>'form-control']) !!}
                            {!! Form::text('phone','', ['class'=>'form-control', 'placeholder' => 'Ваш телефон']) !!}
                            <br>
                            <div class="checkbox">
                                {!! Form::label('info', 'Получать актуальную информацию') !!}
                                {!! Form::input('checkbox', 'info') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-buttons">
                            <a href="login/vkontakte" class="login-button login-button-vk">
                                <i class="fa fa-vk" aria-hidden="true"></i></a>
                            <a href="login/odnoklassniki" class="login-button login-button-ok">
                                <i class="fa fa-odnoklassniki " aria-hidden="true"></i></a>
                            <a href="login/facebook" class="login-button login-button-fb">
                                <i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="login/google" class="login-button login-button-gPlus">
                                <i class="fa fa-google" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        {!! Form::submit('Зарегистрироваться', ['class'=>'btn btn-block btn-primary'])!!}
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>