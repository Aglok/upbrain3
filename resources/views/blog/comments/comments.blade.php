@foreach($items as $item)
    {{-- Для расчёта порядка глубины--}}
    @php $i ? $i : $i = 1 @endphp
    <div class="comment depth-{{$i++}} parent" id="comment-{{$item->id}}">
        <div class="comment-inner default-background">
            <div class="comment-header clearfix">
                <div class="comment-author">
                    <b class="comment-avatar"></b>
                    {{--<img alt="{{$item->name}}" src="" class="avatar" height="70" width="70">--}}
                    <div class="fn title-h6">{{$item->name}}</div>
                    <div class="comment-meta date-color">
                        <a href="#comment-{{$item->id}}">{{ is_object($item->created_at) ? $item->created_at->format('d.m.Y в H:i') : ''}} </a>
                    </div>
                </div>
                <div class="reply">
                    <a rel="nofollow" class="comment-reply-link gem-button gem-button-style-outline gem-button-size-tiny"
                       href="#respond"
                       onclick="return addComment.moveForm('comment-{{$item->id}}', '{{$item->id}}', 'respond', '{{$post->id}}')"
                       aria-label="Ответить {{$item->name}}">Ответить</a>
                </div>
            </div>
            <div class="comment-text">
                <p>{{$item->text}}</p>
            </div>
        </div>
        @if(isset($comments[$item->id]))
            @include('blog.comments', ['i' => $i,'items' => $comments[$item->id]])
        @endif
    </div>
@endforeach