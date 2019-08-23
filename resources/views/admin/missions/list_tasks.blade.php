<ul class="list_tasks list-unstyled">
    <?php $i=1;?>
    @foreach($list_tasks as $list_task)
        <li class="list-group-item">
            {{$i++.'.'}}{!! Form::checkbox('task_id', $list_task->id) !!} {{$list_task->task}}
        </li>
    @endforeach
</ul>