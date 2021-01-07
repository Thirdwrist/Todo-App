<?php


namespace App\Repositories;


use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function listFromProject(Project $project):Collection
    {
        return $project->tasks;
    }

    public function all():Collection
    {
        return Task::all();
    }
    public function create(array $data):Task
    {
        return Task::create($data);
    }

    public function update(array $data, Task $task):bool
    {
        return $task->update($data);
    }

    public function find($id):Task
    {
        return Task::find($id);
    }

    public function delete(Task $task):?bool
    {
        return $task->delete();
    }
}