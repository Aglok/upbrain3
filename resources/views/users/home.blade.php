@extends('app')

@section('content')
	<div class="content-wrapper">
		<br>
		{{--@include('users.panel')--}}
		<div class="content body">
			<div class="col-md-6">
				@include('admin.user.interface')
			</div>
			<div class="col-md-6">
				@if((int)Auth::id() == $user_id)
					@include('chat.chat')
				@endif
			</div>
		</div>
	</div>
@stop