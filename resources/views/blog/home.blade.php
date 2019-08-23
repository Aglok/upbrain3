@extends('app')

@section('content')
	<div id="page-wrapper">
		<br>
		@include('users.panel')
		<div class="col-md-6">
			@include('admin.user.interface')
		</div>
		<div class="col-md-6">
			@include('chat.chat')
		</div>
	</div>
@stop