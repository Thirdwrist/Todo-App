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
            'success',
            new TaskResourceCollection($this->taskService->listTasks($project))
        );
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name'=>['required'],
            'description'=> ['nullable']
        ], $request->all());

        $this->taskService->createTask($request, $project);

        return $this->response(
            Response::HTTP_CREATED,
            'created successfully'
        );

    }

    public function show(Project $project, Task $task)
    {
        return $this->response(
            Response::HTTP_OK,
            'success',
            ['task'=> new TaskResource($task)]
        );
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'name'=>['nullable'],
            'complete'=>['nullable', 'boolean'],
            'description'=> ['nullable']
        ], $request->all());

       $this->taskService->updateTask($request, $task);

        return $this->response(
            Response::HTTP_OK,
            'updated successfully',
            [ 'task' => new TaskResource($task->refresh())]
        );
    }

    public function destroy(Project $project, Task $task)
    {
        $this->taskService->deleteTask($task);

        return $this->response(
            Response::HTTP_OK,
            'archived successfully'
        );
    }
}
