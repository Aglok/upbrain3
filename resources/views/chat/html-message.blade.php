<li class="left clearfix media">
    <span class="chat-img pull-left">
      {{-- Проверка происходит через model users из-за метода setImage, вместо null возвращает объект--}}
        @if(!$thread->creator()->filename)
            <img src="{{ 'images/avatar/default/no-photo-male.png'}}" alt="{{ $thread->creator()->login }}" class="img-circle avatar">
        @else
            <img src="{{ 'images/avatar/'.$thread->creator()->avatar }}" alt="{{ $thread->creator()->login }}" class="img-circle avatar">

        @endif
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="primary-font">{{ $message->user->full_name }}</strong>
            <small class="pull-right text-muted"><i class="fa fa-clock-o fa-fw"></i> {{ $message->created_at->diffForHumans() }}</small>
        </div>
        <p>{{ $message->body }}</p>

        <?php
            $images = $message->images;
            $arrImages = explode('|', $images);
        ?>
        @if($images && $message->dir)
            <ul class="list-inline">
            @foreach($arrImages as $image)
                <li>
                    <a data-toggle="lightbox" href="{!! asset('images/'.$message->dir.'/'.$image) !!}">
                        {!! Html::image('images/'.$message->dir.'/'.$image, "$message->dir", ['class' => 'thumbnail', 'width' => '80px', 'data-toggle' => 'tooltip']) !!}
                    </a>
                </li>
            @endforeach
            </ul>
        @endif
    </div>
</li>
