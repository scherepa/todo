<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;



Route::get('/', [TaskController::class, 'welcome'])->name('home');

Route::prefix('tasks')
    ->controller(TaskController::class)
    ->group(function() {
        // Fetch All ajax(if needed reload for only tasks without refresh or if decided on polling)
        Route::get('/', 'tasksFetchAllAjax')->name('fetchAllTasks');
        // Task View 
        Route::get('/{id}', 'taskFetchOneAjax')->where('id', '[0-9]+')->name('fetchOneTask');
        // Edit task
        Route::post('/edit/{id}', 'taskToggleAjax')->where('id', '[0-9]+')->name('updateTaskV1');
        // Toggle task
        Route::post('/{id}/toggle', 'taskToggleAjax')->where('id', '[0-9]+')->name('toggleTask');
        // Create task
        Route::post('/', 'taskCreateAjax')->name('createTask');
        // Delete task(Ajax)
        Route::post('/{id}', 'taskDestroyAjax')->where('id', '[0-9]+')->name('destroyTask');
    });
