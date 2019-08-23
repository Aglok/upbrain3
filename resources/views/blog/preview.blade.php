 <!--Центральный блог для статей-->
        <article id="post_{{$post_list->id}}" class="blog-post py-3">
            <h3>
                <a href="{{route('post', ['id' => $post_list->id]).'/'.$post_list->link}}" title="{{$post_list->title}}">{{$post_list->title}}</a>
            </h3>
            <div class="post-info">
                <div class="item-info">
                    <span class="fa fa-clock"></span>
                    {{$post_list->createdAt()}}
                </div>
                <div class="item-info">
                    <span class="fa fa-comments"></span>
                    <a href="{{route('post', ['id' => $post_list->id])}}">
                        <span data-xid="{{$post_list->id}}" class="count-comments"></span>
                    </a>
                </div>
                <div class="item-info float-right">
                    @if(count($post_list->arrayTags()))
                        <span class="fa fa-tag"></span>
                    @endif
                    @foreach($post_list->arrayTags() as $tag)
                            <a href="{{route('tag', ['name' => $tag->name,'id' => $post_list->id])}}">{{$tag->name}}</a>
                            @if(!$loop->last)
                                <span> , </span>
                            @endif
                    @endforeach
                </div>
            </div>
            <div class="post-image my-3">
                @if($post_list->image)
                    <img src="{{asset($post_list->image)}}" width="1170" height="500" class="img-fluid" alt="{{$post_list->title}}">
                @else
                    <img src="{{asset('images/bg/no_photo.jpg')}}" width="844" height="767" class="img-fluid" alt="{{$post_list->title}}">
                @endif
            </div>
            <div class="post-text">
                <p>{!! $post_list->cut !!}</p>
            </div>
            <div class="post-footer pb-5">
                <div class="float-left">
                    <i class="fas fa-id-badge"></i>
                    @if ($post_list->author())
                        <a href="{{route('author', ['name' => $post_list->author()->full_name, 'id' => $post_list->user_id])}}" title="{{$post_list->author()->full_name}}">
                            {{$post_list->author()->full_name}}
                        </a>
                    @else
                        Некто
                    @endif
                    <a class="ml-2" href="{{route('post', ['id' => $post_list->id])}}">
                        <span class="fas fa-comments"></span>
                        <span><span data-xid="{{$post_list->id}}" class="count-comments"></span> Комментариев</span>
                    </a>
                </div>
                <div class="float-right">
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-url="{{URL::current()}}" data-image="{{asset($post_list->image)}}" data-description="{{$post_list->cut}}" data-title="{{$post_list->title}}"></div>
                    {{--<a href="#" id="fb-{{$post_list->id}}"><i class="fab fa-facebook-square fa-1x"></i></a>--}}
                    {{--<a href="#" id="vk-{{$post_list->id}}"><i class="fab fa-vk fa-1x"></i></a>--}}
                    {{--<a href="#" id="tw-{{$post_list->id}}"><i class="fab fa-twitter fa-1x"></i></a>--}}
                    {{--<a href="#" id="ok-{{$post_list->id}}"><i class="fab fa-odnoklassniki-square fa-1x"></i></a>--}}
                </div>
            </div>
        </article>