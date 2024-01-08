@extends('page')

@section('block')

@endsection

{{-- Текст перед footer для общего описания --}}
@section('text-block')
    {!! $page->text !!}
@endsection

@section('form-static-bottom')
    {{-- Форма обратной связи --}}
    @include('site.form_static_junior', ['id' => 'form-bottom-junior', 'type' => $page->type, 'subject' => $page->subject, 'link' => $page->link])
    {{-- // Форма обратной связи --}}
@endsection

@section('modal-window')
    {{-- Модальное окно для формы --}}
    @include('site.form_modal', ['id' => 'form-modal', 'type' => $page->type, 'subject' => $page->subject])
{{--    @include('site.form_modal_junior', ['id' => 'form-modal-junior', 'type' => $page->type, 'subject' => $page->subject])--}}
@endsection