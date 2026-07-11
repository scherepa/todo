@extends('layouts.layout')
@section('page_name', 'Tasks')
@section('content')
<small class="italic my-2"> ** used components</small>
<div class="card mx-auto">
    <div class="card-body" id="tasks_card">
        Loading...
    </div>
</div>
@endsection

@push('scripts')
<script type='module'>  
function loadTasks(url) {
    const data = {
        search: $('#search_todos').val() ?? '',
        status: $('#filter_todos').val() ?? 'all'
    };
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function(response) {
            $('#tasks_card').html(response.html);
            $('#pagination_links a').on('click', function(e) {
                e.preventDefault();
                loadTasks($(this).attr('href'));
            });
            $('.deleteTask').on('click', function() {
                let taskId = $(this).data('ps');
                let currentPage = $('#current_page').val() ?? 1;
                $.ajax({
                    url: `tasks/${taskId}`,
                    type: 'POST',
                    data: [],
                    success: function(response) {
                        //parse and append
                        console.log(response)
                        let taskId = response.id;
                        if (!taskId) {
                            return;
                        }
                        
                        loadTasks(`tasks/?page=${currentPage}`);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        loadTasks(`tasks/?page=${currentPage}`);
                    }
                });
            });
            $('.updateTask').on('click', function() {
                let taskId = $(this).data('ps');
                let currentPage = $('#current_page').val() ?? 1;
                let isCompleted = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    url: `tasks/${taskId}/toggle`,
                    type: 'POST',
                    data: {
                        completed: isCompleted,
                    },
                    success: function(response) {
                        loadTasks(`tasks/?page=${currentPage}`);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        loadTasks(`tasks/?page=${currentPage}`);
                    }
                });
            });

            $('#apply_filters').on('click', function() {
                    loadTasks(`tasks/?page=1`);
            });
            $('#saveTask').on('click', function (e) {
                e.preventDefault();
                let taskData = {
                    title: $('#title').val(),
                    completed: $('#completed').prop('checked'),
                };
                $.ajax({
                    url: 'tasks',
                    type: 'POST',
                    data: taskData,
                    success: function(response) {
                        let task = response.task;
                        if (!task?.id) {
                            return;
                        }
                        $('#title').val('');
                        $('#completed').prop('checked', false);
                        let currentPage = $('#current_page').val() ?? 1;
                        loadTasks(`tasks/?page=${currentPage}`);
                    }
                });
                
            });
            return;   
            }
    });
} 
$(document).ready(function(){
    loadTasks('tasks');
});
</script>
@endpush


