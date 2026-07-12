<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait TaskHelperTrait {

    protected function grouppedTasks(Request $request): array
    {
        $query = Task::query();
        
        $search = $request->search ?? '';
        if ($search !== '') {
            $search = Str::of(preg_replace('/[^\p{L}0-9\s.,:()_-]+/u', '', $search))->trim()->value;
            $query = $query->where('title', 'like', '%'.$search.'%');
        }
        $status = $request->status ?? 'all';
        if ($status !== 'all') {
            $query = $query->where('completed', (bool) $status);
        }
        $tasks = $query->orderBy('id')->paginate(5);
        $currentPage = $tasks->currentPage();
        $html = view('components.todos_table', ['tasks' => $tasks, 'current_page' => $currentPage, 'search'=> $search, 'status' => $status])->render();
        return compact('html');
    }

    protected function grouppedTasksV1(): array
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

