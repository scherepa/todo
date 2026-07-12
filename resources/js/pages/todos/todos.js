function loadTasks(url, target = '') {
    const data = {
        search: $('#search_todos').val() ?? '',
        status: $('#filter_todos').val() ?? 'all'
    };
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        beforeSend: function () {
            if (target !== '' && !$(target).prop('disabled')) {
                $(target).prop('disabled', true);
            }
        },
        success: function (response) {
            if (!response?.html) {
                return;
            }
            $('#tasks_card').html(response.html);
        },
        complete: function () {
            if (target !== '' && $(target).prop('disabled')) {
                $(target).prop('disabled', false);
            }
        }
    });
}
$(document).ready(function () {
    loadTasks('tasks');
    const $card = $('#tasks_card');
    $card.on('click', '.deleteTask', function () {
        let taskId = $(this).data('ps');
        let currentPage = $('#current_page').val() ?? 1;
        let targetId = `#delete_${taskId}`;
        $.ajax({
            url: `tasks/${taskId}`,
            type: 'POST',
            data: [],
            beforeSend: function () {
                $(targetId).prop('disabled', true);
            },
            success: function (response) {
                let taskId = response.id;
                if (!taskId) {
                    return;
                }
                loadTasks(`tasks/?page=${currentPage}`, '.deleteTask');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                loadTasks(`tasks/?page=${currentPage}`);
                console.log(textStatus);
            }
        });
    });
    $card.on('click', '#pagination_links a', function (e) {
        e.preventDefault();
        loadTasks($(this).attr('href'), '#pagination_links a');
    });
    $card.on('click', '#apply_filters', function () {
        loadTasks(`tasks/?page=1`, '#apply_filters');
    });
    $card.on('click', '.updateTask', function () {
        let taskId = $(this).data('ps');
        let currentPage = $('#current_page').val() ?? 1;
        let isCompleted = $(this).prop('checked') ? 1 : 0;
        let targetId = `#completed_${taskId}`;
        $.ajax({
            url: `tasks/${taskId}/toggle`,
            type: 'POST',
            data: {
                completed: isCompleted,
            },
            beforeSend: function () {
                $(targetId).prop('disabled', true);
            },
            success: function (response) {
                loadTasks(`tasks/?page=${currentPage}`, targetId);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                loadTasks(`tasks/?page=${currentPage}`);
                console.log(textStatus);
            }
        });
    });
    $card.on('click', '#saveTask', function (e) {
        e.preventDefault();
        let taskData = {
            title: $('#title').val(),
            completed: $('#completed').prop('checked'),
        };
        $.ajax({
            url: 'tasks',
            type: 'POST',
            data: taskData,
            beforeSend: function () {
                $('#saveTask').prop('disabled', true);
            },
            success: function (response) {
                let task = response.task;
                if (!task?.id) {
                    return;
                }
                $('#title').val('');
                $('#completed').prop('checked', false);
                let currentPage = $('#current_page').val() ?? 1;
                loadTasks(`tasks/?page=${currentPage}`, '#saveTask');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });
});
