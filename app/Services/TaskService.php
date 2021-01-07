<?php


namespace App\Services;


use App\Models\Project;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TaskService
{
    protected $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function listTasks(Project $project) :Collection
    {
        return $this->taskRepository->listFromProject($project);
    }

    public function createTask(Request $request, Project $project):Task
    {
        return $this->taskRepository->create(
           [
               'name'=>$request->name,
               'description'=>$request->description,
               'project_id'=>$project->id
           ]
        );
    }

    public function updateTask(Request $request, Task $task):bool
    {
        return $this->taskRepository->update($request->only([
            'name',
            'description',
            'complete'
        ]), $task);
    }

    public function bulkCompleteTasks(Request $request):bool
    {
        return $this->taskRepository->bulkComplete(
            $request->tasks,
            $request->complete
        );
    }

    public function findTaskById(int $id):Task
    {
        return $this->taskRepository->find($id);
    }

    public function deleteTask(Task $task):?bool
    {
        return $this->taskRepository->delete($task);
    }
}