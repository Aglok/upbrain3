@extends('blog.blog')
@section('content')
@if($post->published)
    <article id="post_{{$post->id}}" class="blog-post py-3">
        <h3>
           {{$post->title}}
        </h3>
        <div class="post-info">
            <div class="item-info">
                <span class="fa fa-clock"></span>
                {{$post->created_at}}
            </div>
            <div class="item-info">
                <span class="fa fa-comments"></span>
                <a href="{{route('post', ['id' => $post->id])}}">
                    <span data-xid="{{$post->id}}" class="count-comments"></span>
                </a>
            </div>

            <div class="item-info float-right">
                @if(count($post->tags))
                    <span class="fa fa-tag"></span>
                @endif
                @forelse($tags as $tag)
                    <a href="{{route('tag', ['name' => $tag->name,'id' => $post->id])}}">{{$tag->name}}</a>
                    @if(!$loop->last)
                        <span> , </span>
                    @endif

                    @empty
                @endforelse
            </div>

        </div>
        <div class="post-text">
            <p>{!! $post->text !!}</p>
        </div>

        <div class="post-image my-3">
            @if($post->image)
                <img src="{{asset($post->image)}}" width="1170" height="500" class="img-fluid" alt="{{$post->title}}">
            @endif
        </div>
        <div class="post-footer pb-5">
            <div class="float-right">
                <div class="ya-share2"
                     data-services="vkontakte,facebook,odnoklassniki,twitter"
                     data-url="{{URL::current()}}"
                     data-image="{{asset($post->image)}}"
                     data-description="{{$post->cut}}"
                     data-title="{{$post->title}}">
                </div>
                {{--<a href="#" id="fb-{{$post->id}}"><i class="fab fa-facebook-square fa-1x"></i></a>--}}
                {{--<a href="#" id="vk-{{$post->id}}"><i class="fab fa-vk fa-1x"></i></a>--}}
                {{--<a href="#" id="tw-{{$post->id}}"><i class="fab fa-twitter fa-1x"></i></a>--}}
                {{--<a href="#" id="ok-{{$post->id}}"><i class="fab fa-odnoklassniki-square fa-1x"></i></a>--}}
            </div>
        </div>
    </article>

    @php
        $user = \App\User::find($post->user_id);
    @endphp
    <div class="post-author-avatar my-4 clearfix">
        <div class="float-left">
            <img alt="{{$user->full_name}}" src="{{ isset($user->avatar) ? asset($user->avatar) : asset('/images/avatar/default/no-photo-male.png') }}" height="100" width="100">
        </div>
        <div class="post-info ml-4 float-left">
            <h4>{{$user->full_name}}
                <small>/ Об Авторе</small>
            </h4>
            <div class="post-author-description">
                {{$user->description}}
            </div>
            <div class="post-author-posts-link">
                <a href="{{route('author', ['name' => $user->full_name, 'id' => $user->id])}}">Ещё посты автора</a>
            </div>
        </div>
    </div>

    {{--Похожие статьи--}}
    {{--@include('blog.related_post')--}}
    {{--Комментарии--}}
    {{--@include('blog.comments_block', ['comments' => $comments])--}}


    {{-- Гипер комментарии Комментарии--}}
    @include('blog.hyper_comments')
</div>
@else
    <h2>Эта запись не опубликована. Пожалуйста загляните сюда чуточку позже.</h2>
    <img class="img-responsive" src="{!! asset('images/bg/header/img_header_master_class.jpg') !!}" alt="{{$post->alt}}">
@endif
@endsection