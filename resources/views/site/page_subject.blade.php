@extends('page')

@section('block')
    @if($page->subject_title)
        {{-- Предмет с драконом --}}
        @include('site.subject', ['subject_title' => $page->subject_title, 'subject_image' => $page->subject_image, 'subject_text' => $page->subject_text])
    @endif

    {{-- Почему мы?--}}
    {{--@include('site.gist')--}}
    @if($page->type == 'ege')
        @include('site.feature_ege')
    @elseif($page->type == 'oge')
        @include('site.feature_oge')
    @endif
    {{-- Кратко о сути нашего дела --}}
    @include('site.advantage')

    {{-- Карусель отзывы --}}
    {{--@include('site.comments')--}}
    {{-- Полное тестирование --}}
    @include('site.complete_testing')
    {{-- Стоимость занятий--}}
    @include('site.price', ['subject' => $page->subject])
    {{-- Предметы --}}
    @include('site.subjects', ['type' => $page->type])
    {{-- Преподаватели --}}
    @include('site.teacher', ['subject' => $page->subject])
@endsection

{{-- Текст перед footer для общего описания --}}
@section('text-block')
    {!! $page->text !!}
@endsection