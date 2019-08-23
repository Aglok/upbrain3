@extends('app')

@section('content')
<div class="container">
		<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Вход</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Ой! </strong>Что-то пошло не так! Повторите попытку.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					{!! Form::open(['url'=> route('login'), 'method' => 'post' ,'role'=>'form'])!!}
					<div class="form-group">{!! Form::email('email', old('email'), ['class'=>'form-control']) !!}</div>
					<div class="form-group">{!! Form::password('password', ['class'=>'form-control']) !!}</div>
					{!! Form::submit('Вход', ['class'=>'btn btn-lg btn-success btn-block'])!!}
					{!! Form::close()!!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
