<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="container py-6">
            <h1 class="display-1"><strong>Tasks</strong></h1>
            <div class="row mb-2 py-2" style="hight:300px;">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
                        <button class="nav-link" id="nav-completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed" type="button" role="tab" aria-controls="nav-completed" aria-selected="false">Completed</button>
                        <button class="nav-link" id="nav-undergoing-tab" data-bs-toggle="tab" data-bs-target="#nav-undergoing" type="button" role="tab" aria-controls="nav-undergoing" aria-selected="false">Undergoing</button>
                        <button class="nav-link" id="nav-new-task-tab" data-bs-toggle="tab" data-bs-target="#nav-new-task" type="button" role="tab" aria-controls="nav-new-task" aria-selected="false">New Task</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active py-2" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab" tabindex="0">
                    </div>
                    <div class="tab-pane fade py-2" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab" tabindex="0">
                    </div>
                    <div class="tab-pane fade py-2" id="nav-undergoing" role="tabpanel" aria-labelledby="nav-undergoing-tab" tabindex="0">
                    </div>
                    <div class="tab-pane fade p-2" id="nav-new-task" role="tabpanel" aria-labelledby="nav-new-task-tab" tabindex="0">
                        <div id="nTask" class="d-flex flex-column mb-2">
                            <div class="py-2">
                                <label for="title">Title</label>
                                <input type="text" id="title" placeholder="Enter Task Title">
                            </div>
                            <div class="py-2 form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="" id="completed" switch>
                                <label class="form-check-label" for="completed">
                                    Completed
                                </label>
                            </div>
                            <div class="py-2">
                                <button class="btn btn-outline-primary btn-sm my-2" id="saveTask">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded',function () {
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
            });

            const deleteTask = (id, completed) => {
                $.ajax({
                    url: `tasks/${id}`,
                    type: 'POST',
                    data: [],
                    success: function(response) {
                        let taskId = response.id;
                        if (!taskId) {
                            return;
                        }
                        let key = completed ? 'completed' : 'undergoing';
                        $(`#all_row_${taskId}`).remove();
                        $(`#${key}_row_${taskId}`).remove();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        loadTasks();
                    }
                });
            }

            loadTasks();

            const buildAllRow = (task, checked) => {
                return `
                            <div class="row row-cols-2 p-2" id="all_row_${task.id}">
                                <div class="col">${task.title}</div>
                                <div class="col">
                                    <div class="d-flex justify-content-around">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" switch  ${checked} id="all_completed_${task.id}" onClick="updateTask(this,${task.id})">
                                            <label class="form-check-label visually-hidden" for="all_completed_${task.id}">
                                            Completed
                                            </label>
                                        </div>
                                        <div class="btn btn-outline-danger btn-sm" onClick="deleteTask(${task.id}, ${task.completed})">delete</div>
                                    </div>
                                </div>
                            </div>
                        `;
            }

            function loadTasks() {
                $.ajax({
                    url: 'tasks',
                    type: 'GET',
                    success: function(response) {
                        //parse and append
                        
                        let [all, completed, undergoing] = [response.all, response.completed, response.undergoing];
                        for (const task of all) {
                            if(!task.id) {
                                continue;
                            }
                            $(`div[id$="_row_${task.id}"]`).remove();
                            let elAllTask = buildAllRow(task, task.completed ? 'checked' : '');
                            $('#nav-all').append(elAllTask);
                            if(task.completed === false) {
                                $('#nav-undergoing').append(elAllTask.replaceAll('all_','undergoing_'));
                            } else {
                                $('#nav-completed').append(elAllTask.replaceAll('all_','completed_'));
                            }
                        }
                        return;
                        let task = response.task;
                        if (!task?.id) {
                            return;
                        }
                        $('#title').val('');
                        $('#completed').prop('checked', false);
                        let checked = task.completed ? 'checked' : '';
                        let newAllElement = buildAllRow(task, checked);
                        $('#nav-all').append(newAllElement);
                        if(task.completed === false) {
                            $('#nav-undergoing').append(newAllElement.replaceAll('all_','undergoing_'));
                        } else {
                            $('#nav-completed').append(newAllElement.replaceAll('all_','completed_'));
                        }
                    }
                });
            }

            
            
            $('#saveTask').on('click', function (e) {
                e.preventDefault();
                let taskData = {
                    title: $('#title').val(),
                    completed: $('#completed').prop('checked')
                };
                $.ajax({
                    url: 'tasks',
                    type: 'POST',
                    data: taskData,
                    success: function(response) {
                        //parse and append
                        let task = response.task;
                        if (!task?.id) {
                            return;
                        }
                        $('#title').val('');
                        $('#completed').prop('checked', false);
                        let checked = task.completed ? 'checked' : '';
                        let newAllElement = buildAllRow(task, checked);
                        $('#nav-all').append(newAllElement);
                        if(task.completed === false) {
                            $('#nav-undergoing').append(newAllElement.replaceAll('all_','undergoing_'));
                        } else {
                            $('#nav-completed').append(newAllElement.replaceAll('all_','completed_'));
                        }
                    }
                });
            });

            const updateTask = (el, id) => {
                
                let completed =  $(el).prop('checked') ? 1 : 0;
                $.ajax({
                    url: `tasks/edit/${id}`,
                    type: 'POST',
                    data: {
                        completed: completed
                    },
                    success: function(response) {
                        //parse and append/update
                        let task = response.task;
                        if (!task.id) {
                            return;
                        }
                        let [keyTo, keyFrom, checked] = completed === 1 ? ['completed', 'undergoing','checked']:['undergoing', 'completed', ''];
                        
                        let newEl = buildAllRow(task, checked);
                        let allKey = el.id.replace(keyFrom, 'all')
                        $(`div[id$="_row_${task.id}"]`)
                        .not($(`#all_row_${task.id}`))
                        .remove();
                        $(`#${allKey}`).prop('checked', task.completed);
                        $(`#nav-${keyTo}`).append(newEl);
                    }
                });
            }
            window.deleteTask = deleteTask;
            window.updateTask = updateTask;
        });
        
        </script>
    </body>
</html>
