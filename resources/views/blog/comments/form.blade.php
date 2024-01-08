{{--Форма отправки--}}
<div id="respond" class="comment-respond">
    <h3 id="reply-title" class="comment-reply-title">Оставить <span class="light">комментарий</span>
        <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display: none; text-decoration: line-through !important;">Отменить</a>
        </small>
    </h3>
    {!! Form::open(['route' => ['save_comments', $post->id],'id' => 'comment-form', 'class' => 'comment-form'])!!}
        <div class="row mb-2">
            <div class="col-xl-12">
                {{Form::textarea('text', '', ['id' => 'comment', 'cols' => 58, 'row' => 10, 'tabindex' => 4, 'placeholder' => 'Сообщение *'])}}
            </div>
        </div>
        <div class="row comment-form-fields">
            <div class="col-lg-6 comment-author-input">
                {{ Form::text('name','',['id' => 'comment-name', 'size' => 22, 'placeholder' => 'Имя *', 'aria-required' => 'true']) }}
            </div>
            <div class="col-lg-6 comment-email-input">
                {{ Form::text('email','',['id' => 'comment-email', 'size' => 22, 'placeholder' => 'Mail *', 'aria-required' => 'true']) }}
            </div>
        </div>

        <div class="form-submit gem-button-position-inline">
            {{Form::button('Отправить комментарий', ['type' => 'submit', 'id' => 'submit', 'class' => 'gem-button gem-button-size-medium submit'])}}
        </div>
        <p>
            {{Form::hidden('post_id', $post->id, ['id' => 'post_id'])}}
            {{Form::hidden('parent_id', '', ['id' => 'parent_id'])}}
        </p>
    {!! Form::close()!!}
</div>