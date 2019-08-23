@extends('app')
@section('title')
    Форма
@endsection

@section('content')
    @if($errors->all())
        <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>Ошибочка {{ $error }}</p>
        @endforeach
        </div>
    @endif
	<ul class="list-unstyled">
    @include('blog.form')
    </ul>
@endsection