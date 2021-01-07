<?php


namespace App\Services;


use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function listProjects():Collection
    {
        return $this->projectRepository->all();
    }

    public function findProjectById(int $id):Project
    {
        return $this->projectRepository->find($id);
    }

    public function createProject(Request $request):Project
    {
        return $this->projectRepository->create([
            'name'=>$request->name,
            'description'=> $request->description??null,
            'user_id'=> auth()->id()
        ]);
    }

    public function updateProject(Request $request, Project $project):bool
    {
        return $this->projectRepository->update(
            $request->only(['name', 'description']),
            $project
        );
    }

    public function deleteProject(Project $project):?bool
    {
        return $this->projectRepository->delete($project);
    }
}