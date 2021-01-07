<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectResourceCollection;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index() :JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            self::FETCHED,
            new ProjectResourceCollection($this->projectService->listProjects())
        );
    }

    public function store(Request $request) :JsonResponse
    {
        $request->validate([
            'name'=>['required'],
            'description'=>['nullable'],
        ], $request->all());

        $this->projectService->createProject($request);
        return $this->response(Response::HTTP_CREATED, self::CREATED);
    }

    public function show(Project $project) :JsonResponse
    {
        return $this->response(
            Response::HTTP_OK,
            self::FETCHED,
            [ 'project' => new ProjectResource($project)]
        );
    }

    public function update(Request $request, Project $project) :JsonResponse
    {
        $this->projectService->updateProject($request, $project);

        return $this->response(
            Response::HTTP_OK,
            self::UPDATED,
            [ 'project' => new ProjectResource($project->refresh())]
        );
    }

    public function destroy(Project $project) :JsonResponse
    {
        $this->projectService->deleteProject($project);

        return $this->response(
            Response::HTTP_OK,
            self::ARCHIVED
        );
    }
}
