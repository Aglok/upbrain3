@extends('blog.blog')
<!--Центральный блог для статей-->
@section('content')
    @forelse($posts as $post_list)
        @if($post_list->published)
            @include('blog.preview')
        @endif
    @empty
        <div><h3>Нет записей</h3></div>
    @endforelse

   {{--Пагинация--}}
    @if(isset($arrayNumbers) && $posts->currentPage() > $posts->perPage())
        @include('blog.pagination', ['posts' => $posts, 'arrayNumbers' => $arrayNumbers])
    @endif

@endsection

<!--Для боковой панели-->
@section('sidebar')
@endsection
