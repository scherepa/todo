<div id="nTask" class="p-2">
    <fieldset class="border rounded-4 mb-2 p-2">
    <div><span class="badge rounded-pill text-bg-dark">new</span></div>
    <hr/>
    <div class="d-flex justify-content-around allign-items-end p-2">
        <div>
            <label for="title" class="visually-hidden">Title</label>
            <input type="text" class="form-control-sm border" id="title" placeholder="Enter Task Title">
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" value="" id="completed" switch>
            <label class="form-check-label" for="completed">
                completed
            </label>
        </div>
        <div>
            <button class="btn btn-outline-success btn-sm py-0" id="saveTask">
                save
            </button>
        </div>
    </div>
    </fieldset>
    <div class="bg-danger text-danger hidden bg-opacity-10" id="new_task_errors"></div>
</div>
