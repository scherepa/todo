<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\Task;


trait TaskHelperTrait {

    protected function grouppedTasks(): array
    {
        $allTasks = Task::orderBy('id')
            ->get();
        return [
            'all' => $allTasks->all(),
            'completed' => $allTasks->filter(fn($task) => $task->completed)->all(),
            'undergoing' =>  $allTasks->filter(fn($task) => !$task->completed)->all(),
        ];
    }
}

