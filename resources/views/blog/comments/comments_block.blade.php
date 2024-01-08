<div id="comments" class="comments-area">
    {{--Список комментариев--}}
    <h2 class="comments-title">Comments <span class="light">{{$count}}</span></h2>
    <div class="comment-list">
        @foreach($comments as $parent_id => $parents_comments)
            {{--Выводим самый первый комментарий - родительский он не имеет parent_id--}}
            @if($parent_id)
                {{-- Если родитель есть выходим из цикла сразу,
                    так как нам нужен один элемент массива содержащий все родительские комментарии
                --}}
                @break
            @endif
            @php $i = 0 @endphp
            @include('blog.comments', ['i' => $i, 'items' => $parents_comments])
        @endforeach
    </div>
    @include('blog.form')
</div>
