<div class="d-flex justify-content-around">
    <div class="form-check form-switch">
        <input class="form-check-input updateTask" type="checkbox" switch  {{ $task->completed ? "checked" : '' }} id={{ "completed_".$task->id }} data-ps={{$task->id}}>
        <label class="form-check-label visually-hidden" for={{ "completed_".$task->id }}>
            completed
        </label>
    </div>
    <button class="btn btn-outline-danger btn-sm deleteTask btn-pill py-0" data-ps={{ $task->id }} id={{ "delete_".$task->id }}>
        <small>delete</small>
    </button>
</div>
