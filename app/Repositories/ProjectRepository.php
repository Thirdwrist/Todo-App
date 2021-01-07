<?php


namespace App\Repositories;


use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    public function all():Collection
    {
        return Project::all();
    }
    public function create(array $data):Project
    {
       return Project::create($data);
    }

    public function update(array $data, Project $project):bool
    {
        return $project->update($data);
    }

    public function find($id):Project
    {
        return Project::find($id);
    }

    public function delete(Project $project):?bool
    {
        return $project->delete();
    }
}