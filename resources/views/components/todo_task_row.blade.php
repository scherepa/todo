@if (!empty($task))
<div class="row row-cols-2 p-2" id={{ $task->name."_row_".$task->id }}>
    <div class="col">
        {{$task->title}}
    </div>
    <div class="col">
       {{-- @include('components.todos_row_actions', [$task])--}}
    </div>
</div>

@endif
