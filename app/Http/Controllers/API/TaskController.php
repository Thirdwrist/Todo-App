<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        return new TaskResourceCollection($project->tasks);
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name'=>['required'],
            'description'=> ['nullable']
        ], $request->all());

        $project->tasks()
            ->create($request->only('name', 'description'));

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

        $task->update($request->only(['name', 'complete', 'description']));

        return $this->response(
            Response::HTTP_OK,
            'updated successfully',
            [ 'task' => new TaskResource($task->refresh())]
        );
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return $this->response(
            Response::HTTP_OK,
            'archived successfully'
        );
    }
}
