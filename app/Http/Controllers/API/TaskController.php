<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService= $taskService;
    }

    public function index(Project $project):JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            self::FETCHED,
            new TaskResourceCollection($this->taskService->listTasks($project))
        );
    }

    public function store(Request $request, Project $project):JsonResponse
    {
        $request->validate([
            'name'=>['required'],
            'description'=> ['nullable']
        ], $request->all());

        $this->taskService->createTask($request, $project);

        return $this->response(
            Response::HTTP_CREATED,
            self::CREATED
        );

    }

    public function show(Task $task):JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            self::FETCHED,
            ['task'=> new TaskResource($task)]
        );
    }

    public function update(Request $request, Task $task):JsonResponse
    {
        $request->validate([
            'name'=>['nullable'],
            'complete'=>['nullable', 'boolean'],
            'description'=> ['nullable']
        ], $request->all());

       $this->taskService->updateTask($request, $task);

        return $this->response(
            Response::HTTP_OK,
            self::UPDATED,
            [ 'task' => new TaskResource($task->refresh())]
        );
    }

    public function bulkComplete(Request $request):JsonResponse
    {
        $request->validate([
            'tasks'=>['array'],
            'tasks.id*'=> ['exists:tasks'],
            'complete'=> ['bool']
        ]);

        $this->taskService->bulkCompleteTasks($request);

        return $this->response(Response::HTTP_OK, self::UPDATED);
    }

    public function destroy(Task $task):JsonResponse
    {
        $this->taskService->deleteTask($task);

        return $this->response(
            Response::HTTP_OK,
            self::ARCHIVED
        );
    }
}
