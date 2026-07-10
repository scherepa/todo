<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskEditRequest;
use App\Http\Traits\TaskHelperTrait;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use \Throwable;

class TaskController extends Controller
{
    use TaskHelperTrait;

    /**
     * Home
     *
     * @return View
     */
    public function welcome(): View
    {
        return view('welcome');
    }

    /**
     * Fetch task all
     *
     * 
     * @return JsonResponse
     */
    public function tasksFetchAllAjax(): JsonResponse
    {   
        return response()->json(
            $this->grouppedTasks()
        );
    }

    /**
     * Fetch task by id
     *
     * @param int $id
     * @return JsonResponse
     */    
    public function taskFetchOneAjax(int $id): JsonResponse
    {
        $task = Task::find($id);
        return response()->json(
            compact('task')
        );
    }

    /**
     * Update Task completed/title
     *
     * @param TaskEditRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function taskEditAjax(TaskEditRequest $request, int $id): JsonResponse
    {
        // glitch/abuse protection on back end
        $lock = Cache::lock("editing_task_{$id}", 10);
        if (!$lock->get()) {
            return response()->json(
                ['error' => 'already in process'],
                409
            );
        }
        try {
            Task::query()
                ->where('id', $id)
                ->update($request->validated());
            return response()->json([
                'task' => Task::findOrFail($id)
            ]);
        } catch(Throwable $error) {
            // document it
            report($error);
            // return general
            return response()->json([
                'error' => 'Something went wrong'
            ], 400);
        } finally {
            $lock->release();
        }   
    }

    /**
     * Create Task
     *
     * @param TaskCreateRequest $request
     * @return JsonResponse
     */
    public function taskCreateAjax(TaskCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        // We will add it to DOM
        return response()->json(compact('task'));
    }

    /**
     * Update Task completed/title
     *
     * @param int $id
     * @return JsonResponse
     */
    public function taskDestroyAjax(int $id): JsonResponse
    {
        Task::query()
            ->where('id', $id)
            ->delete();
        // only needs confirmation
        // to knoww what to remove from DOM
        return response()->json([
            'id' => $id
        ]);
    }
    
}
