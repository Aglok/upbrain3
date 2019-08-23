<li class="left clearfix">
    <span class="chat-img pull-left">
        <img src="http://placehold.it/50/55C1E7/fff" alt="{!! $message->user->first_name !!}" class="img-circle">
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="primary-font">{{ $message->user->full_name }}</strong>
            <small class="pull-right text-muted"><i class="fa fa-clock-o fa-fw"></i> {{ $message->created_at->diffForHumans() }}</small>
        </div>
        <p>{{ $message->body }}</p>
    </div>
</li>
